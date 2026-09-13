<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OTPVerification extends Model
{
    protected $table = 'OTPVerifications';
    protected $primaryKey = 'Email';
    public $incrementing = false; // Email is not an auto-incrementing integer
    protected $keyType = 'string';
    public $timestamps = false;
    
    protected $fillable = ['Email', 'OTPCode', 'ExpireTime', 'IsVerified', 'CreatedAt'];
}
