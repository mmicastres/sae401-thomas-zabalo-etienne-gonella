<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Competences extends Model
{
    use HasFactory;
    public $timestamps = false;

    public function personnages()
    {
        return $this->belongsToMany(Personnages::class);
    }

    public function sousRaces()
    {
        return $this->belongsToMany(Sousraces::class);
    }

    public function sousClasses()
    {
        return $this->belongsToMany(Sousclasses::class);
    }
}
