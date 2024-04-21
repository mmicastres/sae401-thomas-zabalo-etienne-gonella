<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Talents extends Model
{
    use HasFactory;

    public function Classes()
    {
        return $this->belongsToMany(Classes::class);
    }

    public function Races()
    {
        return $this->belongsToMany(Races::class);
    }

    public function Origines()
    {
        return $this->belongsToMany(Origines::class);
    }
}
