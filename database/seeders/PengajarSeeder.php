<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PengajarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        for ($i = 0; $i < 5; $i++) {
            DB::table('pengajar')->insert([
                'uuid'        => Str::uuid(),
                'nama'        => $faker->firstName(),
                'tgl_lahir'   => $faker->date('y-m-d'),
                'nomor_hp'    => $faker->phoneNumber(),
                'status'      => 1,
                'created_at'  => now(),
                'updated_at'  => now()
            ]);
        }
    }
}
