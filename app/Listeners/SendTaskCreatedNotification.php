<?php

namespace App\Listeners;

use App\Events\TaskCreated;
use App\Jobs\SendTaskCreatedJob;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendTaskCreatedNotification implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(TaskCreated $event): void
    {
        SendTaskCreatedJob::dispatch($event->task);
    }
}
