<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $table = 'DanhGia';
    protected $primaryKey = 'id';
    public $timestamps = false;
    
    protected $fillable = ['NgayDanhGia', 'NoiDung', 'SoSao', 'TenPhong', 'TrangThai', 'User_ID'];
}
