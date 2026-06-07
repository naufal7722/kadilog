<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Operator extends Model
{
    protected $primaryKey = 'kode_operator';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = ['kode_operator', 'nama_operator', 'no_hp'];
}
