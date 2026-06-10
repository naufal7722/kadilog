<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Operator extends Model
{
    protected $primaryKey = 'kode_operator';
    protected $fillable = ['nama_operator', 'no_hp', 'kode_pelabuhan'];

    public function user()
    {
        return $this->hasOne(User::class, 'kode_operator', 'kode_operator');
    }

    public function pelabuhan()
    {
        return $this->belongsTo(Pelabuhan::class, 'kode_pelabuhan', 'kode_pelabuhan');
    }
}
