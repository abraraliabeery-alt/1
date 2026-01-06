<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        $this->call([
            SettingsSeeder::class,
            RoleUserSeeder::class,
            ManagerUserSeeder::class,
            AdminUserSeeder::class,

            ProjectSeeder::class,
            GallerySeeder::class,
            TestimonialsSeeder::class,
            ServiceSeeder::class,
            PartnerSeeder::class,
            FaqSeeder::class,
            TenderDemoSeeder::class,

            DemoContractingServicesSeeder::class,
            DemoPropertiesSeeder::class,
            PropertySeeder::class,
            OneFullPropertySeeder::class,
        ]);
    }
}
