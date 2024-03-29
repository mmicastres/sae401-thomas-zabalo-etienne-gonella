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
        return $this->belongsTo(Sousclasses::class);
    }

    public function classes()
    {
        return $this->belongsTo(Classes::class);    
    }

    public function sousraces()
    {
        return $this->belongsTo(Sousraces::class);
    }

    public function races()
    {
        return $this->belongsTo(Races::class);    
    }

    public function user()
    {
        return $this->belongsTo(User::class);    
    }
}
