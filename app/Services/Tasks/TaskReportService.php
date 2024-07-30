<?php

namespace App\Services\Tasks;

use App\Exports\TasksExport;
use App\Jobs\SendTaskReportJob;
use App\Models\Task;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class TaskReportService
{
    public function exportExcel(): BinaryFileResponse
    {
        return Excel::download(new TasksExport(), 'tasks.xlsx');
    }

    public function exportPdf(): Response
    {
        $tasks = Task::with('users')->get();
        return Pdf::loadView('reports/tasks.pdf', compact('tasks'))
            ->download('tasks.pdf');
    }

    public function sendReport(array $userIds): void
    {
        $excelFilePath = $this->generateExcelFile();
        $pdfFilePath = $this->generatePdfFile();
        $this->sendEmails($userIds, $excelFilePath, $pdfFilePath);
    }

    private function generateExcelFile(): string
    {
        $excelFile = Excel::raw(new TasksExport, \Maatwebsite\Excel\Excel::XLSX);
        $excelFilePath = 'reports/tasks.xlsx';
        Storage::put($excelFilePath, $excelFile);
        return $excelFilePath;
    }

    private function generatePdfFile(): string
    {
        $tasks = Task::all();
        $pdf = Pdf::loadView('reports.tasks.pdf', compact('tasks'))->output();
        $pdfFilePath = 'reports/tasks.pdf';
        Storage::put($pdfFilePath, $pdf);
        return $pdfFilePath;
    }

    private function sendEmails(array $userIds, string $excelFilePath, string $pdfFilePath): void
    {
        $users = User::query()->findMany($userIds);
        foreach ($users as $user) {
            dispatch(new SendTaskReportJob($user->email, $excelFilePath, $pdfFilePath));
        }
    }
}
