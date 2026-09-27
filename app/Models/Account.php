<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class Account extends Authenticatable
{
    use HasApiTokens;

    protected $table = 'Account';
    protected $primaryKey = 'IDTaiKhoan';
    public $timestamps = false;
    
    protected $fillable = ['TenDangNhap', 'MatKhau', 'HoTen', 'SoDienThoai', 'DiaChi', 'RoleID', 'QuocTich', 'Email', 'TrangThai'];
}
