<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvoiceDetail extends Model
{
    protected $table = 'CTHD';
    protected $primaryKey = 'MaCT';
    public $timestamps = false;
    
    protected $fillable = ['MaHD', 'MaSP', 'SoLuong', 'DonGia'];
}
