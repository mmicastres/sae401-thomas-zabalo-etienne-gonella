<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Statistiques extends Model
{
    use HasFactory;
    public $timestamps = false;

    public function classes()
    {
        return $this->belongsToMany(Classes::class);
    }
}
