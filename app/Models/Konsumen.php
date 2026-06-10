<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Konsumen extends Model
{
    protected $primaryKey = 'kode_konsumen';
    protected $fillable = ['nama_konsumen', 'nama_pic_konsumen'];

    public function user()
    {
        return $this->hasOne(User::class, 'kode_konsumen', 'kode_konsumen');
    }
}
