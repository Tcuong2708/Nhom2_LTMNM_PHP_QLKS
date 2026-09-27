<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Room;

class RoomType extends Model
{
    protected $table = 'Loai';
    protected $primaryKey = 'MaLoai';
    public $timestamps = false;
    
    protected $fillable = ['Name', 'SoNguoi'];

    public function rooms()
    {
        return $this->hasMany(Room::class, 'MaLoai', 'MaLoai');
    }
}
