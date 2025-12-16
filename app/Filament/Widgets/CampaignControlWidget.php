<?php

namespace App\Filament\Widgets;

use App\Models\Invitee;
use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Support\Enums\Size;
use Filament\Widgets\Widget;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;

class CampaignControlWidget extends Widget implements HasActions, HasForms
{
    use InteractsWithActions;
    use InteractsWithForms;

    protected string $view = 'filament.widgets.campaign-control';

    protected static ?int $sort = 3;

    protected int | string | array $columnSpan = 'full';

    public function getLastCampaignRun(): string
    {
        $lastRun = Cache::get('invitation_campaign_last_run');

        if ($lastRun === null) {
            return 'Never';
        }

        return $lastRun->format('M j, Y \a\t g:i A');
    }

    /**
     * Cached pending count for the widget lifecycle. This avoids repeated
     * database queries during a single render. The value is recalculated on
     * Livewire refresh (new component lifecycle) when the widget is refreshed.
     *
     * @var int|null
     */
    private ?int $cachedPendingCount = null;

    public function getPendingCount(): int
    {
        if ($this->cachedPendingCount === null) {
            $this->cachedPendingCount = Invitee::pending()->count();
        }

        return $this->cachedPendingCount;
    }

    public function getEstimatedCompletionTime(): string
    {
        $pendingCount = $this->getPendingCount();

        if ($pendingCount === 0) {
            return 'N/A';
        }

        // Calculate hours needed based on 400 emails/hour rate limit
        $hoursNeeded = ceil($pendingCount / 400);

        // Business hours: 6am-8pm = 14 hours/day
        $businessHoursPerDay = 14;

        if ($hoursNeeded <= $businessHoursPerDay) {
            return $hoursNeeded === 1 ? '1 hour' : "{$hoursNeeded} hours";
        }

        // Calculate days needed
        $daysNeeded = ceil($hoursNeeded / $businessHoursPerDay);
        $remainingHours = $hoursNeeded % $businessHoursPerDay;

        if ($remainingHours === 0) {
            return $daysNeeded === 1 ? '1 day' : "{$daysNeeded} days";
        }

        return "{$daysNeeded} days, {$remainingHours} hours";
    }

    public function getNextBatchInfo(): string
    {
        $pendingCount = $this->getPendingCount();

        if ($pendingCount === 0) {
            return 'No pending invitees';
        }

        $batchSize = min($pendingCount, 400);

        // Determine next run time based on business window (6am-8pm EST)
        $now = now('America/New_York');
        $startHour = 6;
        $endHour = 20;

        if ($now->hour < $startHour) {
            $nextRun = $now->copy()->setTime($startHour, 0, 0);
            $nextRunLabel = $nextRun->format('M j, g:i A');
            return "Next batch: {$batchSize} emails — next run at {$nextRunLabel}";
        }

        if ($now->hour >= $endHour) {
            $nextRun = $now->copy()->addDay()->setTime($startHour, 0, 0);
            $nextRunLabel = $nextRun->format('M j, g:i A');
            return "Next batch: {$batchSize} emails — next run at {$nextRunLabel}";
        }

        // During business hours: sending now
        return "Next batch: {$batchSize} emails — sending now";
    }

    public function startCampaignAction(): Action
    {
        return Action::make('startCampaign')
            ->label('Start Campaign')
            ->icon('heroicon-o-paper-airplane')
            ->color('success')
            ->size(Size::Large)
            ->requiresConfirmation()
            ->modalHeading('Start Email Campaign?')
            ->modalDescription(fn () => "This will queue {$this->getPendingCount()} pending invitations for delivery.")
            ->disabled(fn () => $this->getPendingCount() === 0)
            ->action(function () {
                Artisan::call('invitation:campaign');

                // Refresh this widget in-place so the dashboard updates without navigation
                $this->dispatch('$refresh');
            })
            ->successNotificationTitle('Campaign started successfully. Emails are being queued.');
    }
}
