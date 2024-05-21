<?php

namespace App\Http\Controllers\Api\Shared;

use App\Http\Controllers\Api\PerformanceController;
use App\Http\Controllers\Controller;
use App\Models\BookDonation;
use App\RepositoryPattern\BookDonationRepository;
use App\RepositoryPattern\ExchangePointRepository;
use App\RepositoryPattern\PerformanceRepository;
use App\RepositoryPattern\TransactionRepository;
use App\RepositoryPattern\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
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
    public function re_addToPoint($id,Request $request): void
    {
        Gate::authorize('isAdminOrPoint');
        $bookDonation=BookDonation::find($id);
        if(!$bookDonation){
            abort(404);
        }
        Gate::authorize('reAddToPoint',$bookDonation);
        $transaction_id=$request->transactions_id;
        try {
            DB::beginTransaction();
            $this->bookDonationRepository->updateById($bookDonation->id, [
                'status' => 'غير محجوز في النقطة',
                'isHided' => false,
            ]);
            $bookDonation->exchangePoint()->increment('no_packages');
            $performanceController = app(PerformanceController::class);
            $performanceController->decrementStatus($bookDonation->exchangePoint_id, 'no_rejectedDonation', $bookDonation->receiptDate);
            $this->transactionRepository->updateStatus($transaction_id, 'تم استلام التبرع');
            DB::commit();
            //Notify donor
        }
        catch (PDOException $exception){
            DB::rollBack();
            abort(500);
        }
    }
}
