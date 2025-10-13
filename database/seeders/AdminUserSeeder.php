<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $u = User::firstOrCreate(
            ['email' => 'manager@example.com'],
            ['name' => 'Manager', 'password' => Hash::make('12345678')]
        );

        // تأكيد الصلاحيات وكلمة المرور
        $u->password = Hash::make('12345678');
        $u->is_staff = 1;
        $u->role = 'manager';
        $u->email_verified_at = now();
        $u->save();
    }
}
