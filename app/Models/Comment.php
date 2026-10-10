<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'article_id',
        'parent_id',
        'author_name',
        'author_email',
        'content',
        'is_approved',
        'is_author_reply'
    ];

    protected $casts = [
        'is_approved' => 'boolean',
        'is_author_reply' => 'boolean'
    ];

    // Relationships
    public function article()
    {
        return $this->belongsTo(Article::class);
    }

    public function parent()
    {
        return $this->belongsTo(Comment::class, 'parent_id');
    }

    public function replies()
    {
        return $this->hasMany(Comment::class, 'parent_id')
            ->where('is_approved', true)
            ->latest();
    }

    // Accessors
    public function getTimeAgoAttribute()
    {
        return $this->created_at->locale('id')->diffForHumans();
    }

    // Scopes
    public function scopeApproved($query)
    {
        return $query->where('is_approved', true);
    }

    public function scopeParents($query)
    {
        return $query->whereNull('parent_id');
    }
}