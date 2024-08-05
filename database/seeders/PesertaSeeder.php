<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PesertaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        for ($i = 0; $i < 20; $i++) {
            DB::table('peserta')->insert([
                'uuid'        => Str::uuid(),
                'kategori_id' => 1,
                'nama'        => $faker->firstName(),
                'tgl_lahir'   => $faker->date('y-m-d'),
                'status'      => 1,
                'created_at'  => now(),
                'updated_at'  => now()
            ]);
        }
    }
}
