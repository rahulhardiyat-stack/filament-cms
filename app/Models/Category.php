<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'color',
        'icon',
        'order',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order' => 'integer'
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
    public function getArticleCountAttribute()
    {
        return $this->publishedArticles()->count();
    }

    public function getColorClassAttribute()
    {
        $colorMap = [
            'blue' => 'text-blue-600',
            'purple' => 'text-purple-600',
            'red' => 'text-red-600',
            'green' => 'text-green-600',
            'orange' => 'text-orange-600',
            'indigo' => 'text-indigo-600',
        ];

        return $colorMap[$this->color] ?? 'text-blue-600';
    }

    public function getBgColorClassAttribute()
    {
        $bgMap = [
            'blue' => 'bg-blue-100',
            'purple' => 'bg-purple-100',
            'red' => 'bg-red-100',
            'green' => 'bg-green-100',
            'orange' => 'bg-orange-100',
            'indigo' => 'bg-indigo-100',
        ];

        return $bgMap[$this->color] ?? 'bg-blue-100';
    }

    // Auto-generate slug
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($category) {
            if (empty($category->slug)) {
                $category->slug = Str::slug($category->name);
            }
        });
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order');
    }
}