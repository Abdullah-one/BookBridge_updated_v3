<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\PerformanceController;
use App\Http\Controllers\Controller;
use App\Http\Requests\BookDonation\addBookPackageDonationRequest;
use App\Jobs\CancelReservationInPointJob;
use App\Jobs\CancelReservationNotInPointJob;
use App\Jobs\RemoveReservation;
use App\Models\BookDonation;
use App\Models\ExchangePoint;
use App\Models\User;
use App\RepositoryPattern\BookDonationRepository;
use App\RepositoryPattern\ExchangePointRepository;
use App\RepositoryPattern\ImageRepository;
use App\RepositoryPattern\PerformanceRepository;
use App\RepositoryPattern\UserRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Mockery\Exception;
use PDOException;
use Throwable;

//use App\Http\Requests\Image\uploadImageRequest;

class BookDonationController extends Controller
{
    protected BookDonationRepository $bookDonationRepository;
    protected UserRepository $userRepository;
    protected ExchangePointRepository $exchangePointRepository;
    protected PerformanceRepository $performanceRepository;

    function __construct(BookDonationRepository $bookDonationRepository, UserRepository $userRepository,
                         ExchangePointRepository $exchangePointRepository, PerformanceRepository $performanceRepository)
    {
        $this->bookDonationRepository=$bookDonationRepository;
        $this->userRepository=$userRepository;
        $this->exchangePointRepository=$exchangePointRepository;
        $this->performanceRepository=$performanceRepository;

    }


    public function searchAvailableBookPackages(Request $request): JsonResponse
    {
        if (Gate::denies('isUser')) {
            return response()->json(['status'=>'fail','message'=>'غير مصرح لهذا الفعل']);
        }
        try {
            return $this->bookDonationRepository->searchAvailableBookPackages($request);
        }
        catch (Throwable $throwable){
            return response()->json(['status'=>'fail','message'=>'هناك خطأ بالخادم','errors'=>$throwable->getMessage()]);
        }
    }

    public function getLastDonations(): JsonResponse
    {
        if (Gate::denies('isUser')) {
            return response()->json(['status'=>'fail','message'=>'غير مصرح لهذا الفعل']);
        }
        try {
            return response()->json(['status'=>'success','data'=>$this->bookDonationRepository->getLastDonations()]);

        }
        catch (Throwable $throwable){
            return response()->json(['status'=>'fail','message'=>'هناك خطأ بالخادم']);
        }
    }

    //Local
    public function incrementNo_booking(User $user, string $semester): void
    {
        if($semester=='كلا الفصلين'){
            $this->userRepository->incrementNo_bookingOfFirstSemester($user);
            $this->userRepository->incrementNo_bookingOfSecondSemester($user);
        }
        elseif($semester=='الفصل الأول'){
            $this->userRepository->incrementNo_bookingOfFirstSemester($user);
        }
        // in case semester is the second semester
        else{
            $this->userRepository->incrementNo_bookingOfSecondSemester($user);
        }

    }

    //Local
    public function decrementNo_booking(User $user, string $semester): void
    {
        if($semester=='كلا الفصلين'){
            $this->userRepository->decrementNo_bookingOfFirstSemester($user);
            $this->userRepository->decrementNo_bookingOfSecondSemester($user);
        }
        elseif($semester=='الفصل الأول'){
            $this->userRepository->decrementNo_bookingOfFirstSemester($user);
        }
        // in case semester is the second semester
        else{
            $this->userRepository->decrementNo_bookingOfSecondSemester($user);
        }

    }

    //Local
    public function checkTheAbilityOfBooking(string $semester,$user):bool
    {
        $no_bookingOfFirstSemester=$user->no_bookingOfFirstSemester;
        $no_bookingOfSecondSemester=$user->no_bookingOfSecondSemester;
        if($semester == 'كلا الفصلين'){
            return $no_bookingOfFirstSemester<=2 && $no_bookingOfSecondSemester<=2;
        }
        elseif ($semester == 'الفصل الأول'){
            return $no_bookingOfFirstSemester<=2;
        }
        else{
            //in case semester is the second semester
            return $no_bookingOfSecondSemester<=2;
        }
    }

    //Local
    public function IsExistInPoint(BookDonation $bookDonation): bool
    {
        return $bookDonation->status == "غير محجوز في النقطة";
    }


   public function book($id)
   {
       if (Gate::denies('isUser')) {
           return response()->json(['status'=>'fail','message'=>'غير مصرح لهذا الفعل']);
       }
       try{
            $bookDonation = BookDonation::find($id); // database/var
            $user = \auth()->user()->user; //database/var
            $abilityOfBooking = $this->checkTheAbilityOfBooking($bookDonation->semester, $user); //var
            if (!$abilityOfBooking) {
                return response()->json(['status'=>'fail','message'=>'لقد وصلت الحد الأقصى من عدد الحزم، يمكن الاستفادة من 3 حزم لكل من الفصلين في كل سنة دراسية ']);
            }
            if ($bookDonation->donor_id === $user->id) {
                return response()->json(['status'=>'fail','message'=>'لا يمكن حجز تبرعك']);
            }
            $isExistInPoint = $this->IsExistInPoint($bookDonation); //var
            $currentDate = Carbon::now(); //var
            $year = $currentDate->year; //var
            $month = $currentDate->month; //var
            $exchangePoint_id=$bookDonation->exchangePoint_id; //database/var
           $notificationController=new NotificationController();

           DB::beginTransaction();
            $this->incrementNo_booking($user, $bookDonation->semester);
           $performanceController=app(PerformanceController::class);
           $performanceController->incrementStatus($exchangePoint_id,'no_bookedDonation');

            if(!$bookDonation->isHided) {

                if ($isExistInPoint) {
                    $this->bookDonationRepository->attachBeneficiaryUser($bookDonation, $user->id, [
                        'activeOrSuccess' => true,
                        'status' => 'بانتظار مجيئك واستلامها',
                        'code' => mt_rand(10000, 65530),
                        'startLeadTimeDateForBeneficiary' => $currentDate
                    ]);
                    $this->bookDonationRepository->update($bookDonation, [
                        'status' => 'محجوز في انتظار التسليم',
                        'isHided' => true,
                    ]);
                    DB::commit();

                    CancelReservationInPointJob::dispatch($bookDonation->id,$user->id)->delay(now()->addMinutes(1));


                }
                else {
                    if($this->checkTheAbilityOfPoint($exchangePoint_id)) {
                        $this->bookDonationRepository->attachBeneficiaryUser($bookDonation, $user->id, [
                            'activeOrSuccess' => true,
                            'status' => 'بانتظار استلامها من المتبرع',
                        ]);
                        $this->bookDonationRepository->update($bookDonation, [
                            'status' => 'محجوز في انتظار الاستلام',
                            'isHided' => true,
                            'startLeadTimeDateForDonor' => $currentDate
                        ]);
                        if($bookDonation->canAcceptEvenItIsNotWaited){
                            $bookDonation->update(['canAcceptEvenItIsNotWaited' => false]);
                        }
                        else {
                            $bookDonation->exchangePoint()->increment('no_packages');
                        }
                        $no_packages=$bookDonation->exchangePoint->no_packages; //database/var
                        $maxPackages=$bookDonation->exchangePoint->maxPackages; //database/var
                        if($no_packages==$maxPackages){
                            $currentDate = Carbon::now(); //var
                            $year = $currentDate->year; //var
                            $month = $currentDate->month; //var
                            $performance=$this->performanceRepository->getByYearAndMonth($exchangePoint_id,$year,$month);
                            $performance->increment('no_reachingMaxPackages');
                        }
                        DB::commit();
                        //TODO: send Notification to Donor
//                        $notificationController->create(
//                            collect([
//                                'data'=>collect([
//                                    'title'=>' تسليم التبرع للنقطة',
//                                    'message'=>'تم حجز تبرعك ب id {$bookDonation->id} ، يرجى مراجعة صفحة تبرعاتي ثم نافذة بانتظار استلامها، يرجى تسليم التبرع تكرما خلال المهلة المحددة ثلاثة أيام، بعد تسليم التبرع تحقق من وصول إشعار لجوالك ، في حال عدم وصوله تواصل معنا عن طريق الواتساب',
//                                    'account_id'=>$bookDonation->donor_id
//                                ]),
//                            'token'=> $this->getFcm_token($bookDonation->donor_id)
//                            ])
//                        );
                        CancelReservationNotInPointJob::dispatch($bookDonation->id,$user->id)->delay(now()->addMinutes(1));

                    }
                    else{
                        DB::rollBack();
                        return response()->json(['status'=>'fail','message'=>'لا يمكن حجز التبرع الآن، نقطة الاستلام ممتلئة']);
                    }


                }
                $reservation=$this->bookDonationRepository->getReservationOfBeneficiary($bookDonation->id);
                RemoveReservation::dispatch($reservation->id)->delay(now()->addDays(365));

            }
            else{
                DB::rollBack();
                return response()->json(['status'=>'fail','message'=>'تم حجز التبرع يرجى تحديث الصفحة']);
            }
           return response()->json(['status'=>'success']);

       }
        catch (PDOException $exception){
            DB::rollBack();
            return response()->json(['status'=>'fail','message'=>'هناك خطأ بالخادم']);
        }

   }
   //Local
   public function getFcm_token($user_id){
        return User::find($user_id)->account->fcm_token;
   }



   public function checkTheAbilityOfPoint(int $exchangePoint_id):bool
   {
       $exchangePoint=ExchangePoint::find($exchangePoint_id); //database/var
       if($exchangePoint->no_packages <  $exchangePoint->maxPackages){
           return true;
       }
       return false;
   }


    public function get($id): JsonResponse
    {
        try {
            $bookDonation = $this->bookDonationRepository->get($id);
            if ($bookDonation) {
                return response()->json(['status' => 'success', 'data' => $bookDonation]);
            } else {
                return response()->json(['status' => 'fail', 'message' => 'الصفحة المطلوبة غير موجودة']);
            }
        }
        catch (Exception $exception){
            return response()->json(['status' => 'fail', 'message' => 'هناك خطأ بالخادم']);
        }

    }
    // تحتاج لإعادة اختبار

    public function store(addBookPackageDonationRequest $request): JsonResponse
    {
        $imageController=app(ImageController::class);
        try {
            if (Gate::denies('isUser')) {
            return response()->json(['status'=>'fail','message'=>'غير مصرح لهذا الفعل']);
            }
            $user=auth()->user()->user();
            DB::beginTransaction();
            $bookDonation=$this->bookDonationRepository->store($request);
            $bookDonation = $this->bookDonationRepository->get($bookDonation->id);
            $imageController->uploadImages($request, $bookDonation->id);
            DB::commit();
            return response()->json(['status'=>'success' ]);
        }
        catch (Throwable $throwable){
            DB::rollBack();
            $imageController->deleteImagesNotInDatabase();
            return response()->json(['status' => 'fail', 'message' => 'هناك خطأ بالخادم',]);
        }

    }

    public function update($id,Request $request): JsonResponse
    {
        try {
        $bookDonation=BookDonation::find($id);
        if(!$bookDonation){
            return response()->json(['status' => 'fail', 'message' => 'التبرع المطلوب غير موجود',]);
        }
            if (Gate::denies('UserCanDeleteOrUpdateBookDonation',$bookDonation)) {
                return response()->json(['status'=>'fail','message'=>'غير مصرح لهذا الفعل']);
            }
            if (Gate::denies('isPointOrUser')) {
                return response()->json(['status'=>'fail','message'=>'غير مصرح لهذا الفعل']);
            }

            $this->bookDonationRepository->update($bookDonation,
                [
                    'level' => $request->level,
                    'semester' => $request->semester,
                    'description' => $request->description,
                    'exchangePoint_id' => $request->exchangePoint_id
                ]);
            return response()->json(['status' => 'success']);
        }
        catch (Exception $exception){
            return response()->json(['status' => 'fail', 'message' => 'هناك خطأ في الخادم',]);

        }


    }

    public function destroy($id)
    {
        try {
            $bookDonation = BookDonation::find($id); //database/var
            if (!$bookDonation) {
                return response()->json(['status' => 'fail', 'message' => 'التبرع غير موجود']);

            }
            if (Gate::denies('isUser')) {
                return response()->json(['status' => 'fail', 'message' => 'غير مصرح لهذا الفعل']);
            }
            if (Gate::denies('UserCanDeleteOrUpdateBookDonation', $bookDonation)) {
                return response()->json(['status' => 'fail', 'message' => 'غير مصرح لهذا الفعل']);
            }
            DB::beginTransaction();
            $bookDonation->delete(); //database
            $imageController =new ImageController(new ImageRepository());
            $imageController->destroyByBookDonation_id($id);
            DB::commit();
            return response()->json(['status' => 'success']);

        }
        catch (Exception $exception){
            DB::rollBack();
            return response()->json(['status' => 'fail', 'message' => 'هناك خطأ في الخادم',]);
        }


    }

    /**
     * it is used for donor to get Undelivered Donations
     *
     * @return JsonResponse
     */
    public function getUndeliveredDonationsForUser(): JsonResponse
    {
        //$Account_id=Auth::User()->getAuthIdentifier();
        // TODO: add getUser_id(int $account_id) in UserController and call it and assign the value of it to $user_id then pass it to getUndeliveredDonations in next lines
        //$user_id=$this;
        return response()->json($this->bookDonationRepository->getUndeliveredDonations(1));
    }

    public function getWaitedDonationsForUser(): JsonResponse
    {
        try {
            if (Gate::denies('isUser')) {
                return response()->json(['status' => 'fail', 'message' => 'غير مصرح لهذا الفعل']);
            }
            return response()->json(['status'=>'success','data'=>$this->bookDonationRepository->getWaitedDonations(auth()->user()->user->id)]);
        }
        catch (\Exception $exception){
            return response()->json(['status' => 'fail', 'message' => 'هناك خطأ بالخادم']);
        }
    }

    public function getDeliveredDonationsForUser(): JsonResponse
    {
        //$Account_id=Auth::User()->getAuthIdentifier();
        // TODO: add getUser_id(int $account_id) in UserController and call it and assign the value of it to $user_id then pass it to getUndeliveredDonations in next lines
        //$user_id=$this;
        return response()->json($this->bookDonationRepository->getDeliveredDonationsForUser(1));
    }

    public function getRejectedDonationsForUser(): JsonResponse
    {
        //$Account_id=Auth::User()->getAuthIdentifier();
        // TODO: add getUser_id(int $account_id) in UserController and call it and assign the value of it to $user_id then pass it to getUndeliveredDonations in next lines
        //$user_id=$this;
        return response()->json($this->bookDonationRepository->getRejectedDonationsForUser(1));
    }

    public function getWaitedReservationsToReceive(): JsonResponse
    {
        //$user_id=\auth()->user()->user()->id;
        return response()->json($this->bookDonationRepository->getReservations(3,['بانتظار استلامها من المتبرع'],
            [
                (DB::raw('book_donations.id AS bookDonations_id')),
                'reservations.id',
                'reservations.created_at',
                'book_donations.level',
                'book_donations.semester',
                'accounts.userName',
                'book_donations.startLeadTimeDateForDonor',
                (DB::raw('residential_quarters.name AS residentialQuarter')),
                (DB::raw('cities.name AS city')),
            ]));
    }

    public function getWaitedReservationsToCollect(): JsonResponse
    {
        //$user_id=\auth()->user()->user()->id;
        return response()->json($this->bookDonationRepository->getReservations(2,['بانتظار مجيئك واستلامها'],
            [
                (DB::raw('book_donations.id AS bookDonations_id')),
                'reservations.id',
                'reservations.created_at',
                'reservations.code',
                'reservations.startLeadTimeDateForBeneficiary',
                'book_donations.level',
                'book_donations.semester',
                'accounts.userName',
                (DB::raw('residential_quarters.name AS residentialQuarter')),
                (DB::raw('cities.name AS city')),
            ]));
    }

    public function getDeliveredReservations()
    {
        //$user_id=\auth()->user()->user()->id;
        return response()->json($this->bookDonationRepository->getReservations(3,['تم التسليم'],
            [
                (DB::raw('book_donations.id AS bookDonations_id')),
                'reservations.id',
                'reservations.created_at',
                'book_donations.level',
                'book_donations.semester',
                'accounts.userName',
                (DB::raw('residential_quarters.name AS residentialQuarter')),
                (DB::raw('cities.name AS city')),
                'cities.district'
            ]));

    }
    //TODO: عدل تم إلغاء التبرع إلى تم إلغاء الحجز في حقل الستاتوس التابع لجدول الحجز وكذلك بالبارميتر في المثود التالية
    public function getFailedReservations(): JsonResponse
    {
        //$user_id=\auth()->user()->user()->id;
        return response()->json($this->bookDonationRepository->getReservations(3,
            ['تم إلغاء الحجز من المتبرع','المتبرع لم يسلم حزمة الكتب','المستفيد لم يستلم حزمة الكتب'
            , 'تم إلغاء التبرع'],
            [
                (DB::raw('book_donations.id AS bookDonations_id')),
                'reservations.id',
                'reservations.created_at',
                'reservations.status',
                'book_donations.level',
                'book_donations.semester',
                'accounts.userName',
                (DB::raw('residential_quarters.name AS residentialQuarter')),
                (DB::raw('cities.name AS city')),
                'cities.district'
            ]));

    }




    public function cancelBookingInPointJob(int $bookDonation_id,int $user_id): void
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
                    'status' => 'المستفيد لم يستلم حزمة الكتب',
                    'activeOrSuccess' => false,
                    'code' => null
                ]);
            $this->bookDonationRepository->updateById($bookDonation_id, [
                'status' => 'غير محجوز في النقطة',
                'isHided' => false,
            ]);
            $this->decrementNo_booking($user,$semester);
            $user->increment('no_non_adherence_beneficiary');
            $performanceController=app(PerformanceController::class);
            $performanceController->incrementStatus($bookDonation->exchangePoint_id,'no_canceledDonationFromBeneficiary');
            DB::commit();
        }
        catch (PDOException $exception){
            DB::rollBack();
            abort(500);
        }

    }

    public function cancelBookingNotInPointJob(int $bookDonation_id,int $user_id): void
    {
        try {
            $user = User::find($user_id); //database/var
            $bookDonation = BookDonation::find($bookDonation_id); //database/var
            $semester = $bookDonation->semester;  //database/var
            DB::beginTransaction();
            $this->bookDonationRepository->updateReservation([
                'bookDonation_id' => $bookDonation_id,
                'user_id' => $user_id,
                'status' => 'بانتظار استلامها من المتبرع'
            ],
                [
                    'status' => 'المتبرع لم يسلم حزمة الكتب',
                    'activeOrSuccess' => false,
                ]);
            $this->bookDonationRepository->updateById($bookDonation_id, [
                'status' => 'غير محجوز وليس في النقطة',
                'isHided' => false
            ]);
            $this->decrementNo_booking($user, $semester);
            $bookDonation->donorUser()->increment('no_non_adherence_donor');
            $bookDonation->exchangePoint()->decrement('no_packages');
            $performanceController=app(PerformanceController::class);
            $performanceController->incrementStatus($bookDonation->exchangePoint_id,'no_canceledDonationFromDonor');
            DB::commit();
        }
        catch (PDOException $exception){
            DB::rollBack();
            abort(500);
        }
    }

    public function cancelReservationInPointByBeneficiary(int $bookDonation_id): void
    {
        try {
            //TODO: $user=auth()->user()->user(); //database/var
            $bookDonation = BookDonation::find($bookDonation_id); //database/var
            if(! $bookDonation){
                abort(404);
            }
            //Gate::authorize('cancelReservationInPointByBeneficiary',[$bookDonation]);
            DB::beginTransaction();
            $semester = $bookDonation->semester;  //database/var
            $this->bookDonationRepository->updateReservation([
                'bookDonation_id' => $bookDonation_id,
                //TODO: correct the value of user_id to $beneficiary_id
                'user_id' => 1,
                'status' => 'بانتظار مجيئك واستلامها',
            ],
                [
                    'status' => 'تم إلغاء الحجز من المستفيد',
                    'activeOrSuccess' => false,
                    'code' => null
                ]);
            $this->bookDonationRepository->updateById($bookDonation_id, [
                'status' => 'غير محجوز في النقطة',
                'isHided' => false
            ]);
            //TODO: change first Parameter of next method call on next line
            $this->decrementNo_booking(User::find(1), $semester);
            $performanceController=app(PerformanceController::class);
            $performanceController->incrementStatus($bookDonation->exchangePoint_id,'no_canceledDonationFromBeneficiary');
            DB::commit();

        }
        catch (PDOException $exception){
            DB::rollBack();
            abort(500,$exception->getMessage());
        }
    }




    public function cancelReservationNotInPointByBeneficiary($bookDonation_id): void
    {

        //$user=auth()->user()->user(); //database/var
        $bookDonation = BookDonation::find($bookDonation_id); //database/var
        if(! $bookDonation){
            abort(404);
        }
        //TODO: Gate::authorize('cancelReservationNotInPointByBeneficiary',[$bookDonation]);
        try {
            DB::beginTransaction();
            $semester = $bookDonation->semester;  //database/var
            $this->bookDonationRepository->updateReservation([
                'bookDonation_id' => $bookDonation_id,
                //TODO: correct the value of user_id to $beneficiary_id
                'user_id' => 1,
                'status' => 'بانتظار استلامها من المتبرع'
            ],
                [
                    'status' => 'تم إلغاء الحجز من المستفيد',
                    'activeOrSuccess' => false,
                ]);

            $this->bookDonationRepository->updateById($bookDonation_id, [
                'canAcceptEvenItIsNotWaited' => true,
                'status' => 'غير محجوز وليس في النقطة',
                'isHided' => false,
            ]);
            //TODO: change first Parameter of next method call on next line
            $this->decrementNo_booking(User::find(1), $semester);
            //TODO:add canAcceptEvenItIsNotWaited Job
            $performanceController = app(PerformanceController::class);
            $performanceController->incrementStatus($bookDonation->exchangePoint_id, 'no_canceledDonationFromBeneficiary');
            DB::commit();

        }
        catch (PDOException $exception){
            DB::rollBack();
            abort(500,$exception->getMessage());
        }
    }

    public function cancelReservationByDonor($bookDonation_id): void
    {
        $bookDonation = BookDonation::find($bookDonation_id); //database/var
        if(!$bookDonation){
            abort(404);
        }
        //TODO: Gate::authorize('cancelReservationByDonor',[$bookDonation]);
        try {
            $beneficiary_id = $this->bookDonationRepository->getReservationOfBeneficiary($bookDonation_id)->id; //var
            $beneficiary = User::find($beneficiary_id);
            $semester = $bookDonation->semester;  //database/var
            $this->bookDonationRepository->updateReservation([
                'bookDonation_id' => $bookDonation_id,
                //TODO: correct the value of user_id to $beneficiary_id
                'user_id' => 3,
                'status' => 'بانتظار استلامها من المتبرع'
            ],
                [
                    'status' => 'تم إلغاء الحجز من المتبرع',
                    'activeOrSuccess' => false,
                ]);
            $this->bookDonationRepository->updateById($bookDonation_id, [
                'status' => 'غير محجوز وليس في النقطة',
                'isHided' => false
            ]);
            $userBookDonationsController = app(\App\Http\Controllers\Api\User\BookDonationController::class);
            //TODO: change first Parameter of next method call on next line
            $userBookDonationsController->decrementNo_booking(User::find(3), $semester);
            $bookDonation->exchangePoint()->decrement('no_packages');
            $performanceController = app(PerformanceController::class);
            $performanceController->incrementStatus($bookDonation->exchangePoint_id, 'no_canceledDonationFromDonor');
            DB::commit();
        }
        catch (PDOException $exception){
            DB::rollBack();
            abort(500,$exception->getMessage());
        }

    }

/*
    public function getReservations(string $phoneNumber)
    {
        $this->bookDonationRepository->getReservations($phoneNumber);

    }
*/




}
