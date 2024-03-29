<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sousraces extends Model
{
    use HasFactory;
    public function races(){
        return $this->belongsTo(Races::class);
    }

    public function personnages(){
        return $this->hasMany(Personnages::class);
    }
}
