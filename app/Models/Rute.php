<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rute extends Model
{
    protected $primaryKey = 'kode_rute';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = ['kode_rute', 'kode_pelabuhan', 'jarak'];
}
