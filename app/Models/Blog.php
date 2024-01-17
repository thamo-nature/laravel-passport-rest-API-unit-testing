<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Blog extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'blog_title', 'blog_content'];

    public function user(): HasMany
    {
        return $this->hasMany(User::class);
    }

}
