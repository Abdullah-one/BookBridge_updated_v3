<?php

namespace App\Http\Controllers\Api\Point;

use App\Http\Controllers\Api\PerformanceController;
use App\Http\Controllers\Controller;
use App\Jobs\AddToRemovalList;
use App\Jobs\RemoveDonation;
use App\Jobs\RemoveTransaction;
use App\Models\BookDonation;
use App\Models\ExchangePoint;
use App\Models\User;
use App\RepositoryPattern\BookDonationRepository;
use App\RepositoryPattern\ExchangePointRepository;
use App\RepositoryPattern\PerformanceRepository;
use App\RepositoryPattern\TransactionRepository;
use App\RepositoryPattern\UserRepository;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use PDOException;

class BookDonationController extends Controller
{
    protected BookDonationRepository $bookDonationRepository;
    protected UserRepository $userRepository;
    protected ExchangePointRepository $exchangePointRepository;
    protected PerformanceRepository $performanceRepository;

    protected TransactionRepository $transactionRepository;

    function __construct(BookDonationRepository $bookDonationRepository, UserRepository $userRepository,
                         ExchangePointRepository $exchangePointRepository, PerformanceRepository $performanceRepository,
                         TransactionRepository $transactionRepository)
    {
        $this->bookDonationRepository=$bookDonationRepository;
        $this->userRepository=$userRepository;
        $this->exchangePointRepository=$exchangePointRepository;
        $this->performanceRepository=$performanceRepository;
        $this->transactionRepository=$transactionRepository;
    }


    public function RejectByExchangePoint($bookDonation_id): void
    {
            $bookDonation = BookDonation::find($bookDonation_id); //database/var
            if(!$bookDonation){
                abort(404);
            }
            //TODO: Gate::authorize('IsPoint');
            //TODO: Gate::authorize('RejectAndConfirmByExchangePoint',[$bookDonation]);
        try {
            DB::beginTransaction();
            $beneficiary_id=$this->bookDonationRepository->getReservationOfBeneficiary($bookDonation_id)->user_id; //var
            $beneficiary=User::find($beneficiary_id);
            $semester = $bookDonation->semester;  //database/var
            $this->bookDonationRepository->updateReservation([
                'bookDonation_id' => $bookDonation_id,
                //TODO: correct the value of user_id to $beneficiary_id
                'user_id' => $beneficiary_id,
                'status' => 'بانتظار استلامها من المتبرع'
            ],
                [
                    'status' => 'تم إلغاء الحجز من البرنامج',
                    'activeOrSuccess' => false,
                ]);
            $this->bookDonationRepository->updateById($bookDonation_id, [
                'status' => 'تم رفض التبرع',
                'isHided' => true,
                'receiptDate' => Carbon::now(),
            ]);
            //TODO: change first Parameter of next method call on next line
            $userBookDonationController=app(\App\Http\Controllers\Api\User\BookDonationController::class);
            $userBookDonationController->decrementNo_booking($beneficiary, $semester);
            $bookDonation->exchangePoint()->decrement('no_packages');
            $performanceController=app(PerformanceController::class);
            $beneficiary->increment('no_donations');
            $performanceController->incrementStatus($bookDonation->exchangePoint_id,'no_rejectedDonation');
            $transaction=$this->transactionRepository->store($bookDonation_id,'تم رفض التبرع');
            DB::commit();
            RemoveTransaction::dispatch($transaction->id)->delay(now()->addDays(90));
        }
        catch (PDOException $exception){
            DB::rollBack();
            abort(500);
        }

    }

    public function confirmReceptionOfUnWaitedDonations($bookDonation_id): void
    {
        $bookDonation = BookDonation::find($bookDonation_id); //database/var
        if(!$bookDonation){
            abort(404);
        }
        //TODO: Gate::authorize('IsPoint');
        //TODO: Gate::authorize('RejectAndConfirmByExchangePoint',[$bookDonation]);
        try {
            DB::beginTransaction();
            $this->bookDonationRepository->updateById($bookDonation_id, [
                'status' => 'غير محجوز في النقطة',
                'receiptDate' => Carbon::now(),
            ]);
            $performanceController = app(PerformanceController::class);
            $performanceController->incrementStatus($bookDonation->exchangePoint_id, 'no_receivedDonation');
            $transaction = $this->transactionRepository->store($bookDonation_id, 'تم استلام التبرع');
            DB::commit();
            AddToRemovalList::dispatch($bookDonation->id)->delay(now()->addDays(30));
            RemoveTransaction::dispatch($transaction->id)->delay(now()->addDays(90));
        }
        catch (PDOException $exception){
            DB::rollBack();
            abort(500);
        }


    }

    public function getRemovalDonation(): JsonResponse
    {
        //TODO:Gate::authorize('isPoint');
        $account=auth()->user();
        $exchangePoint=ExchangePoint::where('account_id',$account->id)->first();
        return response()->json($this->bookDonationRepository->getRemovalDonation($exchangePoint->id));

    }

    public function removeByExchangePoint($id): void
    {
        $bookDonation=BookDonation::find($id);
        if(!$bookDonation){
            abort(404);
        }
        //TODO:Gate::authorize('isPoint');
        //TODO:Gate::authorize('removeDonationByExchangePoint',[$bookDonation]);
        $this->bookDonationRepository->removeByExchangePoint($bookDonation);

    }

    public function getDonationInPoint(): JsonResponse
    {
        //TODO:Gate::authorize('isPoint');
        $account=auth()->user();
        $exchangePoint=ExchangePoint::where('account_id',$account->id)->first();
        return response()->json($this->bookDonationRepository->getDonationInPoint($exchangePoint->id));

    }

    public function updateDonationInPoint($id,Request $request): JsonResponse
    {
        $bookDonation=BookDonation::find($id);
        if(!$bookDonation){
            abort(404);
        }


        //TODO:Gate::authorize('isPoint');
        //TODO:Gate::authorize('updateDonationInPoint',[$bookDonation]);
        $validator = Validator::make($request->all(), [
            'description'=>'max:1000',
        ],
            [
                'description.max'=>'يجب أن لا يتعدى النص 1000 حرف',
            ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }
        $hasReservation=$this->bookDonationRepository->getReservationOfBeneficiary($id);
        if(!$hasReservation){
            abort(1234);
        }
        $this->bookDonationRepository->update($bookDonation,
        [
            'level' => $request->level,
            'semester' => $request->semester,
            'description' => $request->description
        ]);
        return response()->json($bookDonation);


    }

    public function updateBookedDonationInPoint($id,Request $request): JsonResponse
    {
        $bookDonation=BookDonation::find($id);
        if(!$bookDonation){
            abort(404);
        }
        //TODO:Gate::authorize('isPoint');
        //TODO:Gate::authorize('updateDonationInPoint',[$bookDonation]);
        $reservation=$this->bookDonationRepository->getReservationOfBeneficiary($id);
        if(!$reservation){
            abort(1234);
        }
        $this->cancelBookingInPointByExchangePoint($bookDonation->id,$reservation->user_id);
        $this->bookDonationRepository->update($bookDonation,
            [
                'level' => $request->level,
                'semester' => $request->semester,
                'description' => $request->description
            ]);
        return response()->json($bookDonation);

    }

    public function cancelBookingInPointByExchangePoint(int $bookDonation_id,int $user_id): void
    {
        $user=User::find($user_id); //database/var
        $bookDonation=BookDonation::find($bookDonation_id); //database/var
        $semester=$bookDonation->semester;  //database/var

        try {
            DB::beginTransaction();
            $this->bookDonationRepository->updateReservation([
                'bookDonation_id' => $bookDonation_id,
                'user_id' => $user_id,
                'status' => 'بانتظار مجيئك واستلامها'
            ],
                [
                    'status' => 'تم إلغاء الحجز من البرنامج',
                    'activeOrSuccess' => false,
                    'code' => null
                ]);
            $this->bookDonationRepository->updateById($bookDonation_id, [
                'status' => 'غير محجوز في النقطة',
                'isHided' => false,
            ]);
            $userBookDonationController=app(\App\Http\Controllers\Api\User\BookDonationController::class);
            $userBookDonationController->decrementNo_booking($user,$semester);
            DB::commit();
            //TODO: notify the Beneficiary
        }
        catch (PDOException $exception){
            DB::rollBack();
            abort(500);
        }

    }


    public function getUnWaitedDonationsByPhoneNumber(Request $request): JsonResponse
    {
        //TODO: Gate::authorize('IsPoint');
        $phoneNumber=$request->phoneNumber;
        // $exchangePoint_id=auth()->user()->id;
        return response()->json($this->bookDonationRepository->getUnWaitedDonationsByPhoneNumber($phoneNumber,1));
    }

    public function confirmReceptionOfWaitedDonations($bookDonation_id): void
    {
        try {
            $bookDonation = BookDonation::find($bookDonation_id); //database/var
            if(!$bookDonation){
                abort(404);
            }
            DB::beginTransaction();
            //TODO: Gate::authorize('RejectAndConfirmOfWaitedDonationsByExchangePoint',[$bookDonation]);
            $beneficiary_id=$this->bookDonationRepository->getReservationOfBeneficiary($bookDonation_id)->user_id; //var
            $currentDate = \Illuminate\Support\Carbon::now(); //var
            $this->bookDonationRepository->updateReservation([
                'bookDonation_id' => $bookDonation_id,
                //TODO: correct the value of user_id to $beneficiary_id
                'user_id' => $beneficiary_id,
                'status' => 'بانتظار استلامها من المتبرع'
            ],
                [
                    'status' => 'بانتظار مجيئك واستلامها',
                    'activeOrSuccess' => true,
                    'code' => mt_rand(10000, 65500),
                    'startLeadTimeDateForBeneficiary' => $currentDate
                ]);
            $this->bookDonationRepository->updateById($bookDonation_id, [
                'status' => 'محجوز في انتظار التسليم',
                'isHided' => true,
                'receiptDate' => Carbon::now(),
            ]);
            $bookDonation->donorUser->increment('no_donations');
            $performanceController=app(PerformanceController::class);
            $performanceController->incrementStatus($bookDonation->exchangePoint_id,'no_receivedDonation');
            $transaction=$this->transactionRepository->store($bookDonation_id,'تم استلام التبرع',$beneficiary_id);
            DB::commit();
            RemoveTransaction::dispatch($transaction->id)->delay(now()->addDays(90));

        }
        catch (PDOException $exception){
            DB::rollBack();
            abort(500,$exception->getMessage());
        }
    }

    public function getWaitedDonationsByPhoneNumber(Request $request): JsonResponse
    {
        //TODO: Gate::authorize('IsPoint');
        $phoneNumber=$request->phoneNumber;
        // $user=auth()->user()->id;
        return response()->json($this->bookDonationRepository->getWaitedDonationsByPhoneNumber($phoneNumber,1));
    }

    public function getWaitedReservationsByPhoneNumber(Request $request): JsonResponse
    {
        //TODO: Gate::authorize('IsPoint');
        $phoneNumber=$request->phoneNumber; //var
        // $user=auth()->user()->id;
        return response()->json($this->bookDonationRepository->getWaitedReservationsByPhoneNumber($phoneNumber,3));
    }

    public function RejectFromBeneficiary($bookDonation_id): void
    {
        try {
            $bookDonation = BookDonation::find($bookDonation_id); //database/var
            if(!$bookDonation){
                abort(404);
            }
            //TODO: Gate::authorize('RejectFromBeneficiary',[$bookDonation]);
            $beneficiary_id=$this->bookDonationRepository->getReservationOfBeneficiary($bookDonation_id)->user_id; //var
            $beneficiary=User::find($beneficiary_id);
            $semester = $bookDonation->semester;  //database/var
            $this->bookDonationRepository->updateReservation([
                'bookDonation_id' => $bookDonation_id,
                //TODO: correct the value of user_id to $beneficiary_id
                'user_id' => $beneficiary_id,
                'status' => 'بانتظار مجيئك واستلامها'

            ],
                [
                    'status' => 'المستفيد لم يقبل حزمة الكتب',
                    'activeOrSuccess' => false,
                    'code' => null
                ]);
            $this->bookDonationRepository->updateById($bookDonation_id, [
                'status' => 'غير محجوز في النقطة',
                'isHided' => false,
                'no_rejecting' => DB::raw('no_rejecting + 1')
            ]);
            $isRemovable=$this->checkIsRemovable($bookDonation);
            if($isRemovable){
                $bookDonation->update([
                    'isRemovable' => true
                ]);
            }
            $userBookDonationController=app(\App\Http\Controllers\Api\User\BookDonationController::class);// var
            $userBookDonationController->decrementNo_booking($beneficiary, $semester);
            $performanceController=app(PerformanceController::class); //var
            $performanceController->incrementStatus($bookDonation->exchangePoint_id,'no_rejectedDonationFromBeneficiary');
            $transaction=$this->transactionRepository->store($bookDonation_id,'تم رفض الاستلام',$beneficiary_id);
            DB::commit();
            RemoveTransaction::dispatch($transaction->id)->delay(now()->addDays(90));
            RemoveDonation::dispatch($bookDonation_id)->delay(now()->addDays(365));
        }
        catch (PDOException $exception){
            DB::rollBack();

            abort(500,$exception->getMessage());
        }

    }

    public function checkIsRemovable($bookDonation): bool
    {
        return $bookDonation->no_rejecting == 3;
    }

    public function confirmDelivery($bookDonation_id, Request $request): void
    {
        try {
            $bookDonation = BookDonation::find($bookDonation_id); //database/var
            if(!$bookDonation){
                abort(404);
            }
            $code=$request->code;
            //TODO: Gate::authorize('confirmDelivery',[$bookDonation.$code]);
            DB::beginTransaction();
            $beneficiary_id=$this->bookDonationRepository->getReservationOfBeneficiary($bookDonation_id)->user_id; //var
            $beneficiary=User::find($beneficiary_id);
            $semester = $bookDonation->semester;  //database/var
            $this->bookDonationRepository->updateReservation([
                'bookDonation_id' => $bookDonation_id,
                //TODO: correct the value of user_id to $beneficiary_id
                'user_id' => $beneficiary_id,
                'status' => 'بانتظار مجيئك واستلامها'

            ],
                [
                    'status' => 'تم التسليم',
                    'code' => null,
                    'deliveryDate' => Carbon::now()
                ]);
            $this->bookDonationRepository->updateById($bookDonation_id, [
                'status' => 'تم التسليم',
            ]);
            //TODO: change first Parameter of next method call on next line
            $beneficiary->increment('no_benefits');
            $performanceController=app(PerformanceController::class); //var
            $bookDonation->exchangePoint()->decrement('no_packages');
            $performanceController->incrementStatus($bookDonation->exchangePoint_id,'no_deliveredDonation');
            $transaction=$this->transactionRepository->store($bookDonation_id,'تم التسليم',$beneficiary_id);
            DB::commit();
            RemoveTransaction::dispatch($transaction->id)->delay(now()->addDays(90));
            RemoveDonation::dispatch($bookDonation_id)->delay(now()->addDays(365));

        }
        catch (PDOException $exception){
            DB::rollBack();
            abort(500);
        }

    }

    public  function getRejectedDonationsTransactions(): JsonResponse
    {
        Gate::authorize('IsPoint');
        //TODO: $exchangePoint=auth()->user()->exchangePoint()->id;
        return response()->json($this->transactionRepository->getRejectedDonationsTransactions(1));
    }

    public  function getReceptionDonationsTransactions(): JsonResponse
    {
        Gate::authorize('IsPoint');
        //TODO: $exchangePoint=auth()->user()->exchangePoint()->id;
        return response()->json($this->transactionRepository->getReceptionDonationsTransactions(1));
    }


    public  function getRejectedPackageFromBeneficiaryTransactions(): JsonResponse
    {
        Gate::authorize('IsPoint');
        //TODO: $exchangePoint=auth()->user()->exchangePoint()->id;
        return response()->json($this->transactionRepository->getRejectedPackageFromBeneficiaryTransactions(1));
    }

    public  function getDeliveredDonationsTransactions(): JsonResponse
    {
        Gate::authorize('IsPoint');
        //TODO: $exchangePoint=auth()->user()->exchangePoint()->id;
        return response()->json($this->transactionRepository->getDeliveredDonationsTransactions(1));
    }

    public function getBookDonationInPoint(): JsonResponse
    {
        Gate::authorize('isPoint');
        $exchangePoint_id=auth()->user->exchangePoint->id;
        return response()->json($this->bookDonationRepository->getBookDonationInPoint($exchangePoint_id));

    }

    public function getRemovableDonation()
    {
        Gate::authorize('isPoint');
        $exchangePoint_id=auth()->user->exchangePoint->id;
        return response()->json($this->bookDonationRepository->getRemovableDonation($exchangePoint_id));


    }










}
