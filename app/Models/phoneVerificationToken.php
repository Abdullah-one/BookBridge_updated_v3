<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class phoneVerificationToken extends Model
{
    use HasFactory;

    protected $fillable=[
        'phoneNumber',
        'token'
    ];

    const UPDATED_AT = null;
}
