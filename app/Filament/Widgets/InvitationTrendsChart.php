<?php

namespace App\Filament\Widgets;

use App\Models\Invitee;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class InvitationTrendsChart extends ChartWidget
{
    protected ?string $heading = 'Invitation Trends (Last 30 Days)';

    protected static ?int $sort = 2;

    protected string $color = 'info';

    protected function getData(): array
    {
        $sentData = [];
        $acceptedData = [];
        $labels = [];

        // Define date range: last 30 days (including today)
        $start = now()->startOfDay()->subDays(29);
        $end = now()->endOfDay();

        // Single aggregated query for sent counts grouped by date
        $sentCounts = Invitee::selectRaw("DATE(sent_at) as date, COUNT(*) as count")
            ->whereNotNull('sent_at')
            ->whereBetween('sent_at', [$start, $end])
            ->groupBy('date')
            ->pluck('count', 'date')
            ->toArray();

        // Single aggregated query for accepted counts grouped by date
        $acceptedCounts = Invitee::selectRaw("DATE(accepted_at) as date, COUNT(*) as count")
            ->whereNotNull('accepted_at')
            ->whereBetween('accepted_at', [$start, $end])
            ->groupBy('date')
            ->pluck('count', 'date')
            ->toArray();

        // Build labels and data arrays by iterating days in PHP and looking up counts
        $current = $start->copy();
        while ($current->lte(now())) {
            $dateKey = $current->toDateString();
            $labels[] = $current->format('M d');
            $sentData[] = isset($sentCounts[$dateKey]) ? (int) $sentCounts[$dateKey] : 0;
            $acceptedData[] = isset($acceptedCounts[$dateKey]) ? (int) $acceptedCounts[$dateKey] : 0;
            $current->addDay();
        }

        return [
            'datasets' => [
                [
                    'label' => 'Sent',
                    'data' => $sentData,
                    'borderColor' => 'rgb(59, 130, 246)',
                    'backgroundColor' => 'rgba(59, 130, 246, 0.1)',
                    'fill' => true,
                    'tension' => 0.3,
                ],
                [
                    'label' => 'Accepted',
                    'data' => $acceptedData,
                    'borderColor' => 'rgb(34, 197, 94)',
                    'backgroundColor' => 'rgba(34, 197, 94, 0.1)',
                    'fill' => true,
                    'tension' => 0.3,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }

    protected function getOptions(): array
    {
        return [
            'responsive' => true,
            'maintainAspectRatio' => false,
            'plugins' => [
                'legend' => [
                    'display' => true,
                    'position' => 'top',
                ],
                'tooltip' => [
                    'enabled' => true,
                    'mode' => 'index',
                    'intersect' => false,
                ],
            ],
            'scales' => [
                'y' => [
                    'beginAtZero' => true,
                    'ticks' => [
                        'precision' => 0,
                    ],
                ],
            ],
            'interaction' => [
                'mode' => 'nearest',
                'axis' => 'x',
                'intersect' => false,
            ],
        ];
    }
}
