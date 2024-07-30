<?php

namespace App\Http\Controllers\Tasks;

use App\Exports\TasksExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Tasks\SendTaskReportRequest;
use App\Jobs\SendTaskReport;
use App\Mail\TaskReportMail;
use App\Models\Task;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class TaskReportController extends Controller
{
    public function exportTasksToExcel(): BinaryFileResponse
    {
        return Excel::download(new TasksExport(), 'tasks.xlsx');
    }

    public function exportTasksToPdf(): Response
    {
        $tasks = Task::with('users')->get();
        return Pdf::loadView('reports/tasks.pdf', compact('tasks'))
            ->download('tasks.pdf');
    }

    public function sendTaskReport(SendTaskReportRequest $request): JsonResponse
    {
        // Generate Excel and PDF
        $excelFile = Excel::raw(new TasksExport, \Maatwebsite\Excel\Excel::XLSX);
        $excelFilePath = 'reports/tasks.xlsx';
        Storage::put($excelFilePath, $excelFile);
        $tasks = Task::with('users')->get();
        $pdf = Pdf::loadView('reports.tasks.pdf', compact('tasks'))->output();
        $pdfFilePath = 'reports/tasks.pdf';
        Storage::put($pdfFilePath, $pdf);

        // Send emails
        $users = User::query()->findMany($request->user_ids);
        foreach ($users as $user) {
            dispatch(new SendTaskReport($user->email, $excelFilePath, $pdfFilePath));
        }

        return response()->json(['message' => 'Reports sent successfully']);
    }
}
