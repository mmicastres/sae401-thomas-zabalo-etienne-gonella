<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Races extends Model
{
    use HasFactory;
    public $timestamps = false;

    public function sousraces()
    {
        return $this->hasMany(SousRaces::class);
    }

    public function personnages()
    {
        return $this->hasMany(Personnages::class);
    }

    public function talents()
    {
        return $this->belongsToMany(Talents::class);
    }
}
