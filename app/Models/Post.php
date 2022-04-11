<?php

namespace App\Models;

use App\Jobs\SendEmailToSubscribersJob;
use App\Models\QueryBuilders\PostQueryBuilder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = ['id'];

    public static string $morph_key = 'post';

    protected static function booted()
    {
        parent::boot();

        static::created(function (Post $post) {
            SendEmailToSubscribersJob::dispatch($post);
        });
    }

    public function newEloquentBuilder($query): PostQueryBuilder
    {
        return new PostQueryBuilder($query);
    }

    public function website(): BelongsTo
    {
        return $this->belongsTo(Website::class, 'website_id', 'id');
    }

}
