<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Konsumen extends Model
{
    protected $primaryKey = 'kode_konsumen';
    protected $fillable = ['nama_konsumen', 'nama_pic_konsumen', 'kode_pelabuhan'];

    public function user()
    {
        return $this->hasOne(User::class, 'kode_konsumen', 'kode_konsumen');
    }

    public function pelabuhan()
    {
        return $this->belongsTo(Pelabuhan::class, 'kode_pelabuhan', 'kode_pelabuhan');
    }
}
