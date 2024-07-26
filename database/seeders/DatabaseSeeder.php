<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminRole = Role::firstOrcreate(
            [
                'name' => 'Super Admin',
            ],
        );

        $admin = User::firstOrCreate(
            [
                'username'      => 'admin',
            ],
            [
                'name'          => 'Super Admin',
                'password'      => 'admin',
            ],
        );

        $admin->assignRole($adminRole);
    }
}
