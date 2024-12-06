<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TutorProduct extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description'];

    public function teams()
    {
        return $this->hasMany(Team::class);
    }
}

