<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            "uuid"      => Str::uuid(),
            "name"      => "Super Admin",
            "email"     => "superadmin@email.com",
            "password"  => Hash::make('password'),
        ];

        $user = User::create($data);
        $user->syncRoles(["Super Admin"]);
    }
}
