<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            AdminUserSeeder::class,
            PlanSeeder::class,
            HourlyServiceSeeder::class,
            PayrollTierSeeder::class,
            IntegrationSeeder::class,
            PaymentGatewaySeeder::class,
            SiteSettingSeeder::class,
            FooterLinkSeeder::class,
            StaffMemberSeeder::class,
            DemoCustomerSeeder::class,
        ]);
    }
}
