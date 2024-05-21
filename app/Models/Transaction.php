<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable=[
        'bookDonation_id',
        'status',
        'canCancel',
        'user_id'
    ];

    public function bookDonation(): BelongsTo
    {
        return $this->belongsTo(BookDonation::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class,'user_id');
    }
}
