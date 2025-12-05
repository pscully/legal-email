<?php

namespace App\Jobs;

use App\Mail\SendInvitationEmail;
use App\Models\Invitee;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;
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
     * The queue the job should be sent to.
     *
     * @var string
     */
    public $queue = 'invitations';

    /**
     * Create a new job instance.
     */
    public function __construct(
        public Invitee $invitee
    ) {}

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

        // Check rate limit: 200 emails per hour
        $rateLimitKey = 'email-invitations-global';
        $maxAttempts = 200;
        $decayMinutes = 60;

        if (RateLimiter::tooManyAttempts($rateLimitKey, $maxAttempts)) {
            // Release job back to queue for 60 seconds
            $this->release(60);
            return;
        }

        // Check if current time is within 7am-7pm window (EST)
        $now = Carbon::now('America/New_York');
        $startHour = 7;  // 7am EST
        $endHour = 19;   // 7pm EST

        if ($now->hour < $startHour || $now->hour >= $endHour) {
            // Calculate delay until 7am next valid day
            $nextValidTime = $now->copy();

            if ($now->hour >= $endHour) {
                // After 7pm, wait until 7am tomorrow
                $nextValidTime->addDay()->setTime($startHour, 0, 0);
            } else {
                // Before 7am, wait until 7am today
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

            // Hit the rate limiter
            RateLimiter::hit($rateLimitKey, $decayMinutes * 60);

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
