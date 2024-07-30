<?php

namespace App\Listeners;

use App\Events\TaskCreated;
use App\Jobs\MarkTaskAsInactiveJob;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class MarkTaskAsInactive implements ShouldQueue
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
        $task = $event->task;
        $deadlineTime = $task->deadline;
        MarkTaskAsInactiveJob::dispatch($task)->delay($deadlineTime);
    }
}