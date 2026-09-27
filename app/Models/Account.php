<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Account extends Authenticatable
{
    protected $table = 'Account';
    protected $primaryKey = 'IDTaiKhoan';
    public $timestamps = false;
    
    protected $fillable = ['TenDangNhap', 'MatKhau', 'HoTen', 'SoDienThoai', 'DiaChi', 'RoleID', 'QuocTich', 'Email', 'TrangThai'];

    public function getAuthPassword()
    {
        return $this->MatKhau;
    }
}
