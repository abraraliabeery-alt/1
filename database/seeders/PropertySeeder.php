<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Property;
use App\Models\User;
use Illuminate\Support\Facades\Schema;

class PropertySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // If the properties table doesn't exist, skip gracefully to avoid QueryException
        if (!Schema::hasTable('properties')) {
            // Try to notify via CLI if available
            if (method_exists($this, 'command') && $this->command) {
                $this->command->warn('Skipping PropertySeeder: properties table not found. Run migrations first.');
            }
            return;
        }

        // Ensure we have an owner user to associate with properties (optional)
        $owner = User::where('is_staff', 1)->inRandomOrder()->first()
            ?? User::first();

        // Seed a reasonable number of demo properties
        Property::factory()->count(18)->create([
            'user_id' => optional($owner)->id,
            'city' => 'الرياض',
        ]);
    }
}
