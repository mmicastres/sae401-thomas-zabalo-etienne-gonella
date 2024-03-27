<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classes extends Model
{
    use HasFactory;
    public function sousclasses(){
        return $this->hasMany(Sousclasses::class);
    }

    public function personnages(){
        return $this->hasMany(Personnages::class);
    }
}
