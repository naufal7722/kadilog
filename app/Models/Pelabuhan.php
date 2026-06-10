<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pelabuhan extends Model
{
    protected $primaryKey = 'kode_pelabuhan';
    protected $fillable = ['nama_pelabuhan', 'nama_pulau', 'nama_gudang', 'koordinat'];
}
