<?php

namespace App\Providers;

use App\Policies\NotificationPolicy;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        DatabaseNotification::class => NotificationPolicy::class,
    ];

    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->registerPolicies();
    }
}
