<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoomType extends Model
{
    protected $table = 'Loai';
    protected $primaryKey = 'MaLoai';
    public $timestamps = false;
    
    protected $fillable = ['Name', 'SoNguoi'];
}
