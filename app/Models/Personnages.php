<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Personnages extends Model
{
    use HasFactory;
    public $timestamps = false;

    public function origines()
    {
        return $this->belongsTo(Origines::class);
    }

    public function sousclasses()
    {
        return $this->belongsTo(SousClasses::class);
    }

    public function classes()
    {
        return $this->belongsTo(Classes::class);
    }

    public function sousraces()
    {
        return $this->belongsTo(SousRaces::class);
    }

    public function races()
    {
        return $this->belongsTo(Races::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function competences()
    {
        return $this->belongsToMany(Competences::class);
    }

    public function sorts()
    {
        return $this->belongsToMany(Sorts::class);
    }

    public function talents()
    {
        return $this->belongsToMany(Talents::class);
    }
}
