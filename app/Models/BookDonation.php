<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BookDonation extends Model
{
    use HasFactory;

    protected array $dates = ['receiptDate'];
    protected $fillable=[
        'donor_id',
        'exchangePoint_id',
        'level',
        'semester',
        'isHided',
        'description',
        'receiptDate',
        'startLeadTimeDateForDonor',
        'status',
        'isRemovable',
        'no_rejecting',
        'canAcceptEvenItIsNotWaited'
    ];

    /**
     * every bookDonation added by one User
     *
     * @return BelongsTo
     */
    public function donorUser(): BelongsTo
    {
        return $this->belongsTo(User::class,'donor_id');
    }

    /**
     * every bookDonation can be booking by one User
     *
     * @return BelongsToMany
     */
    public function beneficiaryUser(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    /**
     * every bookDonations can be having by one User
     *
     * @return BelongsTo
     */
    public function exchangePoint(): BelongsTo
    {
        return $this->belongsTo(ExchangePoint::class,'exchangePoint_id');
    }

    /**
     * every bookDonation can have zero or many images
     *
     * @return HasMany
     */
    public function transactions():HasMany{
        return $this->HasMany(Transaction::class,'bookDonation_id');
    }
    public function images():HasMany{
        return $this->HasMany(Image::class,'bookDonation_id');
    }
    public function reservations(): BelongsToMany
    {
        return $this->BelongsToMany(User::class,'reservations','bookDonation_id'
        ,'user_id')->withPivot('activeOrSuccess',
            'deliveryDate','code','startLeadTimeDateForBeneficiary','status')->withTimestamps();
    }
}
