<?php

namespace App\Filament\Widgets;

use App\Models\Invitee;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class InviteeStatsWidget extends StatsOverviewWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $totalInvitees = Invitee::count();
        $pendingCount = Invitee::pending()->count();
        $sentCount = Invitee::sent()->count();
        $acceptedCount = Invitee::accepted()->count();
        $failedCount = Invitee::failed()->count();

        // Calculate acceptance rate
        $acceptanceRate = $sentCount > 0
            ? number_format(($acceptedCount / $sentCount) * 100, 1) . '%'
            : 'N/A';

        return [
            Stat::make('Total Invitees', $totalInvitees)
                ->icon('heroicon-o-users')
                ->color('primary'),

            Stat::make('Pending', $pendingCount)
                ->icon('heroicon-o-clock')
                ->color('gray'),

            Stat::make('Sent', $sentCount)
                ->icon('heroicon-o-paper-airplane')
                ->color('info'),

            Stat::make('Accepted', $acceptedCount)
                ->icon('heroicon-o-check-circle')
                ->color('success'),

            Stat::make('Failed', $failedCount)
                ->icon('heroicon-o-x-circle')
                ->color('danger'),

            Stat::make('Acceptance Rate', $acceptanceRate)
                ->icon('heroicon-o-chart-bar')
                ->color('success'),
        ];
    }
}
