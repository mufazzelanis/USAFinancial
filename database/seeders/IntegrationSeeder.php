<?php

namespace Database\Seeders;

use App\Models\Integration;
use Illuminate\Database\Seeder;

class IntegrationSeeder extends Seeder
{
    public function run(): void
    {
        $compliance = [
            'QuickBooks', 'Sage', 'Capium', 'Odoo', 'Xero', 'Sage 50', 'Wave', 'FreeAgent',
            'Dext Prepare', 'Hubdoc', 'AutoEntry', 'IRIS KashFlow',
        ];

        $setup = [
            ['name' => 'QuickBooks', 'setup_price' => 15],
            ['name' => 'Sage', 'setup_price' => 25],
            ['name' => 'Capium', 'setup_price' => 19],
            ['name' => 'Odoo', 'setup_price' => 249],
            ['name' => 'Xero', 'setup_price' => 99],
            ['name' => 'Wave', 'setup_price' => 50],
            ['name' => 'Dext', 'setup_price' => 10],
        ];

        $sort = 1;
        foreach ($compliance as $name) {
            Integration::updateOrCreate(
                ['name' => $name, 'category' => 'integration'],
                ['sort_order' => $sort++, 'color' => 'slate']
            );
        }

        $sort = 1;
        foreach ($setup as $item) {
            Integration::updateOrCreate(
                ['name' => $item['name'], 'category' => 'setup'],
                ['setup_price' => $item['setup_price'], 'sort_order' => $sort++, 'color' => 'navy']
            );
        }

        Integration::updateOrCreate(
            ['name' => 'Smart POS', 'category' => 'pos'],
            ['setup_price' => 39, 'sort_order' => 1, 'color' => 'gold']
        );
    }
}
