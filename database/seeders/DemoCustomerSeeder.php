<?php

namespace Database\Seeders;

use App\Models\Plan;
use App\Models\ServiceRequest;
use App\Models\StaffMember;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DemoCustomerSeeder extends Seeder
{
    public function run(): void
    {
        $customer = User::updateOrCreate(
            ['email' => 'client@example.com'],
            [
                'name' => 'Olivia Harrison',
                'company' => 'Harrison & Co Ltd',
                'phone' => '+44 7700 900123',
                'password' => Hash::make('Client@12345'),
                'role' => 'customer',
                'email_verified_at' => now(),
            ]
        );

        $growthPlan = Plan::where('slug', 'growth')->first();
        $manager = StaffMember::where('role_title', 'accountant')->first();

        if ($growthPlan) {
            $subscription = Subscription::updateOrCreate(
                ['user_id' => $customer->id, 'plan_id' => $growthPlan->id],
                [
                    'hours_allocated' => $growthPlan->hours_per_month,
                    'hours_used' => 62,
                    'status' => 'active',
                    'started_at' => now()->subMonths(3),
                    'renews_at' => now()->addMonth(),
                    'account_manager_id' => $manager?->id,
                ]
            );

            ServiceRequest::updateOrCreate(
                ['user_id' => $customer->id, 'title' => 'Q2 VAT return submission'],
                [
                    'subscription_id' => $subscription->id,
                    'type' => 'vat',
                    'description' => 'Please prepare and submit our Q2 MTD VAT return.',
                    'status' => 'in_progress',
                    'priority' => 'high',
                ]
            );

            ServiceRequest::updateOrCreate(
                ['user_id' => $customer->id, 'title' => 'Payroll run for August'],
                [
                    'subscription_id' => $subscription->id,
                    'type' => 'payroll',
                    'description' => 'Process payroll for 8 employees, pay date 28th.',
                    'status' => 'pending',
                    'priority' => 'normal',
                ]
            );
        }
    }
}
