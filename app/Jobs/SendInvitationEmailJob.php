<?php

namespace App\Jobs;

use App\Mail\SendInvitationEmail;
use App\Models\Invitee;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\Middleware\RateLimited;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class SendInvitationEmailJob implements ShouldQueue
{
    use Queueable, InteractsWithQueue, SerializesModels;

    /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public $tries = 3;

    /**
     * The number of seconds to wait before retrying the job.
     *
     * @var int
     */
    public $backoff = [60, 300, 900]; // 1 min, 5 min, 15 min

    /**
     * Create a new job instance.
     */
    public function __construct(
        public Invitee $invitee
    ) {
        $this->onQueue('invitations');
    }

    /**
     * Get the middleware the job should pass through.
     *
     * @return array<int, object>
     */
    public function middleware(): array
    {
        return [
            // Rate limit to 400 emails per hour for deliverability
            new RateLimited('email-deliverability'),
        ];
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Reload the invitee to ensure we have the latest DB state and
        // avoid sending emails for invitees whose status changed after the
        // job was dispatched but before it was handled.
        $this->invitee->refresh();

        // Only proceed if the invitee is still pending.
        if (! $this->invitee->isPending()) {
            return;
        }

        // Check if current time is within 6am-8pm window (EST)
        $now = Carbon::now('America/New_York');
        $startHour = 6;  // 6am EST
        $endHour = 20;   // 8pm EST

        if ($now->hour < $startHour || $now->hour >= $endHour) {
            // Calculate delay until 6am next valid day
            $nextValidTime = $now->copy();

            if ($now->hour >= $endHour) {
                // After 8pm, wait until 6am tomorrow
                $nextValidTime->addDay()->setTime($startHour, 0, 0);
            } else {
                // Before 6am, wait until 6am today
                $nextValidTime->setTime($startHour, 0, 0);
            }

            $secondsUntilValid = $nextValidTime->diffInSeconds($now);
            $this->release($secondsUntilValid);
            return;
        }

        // Both checks passed, attempt to send email
        try {
            Mail::to($this->invitee->email)->send(new SendInvitationEmail($this->invitee));

            // Mark as sent on success
            $this->invitee->markAsSent();

        } catch (\Exception $e) {
            // Mark as failed on exception
            $this->invitee->markAsFailed();

            // Log the error
            Log::error('Failed to send invitation email', [
                'invitee_id' => $this->invitee->id,
                'email' => $this->invitee->email,
                'error' => $e->getMessage(),
            ]);

            // Re-throw to trigger retry mechanism
            throw $e;
        }
    }
}
