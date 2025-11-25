<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\JobOrder;
use App\Models\User;

class UpdateJobOrderCreators extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-job-order-creators {--assign-to=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update existing job orders to assign a creator (created_by field)';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Updating job orders with created_by field...');

        // Find job orders without created_by
        $jobOrdersWithoutCreator = JobOrder::whereNull('created_by')->count();

        if ($jobOrdersWithoutCreator === 0) {
            $this->info('All job orders already have creators assigned.');
            return;
        }

        $this->info("Found {$jobOrdersWithoutCreator} job orders without creators.");

        // Get the user to assign to
        $assignToId = $this->option('assign-to');

        if (!$assignToId) {
            // Show available users
            $users = User::all(['id', 'name', 'username', 'role']);

            $this->table(
                ['ID', 'Name', 'Username', 'Role'],
                $users->map(fn($user) => [$user->id, $user->name, $user->username, $user->role])
            );

            $assignToId = $this->ask('Enter the user ID to assign existing job orders to (or press Enter to skip)');

            if (!$assignToId) {
                $this->info('Skipping update. Existing job orders will remain without creators.');
                return;
            }
        }

        // Validate user exists
        $user = User::find($assignToId);
        if (!$user) {
            $this->error("User with ID {$assignToId} not found.");
            return;
        }

        // Confirm the action
        if (!$this->confirm("Assign all existing job orders without creators to {$user->name} ({$user->username})?")) {
            $this->info('Operation cancelled.');
            return;
        }

        // Update job orders
        $updated = JobOrder::whereNull('created_by')->update(['created_by' => $assignToId]);

        $this->info("Successfully updated {$updated} job orders.");
        $this->info("All job orders now have creators assigned.");
    }
}
