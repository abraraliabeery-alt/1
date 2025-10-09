<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class ManagerUserSeeder extends Seeder
{
    public function run(): void
    {
        // Create or update a manager account
        $email = 'manager@toplevel.sa';
        $user = User::firstOrCreate(
            ['email' => $email],
            [
                'name' => 'مدير توب ليفل',
                // User model casts 'password' => 'hashed', so we can provide plain text here
                'password' => 'password123',
            ]
        );

        // Ensure proper roles/flags
        $user->role = 'manager';
        $user->is_staff = true;
        $user->save();
    }
}
