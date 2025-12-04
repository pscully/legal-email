<?php

namespace App\Console\Commands;

use App\Jobs\SendInvitationEmailJob;
use App\Models\Invitee;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class InvitationCampaignCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'invitation:campaign';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Dispatch invitation emails for pending invitees';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        // Query all pending invitees
        $pendingInvitees = Invitee::pending()->get();
        $count = $pendingInvitees->count();

        // Display last campaign run time if available
        $lastRun = Cache::get('invitation_campaign_last_run');
        if ($lastRun !== null) {
            $this->info("Last campaign run: {$lastRun->format('M j, Y \a\t g:i A')}");
        }

        // Display count of pending invitees
        $this->info("Found {$count} pending invitees");

        if ($count === 0) {
            $this->info('No pending invitees to process');
            return self::SUCCESS;
        }

        // Add confirmation for large batches
        if ($count > 1000) {
            if (!$this->confirm("You are about to dispatch {$count} invitation emails. Do you want to continue?")) {
                $this->info('Operation cancelled');
                return self::SUCCESS;
            }
        }

        // Create progress bar
        $this->output->progressStart($count);

        // Dispatch jobs for each pending invitee
        foreach ($pendingInvitees as $invitee) {
            SendInvitationEmailJob::dispatch($invitee)->onQueue('invitations');
            $this->output->progressAdvance();
        }

        // Finish progress bar
        $this->output->progressFinish();

        // Store campaign execution timestamp in cache
        Cache::put('invitation_campaign_last_run', now(), now()->addDays(30));

        // Display success message
        $this->info("Successfully dispatched {$count} invitation emails to the queue");

        return self::SUCCESS;
    }
}
