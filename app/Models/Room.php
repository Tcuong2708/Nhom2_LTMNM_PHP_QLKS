<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $table = 'Phong';
    protected $primaryKey = 'ID';
    public $timestamps = false;
    
    protected $fillable = ['Name', 'Price', 'Detail', 'ImageUrl', 'MaLoai', 'MaTrangThai', 'GhiChu', 'SoGiuongPhuToiDa'];
}
