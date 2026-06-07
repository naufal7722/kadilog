<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StatusDelivery extends Model
{
    protected $primaryKey = 'kode_status_delivery';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = ['kode_status_delivery', 'nama_status_delivery', 'deskripsi'];
}
