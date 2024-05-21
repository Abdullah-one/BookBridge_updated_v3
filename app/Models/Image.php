<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Image extends Model
{
    use HasFactory;
    protected $fillable=[
        'bookDonation_id',
        'source'
    ];

    /**
     * every image belongs to one BookDonation
     *
     * @return BelongsTo
     */
    public function bookDonation():BelongsTo
    {
        return $this->belongsTo(BookDonation::class,'bookDonation_id');
    }
}
