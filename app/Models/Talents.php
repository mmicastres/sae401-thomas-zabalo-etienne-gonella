<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Talents extends Model
{
    use HasFactory;

    public function classes()
    {
        return $this->belongsToMany(Classes::class);
    }

    public function races()
    {
        return $this->belongsToMany(Races::class);
    }

    public function origines()
    {
        return $this->belongsToMany(Origines::class);
    }

    public function personnages()
    {
        return $this->belongsToMany(Sousclasses::class);
    }
}
