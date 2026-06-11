<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TrackingHistory extends Model
{
    protected $fillable = [
        'kode_detail_order',
        'kode_status_delivery',
        'catatan',
        'koordinat'
    ];

    public function detailOrder()
    {
        return $this->belongsTo(DetailOrder::class, 'kode_detail_order', 'kode_detail_order');
    }

    public function statusDelivery()
    {
        return $this->belongsTo(StatusDelivery::class, 'kode_status_delivery', 'kode_status_delivery');
    }
}
