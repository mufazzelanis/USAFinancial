<?php

namespace Database\Seeders;

use App\Models\PayrollTier;
use Illuminate\Database\Seeder;

class PayrollTierSeeder extends Seeder
{
    public function run(): void
    {
        $features = ['Payslips & P60', 'RTI Submissions', 'Auto Enrolment', 'Pension Support'];

        $tiers = [
            ['name' => 'Payroll for UK LTD', 'employee_limit' => 5, 'price' => 15, 'sort_order' => 1],
            ['name' => 'Payroll for UK LTD', 'employee_limit' => 10, 'price' => 25, 'sort_order' => 2],
            ['name' => 'Payroll for UK LTD', 'employee_limit' => 25, 'price' => 35, 'sort_order' => 3],
        ];

        foreach ($tiers as $tier) {
            PayrollTier::updateOrCreate(
                ['employee_limit' => $tier['employee_limit']],
                $tier + ['features' => $features]
            );
        }
    }
}
