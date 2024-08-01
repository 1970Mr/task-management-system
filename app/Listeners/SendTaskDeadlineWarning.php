<?php

namespace App\Listeners;

use App\Jobs\SendTaskDeadlineWarningJob;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendTaskDeadlineWarning implements ShouldQueue
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
    public function handle(object $event): void
    {
        $task = $event->task;
        $deadlineWarningTime = $task->deadline->subHour();
        SendTaskDeadlineWarningJob::dispatch($task)->delay($deadlineWarningTime);
    }
}
