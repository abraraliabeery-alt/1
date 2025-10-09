<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class RoleUserSeeder extends Seeder
{
    public function run(): void
    {
        // Manager account
        $manager = User::firstOrCreate(
            ['email' => 'manager@example.com'],
            [
                'name' => 'Site Manager',
                'password' => Hash::make('password'),
            ]
        );
        $manager->role = 'manager';
        $manager->is_staff = 1; // manager is implicitly staff too
        $manager->save();

        // Staff accounts
        $staff1 = User::firstOrCreate(
            ['email' => 'staff1@example.com'],
            [
                'name' => 'Staff One',
                'password' => Hash::make('password'),
            ]
        );
        $staff1->is_staff = 1;
        $staff1->role = 'user';
        $staff1->save();

        $staff2 = User::firstOrCreate(
            ['email' => 'staff2@example.com'],
            [
                'name' => 'Staff Two',
                'password' => Hash::make('password'),
            ]
        );
        $staff2->is_staff = 1;
        $staff2->role = 'user';
        $staff2->save();

        // Regular user (no staff)
        $user = User::firstOrCreate(
            ['email' => 'user@example.com'],
            [
                'name' => 'Regular User',
                'password' => Hash::make('password'),
            ]
        );
        $user->is_staff = 0;
        $user->role = 'user';
        $user->save();
    }
}
