<?php

namespace Database\Seeders;

use App\Models\Participant;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ParticipantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            'uuid'         => Str::uuid(),
            'name'         => 'Salwa Ahmad Zanjabila',
            'category_id'  => 1,
            'birthdate'    => '2000-01-01',
            'phone_number' => '081234567890',
            'is_active'    => 1,
            'created_by'   => 1,
            'created_at'   => now(),
            'updated_at'   => now()
        ];

        Participant::create($data);
    }
}
