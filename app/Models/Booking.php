<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $table = 'PhieuDat';
    protected $primaryKey = 'Id';
    public $timestamps = false;
    
    protected $fillable = ['TenKhach', 'SoDienThoai', 'LoaiPhong', 'NgayDat', 'NgayNhan', 'NgayTra', 'IDTaiKhoan'];
}
