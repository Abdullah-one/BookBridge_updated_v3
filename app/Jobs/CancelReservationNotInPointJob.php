<?php

namespace App\Jobs;

use App\Http\Controllers\Api\User\BookDonationController;
use App\Models\BookDonation;
use App\RepositoryPattern\BookDonationRepository;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CancelReservationNotInPointJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    private int $bookDonation_id;
    private int $user_id;

    public function __construct(int $bookDonation_id,int $user_id)
    {
        $this->bookDonation_id=$bookDonation_id;
        $this->user_id=$user_id;

    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $bookDonationController=app(BookDonationController::class);
        $bookDonationRepository=new BookDonationRepository();
        $bookDonation= BookDonation::find($this->bookDonation_id); //database/var
        if(!$bookDonation){
            return;
        }
        $reservationOfBeneficiary=$bookDonationRepository->getReservationOfBeneficiary($this->bookDonation_id);
        if(! $reservationOfBeneficiary){
            return;
        }
        $now = Carbon::now();
        $differenceInDays = $now->diffInDays($reservationOfBeneficiary->created_at);
        $beneficiary_id=$reservationOfBeneficiary->id;
        if($bookDonation->status != 'محجوز في انتظار الاستلام' || $this->user_id == $beneficiary_id
        || $differenceInDays < 3){
            return;
        }
        $bookDonationController->cancelBookingNotInPointJob($this->bookDonation_id,$this->user_id);

    }
}
