<?php

namespace App\Models;

use App\Models\QueryBuilders\WebsiteQueryBuilder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Website extends Model
{
    use HasFactory;

    public static string $morph_key = 'website';


    protected $guarded = ['id'];

    protected $casts = [
        'status' => 'boolean',
    ];

    public function newEloquentBuilder($query): WebsiteQueryBuilder
    {
        return new WebsiteQueryBuilder($query);
    }

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class, 'website_id', 'id');
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_website', 'website_id', 'user_id');
    }
}
