<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Races extends Model
{
    use HasFactory;
    public function sousraces(){
        return $this->hasMany(Sousraces::class);
    }

    public function personnages(){
        return $this->hasMany(Personnages::class);
    }
}