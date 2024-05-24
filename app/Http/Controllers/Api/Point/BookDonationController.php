<?php

namespace App\Http\Controllers\Api\Point;

use App\Http\Controllers\Api\NotificationController;
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
use function PHPUnit\Framework\isEmpty;

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

    public function getFcm_token($user_id){
        return User::find($user_id)->account->fcm_token;
    }


    public function RejectByExchangePoint($bookDonation_id): JsonResponse
    {
        try {
            $bookDonation = BookDonation::find($bookDonation_id); //database/var
            if(!$bookDonation){
                return response()->json(['status'=>'fail','message'=>'التبرع غير موجود']);
            }
            if (Gate::denies('isPoint',[$bookDonation])) {
                return response()->json(['status' => 'fail', 'message' => 'غير مصرح لهذا الفعل']);
            }
            if (Gate::denies('RejectAndConfirmByExchangePoint',[$bookDonation])) {
                return response()->json(['status' => 'fail', 'message' => 'غير مصرح لهذا الفعل']);
            }
            DB::beginTransaction();
            $reservation=$this->bookDonationRepository->getReservationOfBeneficiary($bookDonation_id);
            $reservation_id=$reservation->id;
            $beneficiary_id=$reservation->user_id; //var
            $beneficiary=User::find($beneficiary_id);
            $semester = $bookDonation->semester;  //database/var
            $this->bookDonationRepository->updateReservation([
                'bookDonation_id' => $bookDonation_id,
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
            $userBookDonationController=app(\App\Http\Controllers\Api\User\BookDonationController::class);
            $userBookDonationController->decrementNo_booking($beneficiary, $semester);
            $bookDonation->exchangePoint()->decrement('no_packages');
            $performanceController=app(PerformanceController::class);
            User::find($bookDonation->donor_id)->increment('no_donations');
            $performanceController->incrementStatus($bookDonation->exchangePoint_id,'no_rejectedDonation');
            $transaction=$this->transactionRepository->store($bookDonation_id,'تم رفض التبرع',$bookDonation->donor_id);
            DB::commit();
            RemoveTransaction::dispatch($transaction->id)->delay(now()->addDays(90));
//            $notificationController=new NotificationController();
//            $notificationController->create(
//                [
//                    'data'=>[
//                        'title'=>'تم إلغاء حجزك',
//                        'message'=>'تم إلغاء حجزك بسبب إلغاء الحجز من المنصة ب id {$reservation_id} ,  يرجى مراجعة صفحة حجوزاتي ثم حجوزات لم تتم ',
//
//                        'account_id'=>$beneficiary_id
//                    ],
//                'token'=> $this->getFcm_token($beneficiary_id)
//                ]
//           );
//            $notificationController->create(
//                [
//                    'data'=>[
//                        'title'=>'شكرا لتبرعك',
//                        'message'=>'شكرا لتبرعك ونعتذر عن عدم قبول تبرعك ب id {$bookDonation->id} ,  يرجى مراجعة صفحة تبرعاتي ثم تبرعات مرفوضة ',
//
//                        'account_id'=>$bookDonation->donor_id
//                    ],
//                'token'=> $this->getFcm_token($bookDonation->donor_id)
//                ]
//            );
            return response()->json(['status' => 'success']);
        }
        catch (PDOException $exception){
            DB::rollBack();

            return response()->json(['status'=>'fail','message'=>'هناك خطأ بالخادم']);
        }

    }

    public function confirmReceptionOfUnWaitedDonations($bookDonation_id)
    {
        try {
            $bookDonation = BookDonation::find($bookDonation_id); //database/var
            if(!$bookDonation){
                return response()->json(['status'=>'fail','message'=>'التبرع غير موجود']);
            }
            if (Gate::denies('isPoint',[$bookDonation])) {
                return response()->json(['status' => 'fail', 'message' => 'غير مصرح لهذا الفعل']);
            }
            if (Gate::denies('RejectAndConfirmByExchangePoint',[$bookDonation])) {
                return response()->json(['status' => 'fail', 'message' => 'غير مصرح لهذا الفعل']);
            }

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

    public function confirmReceptionOfWaitedDonations($bookDonation_id)
    {
        try {
            $bookDonation = BookDonation::find($bookDonation_id); //database/var
            if(!$bookDonation){
                return response()->json(['status'=>'fail','message'=>'التبرع غير موجود']);
            }
            if (Gate::denies('isPoint')) {
                return response()->json(['status' => 'fail', 'message' => 'غير مصرح لهذا الفعل']);
            }
            if (Gate::denies('RejectAndConfirmOfWaitedDonationsByExchangePoint',[$bookDonation])) {
                dd(true);
                return response()->json(['status' => 'fail', 'message' => 'غير مصرح لهذا الفعل']);
            }
            DB::beginTransaction();
            $reservation=$this->bookDonationRepository->getReservationOfBeneficiary($bookDonation_id);
            $beneficiary_id=$reservation->user_id; //var
            $currentDate = \Illuminate\Support\Carbon::now(); //var
            $this->bookDonationRepository->updateReservation([
                'bookDonation_id' => $bookDonation_id,
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
            $transaction=$this->transactionRepository->store($bookDonation_id,'تم استلام التبرع',$bookDonation->donor_id);
            DB::commit();
            RemoveTransaction::dispatch($transaction->id)->delay(now()->addDays(90));
//            $notificationController=new NotificationController();
//            $notificationController->create(
//                [
//                    'data'=>[
//                        'title'=>'تم وصول حجزك',
//                        'message'=>'تم وصول حجزك ب id {$reservation->id} ,  يرجى مراجعة صفحة حجوزاتي ثم حجوزات بانتظار استلامها ',
//
//                        'account_id'=>$beneficiary_id
//                    ],
//                'token'=> $this->getFcm_token($beneficiary_id)
//                ]
//           );
//            $notificationController->create(
//                [
//                    'data'=>[
//                        'title'=>'شكرا لتبرعك',
//                        'message'=>'شكرا لتبرعك تم استلام تبرعكم ب id {$bookDonation->id} ,  يرجى مراجعة صفحة تبرعاتي ثم تبرعات تم تسليمها ',
//
//                        'account_id'=>$bookDonation->donor_id
//                    ],
//                'token'=> $this->getFcm_token($bookDonation->donor_id)
//                ]
//            );
            return response()->json(['status'=>'success']);

        }
        catch (PDOException $exception){
            DB::rollBack();
            return response()->json(['status'=>'fail','message'=>'هناك خطأ بالخادم']);

        }
    }

    public function getWaitedDonationsByPhoneNumber(Request $request): JsonResponse
    {
        try {
            if (Gate::denies('isPoint')) {
                return response()->json(['status' => 'fail', 'message' => 'غير مصرح لهذا الفعل']);
            }
            $phoneNumber=$request->phoneNumber;
            $account_id=auth()->user()->exchangePoint->id;
            $result=$this->bookDonationRepository->getWaitedDonationsByPhoneNumber($phoneNumber,$account_id);
            if($result->isEmpty()){
                return response()->json(['status'=>'fail','message'=>"لا توجد تبرعات منتظر استلامها بهذا الرقم في هذه النقطة"]);
            }
            return response()->json(['status'=>'success','data'=>$result]);
        }
        catch (PDOException $exception){
            DB::rollBack();
            return response()->json(['status'=>'fail','message'=>'هناك خطأ بالخادم']);

        }
    }

    public function getWaitedReservationsByPhoneNumber(Request $request): JsonResponse
    {
        try {
            if (Gate::denies('isPoint')) {
                return response()->json(['status' => 'fail', 'message' => 'غير مصرح لهذا الفعل']);
            }
            $phoneNumber=$request->phoneNumber;
            $account_id=auth()->user()->exchangePoint->id;
            $result=$this->bookDonationRepository->getWaitedReservationsByPhoneNumber($phoneNumber,$account_id);
            if($result->isEmpty()){
                return response()->json(['status'=>'fail','message'=>"لا توجد حجوزات منتظر تسليمها بهذا الرقم في هذه النقطة"]);
            }
            return response()->json(['status'=>'success','data'=>$result]);
        }
        catch (PDOException $exception){
            DB::rollBack();
            return response()->json(['status'=>'fail','message'=>'هناك خطأ بالخادم']);

        }
    }

    public function RejectFromBeneficiary($bookDonation_id):JsonResponse
    {
        try {
            $bookDonation = BookDonation::find($bookDonation_id); //database/var
            if(!$bookDonation){
                return response()->json(['status'=>'fail','message'=>'التبرع غير موجود']);
            }
            if (Gate::denies('isPoint')) {
                return response()->json(['status' => 'fail', 'message' => 'غير مصرح لهذا الفعل']);
            }
            if (Gate::denies('RejectFromBeneficiary',[$bookDonation])) {
                return response()->json(['status' => 'fail', 'message' => 'غير مصرح لهذا الفعل']);
            }
            $beneficiary_id=$this->bookDonationRepository->getReservationOfBeneficiary($bookDonation_id)->user_id; //var
            $beneficiary=User::find($beneficiary_id);
            $semester = $bookDonation->semester;  //database/var
            $this->bookDonationRepository->updateReservation([
                'bookDonation_id' => $bookDonation_id,
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
            return response()->json(['status'=>'success']);
        }
        catch (PDOException $exception){
            DB::rollBack();
            return response()->json(['status'=>'fail','message'=>'هناك خطأ بالخادم']);

        }

    }

    public function checkIsRemovable($bookDonation): bool
    {
        return $bookDonation->no_rejecting == 3;
    }

    public function confirmDelivery($bookDonation_id, Request $request): JsonResponse
    {
        try {
            $code=$request->code;
            $bookDonation = BookDonation::find($bookDonation_id); //database/var
            if(!$bookDonation){
                return response()->json(['status'=>'fail','message'=>'التبرع غير موجود']);
            }
            if (Gate::denies('isPoint')) {
                return response()->json(['status' => 'fail', 'message' => 'غير مصرح لهذا الفعل']);
            }
            if (Gate::denies('confirmDelivery',[$bookDonation,$code])) {
                return response()->json(['status' => 'fail', 'message' => 'غير مصرح لهذا الفعل']);
            }
            DB::beginTransaction();
            $beneficiary_id=$this->bookDonationRepository->getReservationOfBeneficiary($bookDonation_id)->user_id; //var
            $beneficiary=User::find($beneficiary_id);
            $semester = $bookDonation->semester;  //database/var
            $this->bookDonationRepository->updateReservation([
                'bookDonation_id' => $bookDonation_id,
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
            $beneficiary->increment('no_benefits');
            $performanceController=app(PerformanceController::class); //var
            $bookDonation->exchangePoint()->decrement('no_packages');
            $performanceController->incrementStatus($bookDonation->exchangePoint_id,'no_deliveredDonation');
            $transaction=$this->transactionRepository->store($bookDonation_id,'تم التسليم',$beneficiary_id);
            DB::commit();
            RemoveTransaction::dispatch($transaction->id)->delay(now()->addDays(90));
            RemoveDonation::dispatch($bookDonation_id)->delay(now()->addDays(365));
            return response()->json(['status'=>'success']);
        }
        catch (PDOException $exception){
            DB::rollBack();
            return response()->json(['status'=>'fail','message'=>'هناك خطأ بالخادم']);

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
