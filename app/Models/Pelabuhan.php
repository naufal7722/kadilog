<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pelabuhan extends Model
{
    protected $primaryKey = 'kode_pelabuhan';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = ['kode_pelabuhan', 'nama_pelabuhan', 'nama_pulau', 'nama_gudang', 'koordinat'];
}
