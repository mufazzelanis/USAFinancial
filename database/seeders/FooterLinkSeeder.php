<?php

namespace Database\Seeders;

use App\Models\FooterLink;
use Illuminate\Database\Seeder;

class FooterLinkSeeder extends Seeder
{
    public function run(): void
    {
        $links = [
            ['label' => 'Package', 'url' => '#package'],
            ['label' => 'Services', 'url' => '#services'],
            ['label' => 'Pricing', 'url' => '#pricing'],
            ['label' => 'Payroll', 'url' => '#payroll'],
            ['label' => 'Integrations', 'url' => '#integrations'],
        ];

        foreach ($links as $i => $link) {
            FooterLink::updateOrCreate(
                ['label' => $link['label']],
                $link + ['sort_order' => $i + 1, 'is_active' => true]
            );
        }
    }
}
