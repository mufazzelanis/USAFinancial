<?php

namespace Database\Seeders;

use App\Models\PaymentGateway;
use Illuminate\Database\Seeder;

class PaymentGatewaySeeder extends Seeder
{
    public function run(): void
    {
        $gateways = [
            ['name' => 'Stripe', 'features' => ['Fast Setup', 'Global Payments', 'Online & In-Person']],
            ['name' => 'PayPal', 'features' => ['Secure Payments', 'Buyer Protection', 'Easy Integration']],
            ['name' => 'Wise', 'features' => ['Low Fees', 'Multi-currency', 'Fast Transfers']],
            ['name' => 'WorldPay', 'features' => ['Reliable & Secure', 'Multiple Currencies', 'Business Focused']],
            ['name' => 'Tide', 'features' => ['Business Account', 'Easy Accounting', 'Card Payments']],
            ['name' => 'SumUp', 'features' => ['Card Payments', 'Easy to Use', 'Low Cost']],
            ['name' => 'Adyen', 'features' => ['Global Coverage', 'Unified Platform', 'Advanced Security']],
            ['name' => 'Payoneer', 'features' => ['Global Payouts', 'Multi-currency', 'Business Growth']],
        ];

        foreach ($gateways as $i => $gateway) {
            PaymentGateway::updateOrCreate(
                ['name' => $gateway['name']],
                $gateway + ['sort_order' => $i + 1]
            );
        }
    }
}
