<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoomStatus extends Model
{
    protected $table = 'TrangThaiPhong';
    protected $primaryKey = 'MaTrangThai';
    public $timestamps = false;
    
    protected $fillable = ['TrangThai'];
}
