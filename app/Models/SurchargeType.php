<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SurchargeType extends Model
{
    protected $table = 'LoaiPhuThu';
    protected $primaryKey = 'MaLoaiPT';
    public $timestamps = false;
    
    protected $fillable = ['TenPT', 'GiaTien', 'DonViTinh'];
}
