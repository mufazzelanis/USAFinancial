<?php

namespace Database\Seeders;

use App\Models\StaffMember;
use Illuminate\Database\Seeder;

class StaffMemberSeeder extends Seeder
{
    public function run(): void
    {
        $staff = [
            ['name' => 'Emily Carter', 'email' => 'emily.carter@firstserveaccounting.co.uk', 'role_title' => 'accountant'],
            ['name' => 'James Whitfield', 'email' => 'james.whitfield@firstserveaccounting.co.uk', 'role_title' => 'accountant'],
            ['name' => 'Sophie Bennett', 'email' => 'sophie.bennett@firstserveaccounting.co.uk', 'role_title' => 'bookkeeper'],
            ['name' => 'Daniel Okafor', 'email' => 'daniel.okafor@firstserveaccounting.co.uk', 'role_title' => 'bookkeeper'],
            ['name' => 'Priya Nair', 'email' => 'priya.nair@firstserveaccounting.co.uk', 'role_title' => 'payroll_associate'],
        ];

        foreach ($staff as $member) {
            StaffMember::updateOrCreate(['email' => $member['email']], $member);
        }
    }
}
