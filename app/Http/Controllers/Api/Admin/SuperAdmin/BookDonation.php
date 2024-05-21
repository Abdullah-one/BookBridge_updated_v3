<?php

namespace App\Http\Controllers\Api\Admin\SuperAdmin;

use App\Http\Controllers\Api\PerformanceController;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\RepositoryPattern\BookDonationRepository;
use App\RepositoryPattern\ExchangePointRepository;
use App\RepositoryPattern\PerformanceRepository;
use App\RepositoryPattern\UserRepository;
use Illuminate\Support\Facades\DB;
use PDOException;

class BookDonation extends Controller
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

    public function removeByAdmin($id)
    {
        $bookDonation= \App\Models\BookDonation::find($id); //database/var
        $reservation=$this->bookDonationRepository->getReservationOfBeneficiary($id);
        try {
            DB::beginTransaction();
            if ($reservation) {
                $user_id = $reservation->user_id; //database/var
                $user = User::find($user_id); //database/var
                $semester = $bookDonation->semester;  //database/var
                $this->bookDonationRepository->updateReservation([
                    'bookDonation_id' => $id,
                    'user_id' => $user_id,
                    'status' => 'بانتظار مجيئك واستلامها'
                ],
                    [
                        'status' => 'تم إلغاء الحجز من البرنامج',
                        'activeOrSuccess' => false,
                        'code' => null
                    ]);
                $userBookDonationController = app(\App\Http\Controllers\Api\User\BookDonationController::class);
                $userBookDonationController->decrementNo_booking($user, $semester);
            }
            $this->bookDonationRepository->updateById($id, [
                'status' => 'تم الحذف من المدير',
                'isHided' => false,
            ]);
            $performanceController=app(PerformanceController::class);
            $performanceController->incrementStatus($bookDonation->exchangePoint_id,'no_removedDonationByAdmin');
            DB::commit();
            //TODO: notify the Beneficiary
        }
        catch (PDOException $exception){
            DB::rollBack();
            abort(500);
        }

    }


}
