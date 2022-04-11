<?php

namespace App\Providers;

use App\Models\Post;
use App\Models\User;
use App\Models\UserPost;
use App\Models\Website;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Relations\Relation;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if (! app()->isProduction() && PHP_OS !== 'Linux') {
            Schema::defaultStringLength(191);
        }

        Relation::morphMap([
            UserPost::$morph_key => UserPost::class,
            Website::$morph_key     => Website::class,
            Post::$morph_key          => Post::class,
            User::$morph_key          => User::class,
        ]);
    }
}
