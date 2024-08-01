<?php

namespace App\Jobs;

use App\Enums\TaskStatus;
use App\Mail\TaskInactiveNotification;
use App\Models\Task;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;

class MarkTaskAsInactiveJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(private readonly Task $task)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $task = $this->task;

        if ($task->status !== TaskStatus::Completed) {
            $task->status = TaskStatus::Inactive;
            $task->save();
            Mail::to($task->user->email)->send(new TaskInactiveNotification($task));
        }
    }
}
