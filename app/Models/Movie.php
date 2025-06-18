<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Movie extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'thumbnail',
        'youtube_video_id',
        'duration',
        'release_year',
        'views',
        'category_id',
        'status'
    ];

    protected $casts = [
        'release_year' => 'integer',
        'views' => 'integer',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function genres()
    {
        return $this->belongsToMany(Genre::class, 'genre_movie');
    }

    public function getThumbnailUrlAttribute()
    {
        if ($this->thumbnail) {
            return asset('storage/' . $this->thumbnail);
        }
        return asset('images/default-thumbnail.jpg');
    }

    public function getYoutubeEmbedUrlAttribute()
    {
        if ($this->youtube_video_id) {
            return "https://www.youtube.com/embed/{$this->youtube_video_id}";
        }
        return null;
    }

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($movie) {
            if (empty($movie->slug)) {
                $movie->slug = Str::slug($movie->title);
            }
        });
        
        static::updating(function ($movie) {
            if ($movie->isDirty('title') && empty($movie->slug)) {
                $movie->slug = Str::slug($movie->title);
            }
        });
    }
}
