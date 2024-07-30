<?php

namespace App\Jobs;

use App\Mail\TaskReportMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;

class SendTaskReportJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public readonly string $email,
        public readonly string $excelFilePath,
        public readonly string $pdfFilePath)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Mail::to($this->email)->send(new TaskReportMail($this->excelFilePath, $this->pdfFilePath));
    }
}
