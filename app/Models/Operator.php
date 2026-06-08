<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Operator extends Model
{
    protected $primaryKey = 'kode_operator';
    protected $fillable = ['nama_operator', 'no_hp'];

    public function user()
    {
        return $this->hasOne(User::class, 'kode_operator', 'kode_operator');
    }
}
