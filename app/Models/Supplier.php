<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $primaryKey = 'kode_supplier';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = ['kode_supplier', 'nama_umkm', 'alamat', 'nama_pic', 'no_hp_pic'];
}
