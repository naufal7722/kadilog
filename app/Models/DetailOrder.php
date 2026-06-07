<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailOrder extends Model
{
    protected $primaryKey = 'kode_detail_order';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = ['kode_detail_order', 'kode_supplier', 'kode_order', 'kode_rute', 'total_jarak', 'kode_status_delivery', 'koordinat', 'kode_operator'];
}
