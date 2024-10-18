<?php

namespace Database\Seeders;

use App\Models\Mentor;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class MentorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            'uuid'         => Str::uuid(),
            'name'         => 'Mentor 1',
            'birthdate'    => '2000-01-01',
            'phone_number' => '081234567890',
            'is_active'    => 1,
            'created_by'   => 1,
            'created_at'   => now(),
            'updated_at'   => now()
        ];

        Mentor::create($data);
    }
}
