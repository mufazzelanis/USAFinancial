<?php

namespace Database\Seeders;

use App\Models\HourlyService;
use Illuminate\Database\Seeder;

class HourlyServiceSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            ['name' => 'Bookkeeping', 'slug' => 'bookkeeping', 'icon' => 'book-open', 'price_from' => 8, 'sort_order' => 1],
            ['name' => 'Accounting', 'slug' => 'accounting', 'icon' => 'document-text', 'price_from' => 9, 'sort_order' => 2],
            ['name' => 'Payroll', 'slug' => 'payroll', 'icon' => 'calculator', 'price_from' => 9, 'sort_order' => 3],
            ['name' => 'VAT Returns', 'slug' => 'vat-returns', 'icon' => 'user-group', 'price_from' => 8, 'sort_order' => 4],
            ['name' => 'Management Reporting', 'slug' => 'management-reporting', 'icon' => 'chart-bar', 'price_from' => 9, 'sort_order' => 5],
            ['name' => 'Company Secretarial', 'slug' => 'company-secretarial', 'icon' => 'pencil-square', 'price_from' => 10, 'sort_order' => 6],
            ['name' => 'Financial Consulting', 'slug' => 'financial-consulting', 'icon' => 'academic-cap', 'price_from' => 10, 'sort_order' => 7],
        ];

        foreach ($services as $service) {
            HourlyService::updateOrCreate(['slug' => $service['slug']], $service);
        }
    }
}
