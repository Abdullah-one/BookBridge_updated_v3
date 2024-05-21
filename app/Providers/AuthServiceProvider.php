<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Models\Account;
use App\Models\BookDonation;
use App\Models\ExchangePoint;
use App\Models\User;
use App\RepositoryPattern\BookDonationRepository;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //                          -- SuperAdmin --
        //                              Account
        Gate::define('IsSuperAdmin', function (Account $user,Account $account) {
            return $account->role == 'superAdmin';
        });
        //                             -- User --
        //                              Account
        Gate::define('isUser', function (Account $account) {
            return  $account->role == 'user';
        });
        //                            -- Point --
        //                            * Account *
        Gate::define('isPoint',function (Account $account){
            return $account->role =='point';
        });

        //                            --  Shared --
        //                      -  between Point and User -
        Gate::define('isPointOrUser',function (Account $account){
            return $account->role =='user' || $account->role=='point' ;
        });

        //                       - between Admin and Point
        Gate::define('isAdminOrPoint',function (Account $account){
            return $account->role =='admin' || $account->role=='point' || $account->role=='superAdmin';
        });
        Gate::define('reAddToPoint',function (Account $account ,BookDonation $bookDonation){
            if($account->exchangePoint) {
                return $account->exchangePoint->id == $bookDonation->exchangePoint->id
                    && $bookDonation->status == 'تم رفض التبرع';
            }
            else{
                return in_array($account->admin->id,$bookDonation->exchangePoint->residentialQuarter->city->admins->pluck('id')->toArray())
                    && $bookDonation->status=='تم رفض التبرع';
            }
        });

        //                                          *Performance*
        Gate::define('getBookDonations',function (Account $account){
            if($account->exchangePoint) {
                return $account->exchangePoint->id == $bookDonation->exchangePoint->id
                    && $bookDonation->status == 'تم رفض التبرع';
            }
            else{
                return in_array($account->admin->id,$bookDonation->exchangePoint->residentialQuarter->city->admins->pluck('id')->toArray())
                    && $bookDonation->status=='تم رفض التبرع';
            }
        });



        Gate::define('isUserOrPoint',function (Account $account){
            return $account->role =='user' || $account->role=='point';
        });
        Gate::define('isPoint', function (Account $account) {
            return $account->role == 'point';
        });
        Gate::define('UserCanDeleteOrUpdateBookDonation', function (Account $account,BookDonation $bookDonation) {
            $DonorAccount_id=$bookDonation->donorUser->account->id;
            return $account->id == $DonorAccount_id;
        });
        Gate::define('removeDonationByExchangePoint',function (Account $account,BookDonation $bookDonation){
            return $bookDonation->exchangePoint->account_id == $account->id && $bookDonation->isRemovable
                && $bookDonation->status == 'غير محجوز في النقطة';
        });
        Gate::define('updateDonationInPoint',function (Account $account,BookDonation $bookDonation){
            return $bookDonation->exchangePoint->account_id == $account->id &&
                ($bookDonation->status=='غير محجوز في النقطة' || $bookDonation->status=="محجوز في انتظار التسليم");
        });
        Gate::define('cancelReservationInPointByBeneficiary',function (Account $account,BookDonation $bookDonation){
            $bookDonationRepository=new BookDonationRepository();
            $reservationOfBeneficiary=$bookDonationRepository->getReservationOfBeneficiary($bookDonation->id);
            if($reservationOfBeneficiary) {
                return ($account->user->id == $reservationOfBeneficiary->user_id && $reservationOfBeneficiary->status=
                'بانتظار مجيئك واستلامها');
            }
            else{
                return false;
            }

        });
        Gate::define('cancelReservationNotInPointByBeneficiary',function (Account $account,BookDonation $bookDonation){
            $bookDonationRepository=new BookDonationRepository;
            $reservationOfBeneficiary=$bookDonationRepository->getReservationOfBeneficiary($bookDonation->id);
            if($reservationOfBeneficiary) {
                return ($account->user->id == $reservationOfBeneficiary->user_id && $reservationOfBeneficiary->status=
                        'بانتظار استلامها من المتبرع');
            }
            else{
                return false;
            }

        });
        Gate::define('cancelReservationByDonor',function (Account $account,BookDonation $bookDonation){
            return $account->user->id == $bookDonation->donor_id &&
                $bookDonation->reservations()->where('status','=','بانتظار استلامها من المتبرع')->first();
        });

        //                                   **  EXCHANGE POINT  **
        Gate::define('RejectAndConfirmByExchangePoint',function (Account $account,BookDonation $bookDonation){
            return $account->exchangePoint->id == $bookDonation->exchangePoint->id &&
                $bookDonation->reservations()->where('status','=','بانتظار استلامها من المتبرع');
        });
        Gate::define('RejectAndConfirmOfWaitedDonationsByExchangePoint',function (Account $account,BookDonation $bookDonation){
            return $account->exchangePoint->id == $bookDonation->exchangePoint->id &&
                $bookDonation->reservations()->where('status','=','بانتظار استلامها من المتبرع');
        });
        Gate::define('RejectFromBeneficiary',function (Account $account,BookDonation $bookDonation){
            return $account->exchangePoint->id == $bookDonation->exchangePoint->id &&
                $bookDonation->reservations()->where('status','=', 'بانتظار مجيئك واستلامها');

        });

        Gate::define('confirmDelivery',function (Account $account,BookDonation $bookDonation,$code){
            return $account->exchangePoint->id == $bookDonation->exchangePoint->id &&
                $bookDonation->reservations()->where('status','=', 'بانتظار مجيئك واستلامها')
                    ->where('code','=', $code);
        });


        Gate::define('confirmReceptionOfUnWaitedDonations',function (Account $account,BookDonation $bookDonation){
            return $account->exchangePoint->id == $bookDonation->exchangePoint->id &&
                $bookDonation->reservations()->where('status','=','غير محجوز وليس في النقطة');
        });

        Gate::define('re_addToPoint',function (Account $account,BookDonation $bookDonation){
            $exchangePoint=ExchangePoint::where('account_id',$account->id)->first();
           return $bookDonation->exchangePoint->id == $exchangePoint->id &&
               $bookDonation->status=='تم رفض التبرع';
        });

        // ->where('maxPackages','>',DB::raw('no_packages +'.$this->getNo_donationsWaitedToBeBooked
        //                        (DB::raw('book_donations.donor_id'), DB::raw('book_donations.exchangePoint_id'))))


        //                                       **  USER  **
        Gate::define('book',function (Account $account,BookDonation $bookDonation){
            return ($bookDonation->donor_id != $account->id);
        });
    }
}
