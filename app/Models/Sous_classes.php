<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sous_classes extends Model
{
    use HasFactory;
    public function classes(){
        return $this->belongsTo(Classes::class);
    }
}
