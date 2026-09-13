<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    protected $table = 'Account';
    protected $primaryKey = 'IDTaiKhoan';
    public $timestamps = false;
    
    protected $fillable = ['TenDangNhap', 'MatKhau', 'HoTen', 'SoDienThoai', 'DiaChi', 'RoleID', 'QuocTich', 'Email', 'TrangThai'];
}
