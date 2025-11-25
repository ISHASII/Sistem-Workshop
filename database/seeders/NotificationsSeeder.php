<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Notification;
use App\Models\User;
use App\Models\JobOrder;

class NotificationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get admin users and sample job orders
        $adminUsers = User::where('role', 'admin')->get();
        $customers = User::where('role', 'customer')->get();
        $jobOrders = JobOrder::take(3)->get();

        if ($adminUsers->count() > 0 && $customers->count() > 0 && $jobOrders->count() > 0) {
            foreach ($adminUsers as $admin) {
                // Create some sample notifications
                Notification::create([
                    'title' => 'Job Order Baru',
                    'message' => "Job Order baru dengan project '{$jobOrders[0]->project}' telah dibuat oleh {$customers->first()->name} ({$customers->first()->npk})",
                    'type' => 'job_order_created',
                    'user_id' => $admin->id,
                    'job_order_id' => $jobOrders[0]->id,
                    'action_by' => $customers->first()->id,
                    'data' => [
                        'job_order_project' => $jobOrders[0]->project,
                        'job_order_seksi' => $jobOrders[0]->seksi,
                        'job_order_area' => $jobOrders[0]->area,
                        'action_by_name' => $customers->first()->name,
                        'action_by_npk' => $customers->first()->npk,
                    ]
                ]);

                if ($jobOrders->count() > 1) {
                    Notification::create([
                        'title' => 'Job Order Diperbarui',
                        'message' => "Job Order dengan project '{$jobOrders[1]->project}' telah diperbarui oleh {$customers->first()->name} ({$customers->first()->npk})",
                        'type' => 'job_order_updated',
                        'user_id' => $admin->id,
                        'job_order_id' => $jobOrders[1]->id,
                        'action_by' => $customers->first()->id,
                        'data' => [
                            'job_order_project' => $jobOrders[1]->project,
                            'job_order_seksi' => $jobOrders[1]->seksi,
                            'job_order_area' => $jobOrders[1]->area,
                            'action_by_name' => $customers->first()->name,
                            'action_by_npk' => $customers->first()->npk,
                        ]
                    ]);
                }
            }
        }
    }
}
