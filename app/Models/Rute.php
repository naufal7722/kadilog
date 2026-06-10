<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rute extends Model
{
    protected $primaryKey = 'kode_rute';
    protected $fillable = [
        'kode_pelabuhan_asal',
        'kode_pelabuhan_tujuan',
        'titik_transit',
        'jarak'
    ];

    protected $casts = [
        'titik_transit' => 'array',
    ];

    public function pelabuhanAsal()
    {
        return $this->belongsTo(Pelabuhan::class, 'kode_pelabuhan_asal', 'kode_pelabuhan');
    }

    public function pelabuhanTujuan()
    {
        return $this->belongsTo(Pelabuhan::class, 'kode_pelabuhan_tujuan', 'kode_pelabuhan');
    }
}
