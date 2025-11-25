<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\NotificationService;
use App\Models\User;
use App\Models\JobOrder;

class TestNotifications extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:notifications';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test notification system';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Testing notification system...');

        // Get a customer and job order
        $customer = User::where('role', 'customer')->first();
        $jobOrder = JobOrder::first();

        if (!$customer || !$jobOrder) {
            $this->error('No customer or job order found for testing');
            return;
        }

        $this->info("Using customer: {$customer->name} ({$customer->npk})");
        $this->info("Using job order: {$jobOrder->project}");

        // Test notification service
        $notificationService = app(NotificationService::class);

        // Test create notification
        $this->info('Sending create notification...');
        $notificationService->notifyJobOrderCreated($jobOrder, $customer);

        // Check how many notifications were created
        $totalNotifications = \App\Models\Notification::count();
        $adminCount = User::where('role', 'admin')->count();

        $this->info("Total notifications in DB: {$totalNotifications}");
        $this->info("Total admin users: {$adminCount}");

        // Show recent notifications
        $recent = \App\Models\Notification::with(['actionBy'])->latest()->take(5)->get();
        $this->info('Recent notifications:');
        foreach ($recent as $notification) {
            $actionBy = $notification->actionBy ? $notification->actionBy->name : 'Unknown';
            $this->line("- {$notification->title} (User ID: {$notification->user_id}, From: {$actionBy})");
        }
    }
}
