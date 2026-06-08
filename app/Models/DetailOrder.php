<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailOrder extends Model
{
    protected $primaryKey = 'kode_detail_order';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = ['kode_detail_order', 'kode_supplier', 'kode_order', 'kode_rute', 'total_jarak', 'kode_status_delivery', 'koordinat', 'kode_operator'];

    public function statusDelivery()
    {
        return $this->belongsTo(StatusDelivery::class, 'kode_status_delivery', 'kode_status_delivery');
    }

    public function rute()
    {
        return $this->belongsTo(Rute::class, 'kode_rute', 'kode_rute');
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'kode_order', 'kode_order');
    }
}
