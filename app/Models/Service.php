<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $table = 'DichVu';
    protected $primaryKey = 'MaDV';
    public $timestamps = false;
    
    protected $fillable = ['TenDV', 'GiaTien', 'DonVi'];
}
