<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Model
{
    use HasFactory;
     protected $fillable=[
         'account_id',
         'no_donations',
         'no_benefits',
         'no_non_adherence_donor',
         'no_non_adherence_beneficiary',
         'no_bookingOfFirstSemester',
         'no_bookingOfSecondSemester'
     ];

    /**
     * every User belongs to one Account
     *
     * @return BelongsTo
     */
     public function account(): BelongsTo
     {
         return $this->belongsTo(Account::class,'account_id');
     }

    /**
     * every User can has zero or many AddedBookDonations
     *
     * @return HasMany
     */
    public function addedBookDonations(): HasMany
    {
        return $this->hasMany(BookDonation::class,'donor_id');
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class,'user_id');
    }

    /**
     * every User can have zero or many BookedBooksDonations
     *
     * @return BelongsToMany
     */
    public function reservations(): BelongsToMany
    {
        return $this->BelongsToMany(BookDonation::class,'Reservations')->withPivot('activeOrSuccess',
        'deliveryDate','code','startLeadTimeDateForBeneficiary','status')->withTimestamps();
    }
}
