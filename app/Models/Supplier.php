<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $primaryKey = 'kode_supplier';
    protected $fillable = ['nama_umkm', 'alamat', 'nama_pic', 'no_hp_pic', 'kode_pelabuhan'];

    public function user()
    {
        return $this->hasOne(User::class, 'kode_supplier', 'kode_supplier');
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'kode_supplier', 'kode_supplier');
    }

    public function pelabuhan()
    {
        return $this->belongsTo(Pelabuhan::class, 'kode_pelabuhan', 'kode_pelabuhan');
    }
}
