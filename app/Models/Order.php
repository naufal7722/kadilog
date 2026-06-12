<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $primaryKey = 'kode_order';
    protected $fillable = ['kode_supplier', 'isi_produk', 'berat', 'dimensi', 'deskripsi', 'kemasan', 'es', 'pengiriman_awal', 'pengiriman_tujuan', 'kode_konsumen', 'is_cancelled'];

    protected $casts = [
        'es' => 'boolean',
        'is_cancelled' => 'boolean',
    ];

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

    public function pelabuhanAwal()
    {
        return $this->belongsTo(Pelabuhan::class, 'pengiriman_awal', 'kode_pelabuhan');
    }

    public function pelabuhanTujuan()
    {
        return $this->belongsTo(Pelabuhan::class, 'pengiriman_tujuan', 'kode_pelabuhan');
    }
}
