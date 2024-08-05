<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            "code" => "ROL0000001",
            "name" => "Super Admin",
            "guard_name" => "web",
            "description" => "ini super admin"
        ];

        Role::create($data);
    }
}
