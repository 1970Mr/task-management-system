<?php

namespace App\Http\Controllers\Tasks;

use App\Http\Controllers\Controller;
use App\Http\Requests\Tasks\SendTaskReportRequest;
use App\Services\Tasks\TaskReportService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class TaskReportController extends Controller
{
    public function __construct(private readonly TaskReportService $reportService)
    {
    }

    public function exportTasksToExcel(): BinaryFileResponse
    {
        return $this->reportService->exportExcel();
    }

    public function exportTasksToPdf(): Response
    {
        return $this->reportService->exportPdf();
    }

    public function sendTaskReport(SendTaskReportRequest $request): JsonResponse
    {
        $this->reportService->sendReport($request->user_ids);
        return response()->json(['message' => 'Reports sent successfully']);
    }
}
