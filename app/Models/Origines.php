<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Origines extends Model
{
    use HasFactory;
    public $timestamps = false;

    public function personnages(){
        return $this->hasMany(Personnages::class);
    }
}
