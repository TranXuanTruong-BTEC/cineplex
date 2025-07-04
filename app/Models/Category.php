<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description'
    ];

    public function movies()
    {
        return $this->hasMany(Movie::class);
    }

    public function genres()
    {
        return $this->belongsToMany(Genre::class, 'category_genre');
    }
}
