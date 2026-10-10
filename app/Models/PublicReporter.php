<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;

class PublicReporter extends Authenticatable
{
    protected $attributes = ['is_active' => true];

    protected $fillable = ['username', 'name', 'password'];

    protected $hidden = ['password'];

    protected $casts = ['password' => 'hashed', 'name' => 'encrypted', 'is_active' => 'boolean'];

    public function reports(): HasMany
    {
        return $this->hasMany(PpksReport::class);
    }
}
