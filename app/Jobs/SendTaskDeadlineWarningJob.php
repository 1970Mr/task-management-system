<?php

namespace App\Jobs;

use App\Mail\TaskDeadlineWarning;
use App\Models\Task;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;

class SendTaskDeadlineWarningJob implements ShouldQueue
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
        $user = $task->user;
        Mail::to($user->email)->send(new TaskDeadlineWarning($task));
    }
}
