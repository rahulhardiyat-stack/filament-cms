<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Student extends Authenticatable
{
    protected $fillable = ['nim', 'name', 'program_studi', 'birth_date_password', 'is_active'];

    protected $hidden = ['birth_date_password'];

    protected $casts = ['birth_date_password' => 'hashed', 'is_active' => 'boolean'];

    public function getAuthPassword(): string
    {
        return $this->birth_date_password;
    }

    public function reports(): HasMany
    {
        return $this->hasMany(PpksReport::class);
    }
}
