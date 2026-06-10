<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $primaryKey = 'kode_order';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = ['kode_order', 'kode_supplier', 'isi_produk', 'berat', 'dimensi', 'deskripsi', 'kemasan', 'es', 'pengiriman_awal', 'pengiriman_tujuan', 'kode_konsumen'];

    public function detailOrders()
    {
        return $this->hasMany(DetailOrder::class, 'kode_order', 'kode_order');
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'kode_supplier', 'kode_supplier');
    }

    public function konsumen()
    {
        return $this->belongsTo(Konsumen::class, 'kode_konsumen', 'kode_konsumen');
    }
}
