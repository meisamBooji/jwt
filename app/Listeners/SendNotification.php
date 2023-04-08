<?php

namespace App\Listeners;

use App\Events\EntityCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class SendNotification
{
    public function __construct()
    {

    }

    public function handle(EntityCreated $event): void
    {
        Log::info('event fired.!');
    }
}
