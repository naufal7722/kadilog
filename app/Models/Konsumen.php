<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Konsumen extends Model
{
    protected $primaryKey = 'kode_konsumen';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = ['kode_konsumen', 'nama_konsumen', 'nama_pic_konsumen'];
}
