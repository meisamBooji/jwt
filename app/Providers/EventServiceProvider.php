<?php

namespace App\Providers;

use App\Events\EntityCreated;
use App\Listeners\SendNotification;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],

        EntityCreated::class => [

            SendNotification::class,
        ],
    ];

    public function boot(): void
    {

    }

    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
