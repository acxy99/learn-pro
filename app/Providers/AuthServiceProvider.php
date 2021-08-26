<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

use App\User;
use App\Profile;
use App\Course;
use App\Page;
use App\File;
use App\Category;
use App\Topic;
use App\Policies\UserPolicy;
use App\Policies\ProfilePolicy;
use App\Policies\CoursePolicy;
use App\Policies\PagePolicy;
use App\Policies\FilePolicy;
use App\Policies\CategoryPolicy;
use App\Policies\TopicPolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
        User::class => UserPolicy::class,
        Profile::class => ProfilePolicy::class,
        Course::class => CoursePolicy::class,
        Page::class => PagePolicy::class,
        File::class => FilePolicy::class,
        Category::class => CategoryPolicy::class,
        Topic::class=> TopicPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
