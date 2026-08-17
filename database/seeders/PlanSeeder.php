<?php

namespace Database\Seeders;

use App\Models\Plan;
use Illuminate\Database\Seeder;

class PlanSeeder extends Seeder
{
    public function run(): void
    {
        $plans = [
            [
                'name' => 'Basic Plan',
                'slug' => 'basic',
                'tagline' => 'Dedicated 160 Hours / Month',
                'price' => 40,
                'color' => 'green',
                'is_featured' => false,
                'sort_order' => 1,
                'features' => [
                    'Bookkeeping & Bank Reconciliation',
                    'Accounts Payable & Receivable',
                    'Payroll Processing',
                    'VAT Filing (MTD)',
                    'Management Reports',
                    'Email & Calendar Support',
                    'Data Entry & Record Keeping',
                ],
            ],
            [
                'name' => 'Growth Plan',
                'slug' => 'growth',
                'tagline' => 'Dedicated 160 Hours / Month',
                'price' => 50,
                'color' => 'blue',
                'is_featured' => true,
                'sort_order' => 2,
                'features' => [
                    'Everything in Basic Plan',
                    'Monthly Management Accounts',
                    'Budgeting & Cash Flow Analysis',
                    'Payroll & Auto Enrolment',
                    'Corporation Tax Support',
                    'Company Secretarial Support',
                    'Priority Support',
                ],
            ],
            [
                'name' => 'Enterprise Plan',
                'slug' => 'enterprise',
                'tagline' => 'Dedicated 160 Hours / Month',
                'price' => 60,
                'color' => 'purple',
                'is_featured' => false,
                'sort_order' => 3,
                'features' => [
                    'Everything in Growth Plan',
                    'Advanced Financial Reporting',
                    'MIS & KPI Dashboards',
                    'Audit Support',
                    'Business Advisory & Planning',
                    'Dedicated Account Manager',
                    'Full Compliance Management',
                ],
            ],
        ];

        foreach ($plans as $plan) {
            Plan::updateOrCreate(['slug' => $plan['slug']], $plan);
        }
    }
}
