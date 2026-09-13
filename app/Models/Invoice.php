<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $table = 'HoaDon';
    protected $primaryKey = 'MaHD';
    public $timestamps = false;
    
    protected $fillable = ['HoTen', 'DienThoai', 'DiaChi', 'NgayDat', 'NgayNhan', 'NgayTra', 'TongTien', 'IDTaiKhoan', 'DaThanhToan'];
}
