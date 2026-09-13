<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SurchargeDetail extends Model
{
    protected $table = 'CT_PhuThu';
    protected $primaryKey = 'ID';
    public $timestamps = false;
    
    protected $fillable = ['MaHD', 'MaLoaiPT', 'SoLuong', 'GiaTien', 'GhiChu'];
}
