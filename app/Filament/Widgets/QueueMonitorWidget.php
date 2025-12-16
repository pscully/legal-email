<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;
use Illuminate\Support\Facades\DB;

class QueueMonitorWidget extends Widget
{
    protected string $view = 'filament.widgets.queue-monitor';

    protected static ?int $sort = 4;

    protected int | string | array $columnSpan = 'full';

    // Auto-refresh every 10 seconds
    protected static ?string $pollingInterval = '10s';

    public function getQueuedJobsCount(): int
    {
        return DB::table('jobs')->where('queue', 'invitations')->count();
    }

    public function getFailedJobsCount(): int
    {
        return DB::table('failed_jobs')->count();
    }

    public function getProcessingInfo(): string
    {
        $count = $this->getQueuedJobsCount();

        if ($count === 0) {
            return 'Queue is empty';
        }

        // Estimate time based on 400/hour rate limit
        $hoursNeeded = ceil($count / 400);

        if ($hoursNeeded <= 1) {
            return "Processing {$count} jobs (under 1 hour remaining)";
        }

        return "Processing {$count} jobs (~{$hoursNeeded} hours remaining)";
    }

    public function getRecentFailedJobs(): array
    {
        return DB::table('failed_jobs')
            ->orderBy('failed_at', 'desc')
            ->limit(5)
            ->get(['id', 'uuid', 'failed_at', 'exception'])
            ->map(function ($job) {
                // Extract just the first line of the exception
                $exceptionLines = explode("\n", $job->exception);
                $job->short_exception = $exceptionLines[0] ?? 'Unknown error';
                return $job;
            })
            ->toArray();
    }
}
