<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StatusDelivery extends Model
{
    protected $primaryKey = 'kode_status_delivery';
    protected $fillable = ['nama_status_delivery', 'deskripsi'];
}
