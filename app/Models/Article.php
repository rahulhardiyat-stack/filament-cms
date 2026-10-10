<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Carbon\Carbon;

class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'author_id',
        'title',
        'slug',
        'excerpt',
        'content',
        'featured_image',
        'read_time',
        'views_count',
        'is_featured',
        'is_published',
        'published_at'
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'is_published' => 'boolean',
        'published_at' => 'datetime',
        'views_count' => 'integer',
        'read_time' => 'integer'
    ];

    // Relationships
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function author()
    {
        return $this->belongsTo(Author::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function approvedComments()
    {
        return $this->hasMany(Comment::class)
            ->where('is_approved', true)
            ->whereNull('parent_id')
            ->latest();
    }

    // Accessors
    public function getFeaturedImageUrlAttribute()
    {
        if ($this->featured_image) {
            return asset('storage/' . $this->featured_image);
        }
        return null;
    }

    public function getFormattedDateAttribute()
    {
        return $this->published_at
            ? $this->published_at->locale('id')->isoFormat('D MMMM YYYY')
            : $this->created_at->locale('id')->isoFormat('D MMMM YYYY');
    }

    public function getShortDateAttribute()
    {
        return $this->published_at
            ? $this->published_at->locale('id')->isoFormat('D MMM YYYY')
            : $this->created_at->locale('id')->isoFormat('D MMM YYYY');
    }

    public function getReadTimeTextAttribute()
    {
        return $this->read_time . ' Menit';
    }

    // Auto-generate slug and read time
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($article) {
            if (empty($article->slug)) {
                $article->slug = Str::slug($article->title);
            }

            // Auto calculate read time if not set (250 words per minute)
            if (empty($article->read_time) && !empty($article->content)) {
                $wordCount = str_word_count(strip_tags($article->content));
                $article->read_time = max(1, ceil($wordCount / 250));
            }
        });

        static::updating(function ($article) {
            if ($article->isDirty('content') && !$article->isDirty('read_time')) {
                $wordCount = str_word_count(strip_tags($article->content));
                $article->read_time = max(1, ceil($wordCount / 250));
            }
        });
    }

    // Scopes
    public function scopePublished($query)
    {
        return $query->where('is_published', true)
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now());
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeLatest($query)
    {
        return $query->orderBy('published_at', 'desc');
    }

    public function scopePopular($query)
    {
        return $query->orderBy('views_count', 'desc');
    }

    // Methods
    public function incrementViews()
    {
        $this->increment('views_count');
    }

    public function relatedArticles($limit = 3)
    {
        return self::published()
            ->where('category_id', $this->category_id)
            ->where('id', '!=', $this->id)
            ->latest()
            ->limit($limit)
            ->get();
    }
}