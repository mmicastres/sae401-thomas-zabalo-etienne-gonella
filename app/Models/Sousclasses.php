<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sousclasses extends Model
{
    use HasFactory;
    public function classes(){
        return $this->belongsTo(Classes::class);
    }

    public function personnages(){
        return $this->hasMany(Personnages::class);
    }
}
