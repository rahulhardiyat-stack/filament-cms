<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Author extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'email',
        'bio',
        'title',
        'avatar',
        'twitter_url',
        'linkedin_url',
        'website_url',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    // Relationships
    public function articles()
    {
        return $this->hasMany(Article::class);
    }

    public function publishedArticles()
    {
        return $this->hasMany(Article::class)
            ->where('is_published', true)
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now());
    }

    // Accessors
    public function getAvatarUrlAttribute()
    {
        if ($this->avatar) {
            return asset('storage/' . $this->avatar);
        }
        return null;
    }

    // Auto-generate slug
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($author) {
            if (empty($author->slug)) {
                $author->slug = Str::slug($author->name);
            }
        });
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}