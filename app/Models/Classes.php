<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classes extends Model
{
    use HasFactory;
    public $timestamps = false;

    public function sousclasses()
    {
        return $this->hasMany(SousClasses::class);
    }

    public function personnages()
    {
        return $this->hasMany(Personnages::class);
    }
    public function talents()
    {
        return $this->belongsToMany(Talents::class);
    }

    public function statistiques()
    {
        return $this->belongsToMany(Statistiques::class);
    }
}
