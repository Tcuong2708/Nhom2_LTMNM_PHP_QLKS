<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceDetail extends Model
{
    protected $table = 'CT_DichVu';
    protected $primaryKey = 'ID';
    public $timestamps = false;
    
    protected $fillable = ['MaHD', 'MaDV', 'SoLuong', 'GiaTien'];
}
