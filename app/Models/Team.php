<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;

    protected $fillable = ['tutor_product_id', 'name', 'contact', 'website'];

    public function tutorProduct()
    {
        return $this->belongsTo(TutorProduct::class);
    }
}

