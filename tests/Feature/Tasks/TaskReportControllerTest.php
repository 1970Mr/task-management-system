<?php

namespace Tests\Feature\Tasks;

use App\Enums\UserRole;
use App\Models\User;
use App\Services\Tasks\TaskReportService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\Sanctum;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Tests\TestCase;
use Mockery;

class TaskReportControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_export_tasks_to_excel(): void
    {
        Storage::disk('local')->put('fake/tasks.xlsx', 'Temporary file content');

        $user = User::factory()->create(['role' => UserRole::Admin]);
        Sanctum::actingAs($user, ['*']);

        $reportService = Mockery::mock(TaskReportService::class);
        $reportService->shouldReceive('exportExcel')
            ->once()
            ->andReturn(
                new BinaryFileResponse(Storage::path('fake/tasks.xlsx'), 200, [
                    'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                    'Content-Disposition' => 'attachment; filename="tasks.xlsx"',
                ])
            );

        $this->app->instance(TaskReportService::class, $reportService);

        $response = $this->get(route('tasks.export.excel'));

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    }

    public function test_export_tasks_to_pdf(): void
    {
        $user = User::factory()->create(['role' => UserRole::Admin]);
        Sanctum::actingAs($user, ['*']);

        $reportService = Mockery::mock(TaskReportService::class);
        $reportService->shouldReceive('exportPdf')
            ->once()
            ->andReturn(Response::make('PDF Content', 200, ['Content-Type' => 'application/pdf']));

        $this->app->instance(TaskReportService::class, $reportService);

        $response = $this->get(route('tasks.export.pdf'));

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'application/pdf');
    }

    public function test_send_task_report(): void
    {
        $user = User::factory()->create(['role' => UserRole::Admin]);
        $users = User::factory()->count(10)->create();
        Sanctum::actingAs($user, ['*']);

        $reportService = Mockery::mock(TaskReportService::class);
        $reportService->shouldReceive('sendReport')
            ->once()
            ->with($users->pluck('id')->toArray());

        $this->app->instance(TaskReportService::class, $reportService);

        $response = $this->postJson(route('tasks.send-report'), [
            'user_ids' => $users->pluck('id')->toArray()
        ]);

        $response->assertStatus(200);
        $response->assertJson(['message' => 'Reports sent successfully']);
    }
}
