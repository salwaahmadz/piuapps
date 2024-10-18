<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            'name'   => 'AR',
            'description' => 'Umur 17 - 22 Tahun',
            'is_active' => true,
            'created_by' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ];

        Category::create($data);
    }
}
