<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Property;
use App\Models\User;

class PropertySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $owner = User::where('is_staff', 1)->inRandomOrder()->first() ?? User::first();
        Property::factory()->count(18)->create([
            'user_id' => optional($owner)->id,
            'city' => 'الرياض',
        ]);
    }
}
