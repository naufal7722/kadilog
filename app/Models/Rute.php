<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rute extends Model
{
    protected $primaryKey = 'kode_rute';
    protected $fillable = ['kode_pelabuhan', 'jarak'];

    public function pelabuhan()
    {
        return $this->belongsTo(Pelabuhan::class, 'kode_pelabuhan', 'kode_pelabuhan');
    }
}
