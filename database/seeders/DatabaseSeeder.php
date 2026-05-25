<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Service;
use App\Models\ServiceAdditional;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        $this->call([
            RoleSeeder::class,
            ServiceCategorySeeder::class,
            PersonSeeder::class,
            PersonRoleMappingSeeder::class,
            UserSeeder::class,
            UnitSeeder::class,
            // ServiceSeeder::class,
            // ServiceAdditionalSeeder::class,
            // ServiceMappingSeeder::class,
            SSCFrontDeskAccountSeeder::class,
            ServiceMappingSeederAdditional::class,
            UnitPeopleSeeder::class,
            DocumentTemplateSeeder::class,
        ]);
    }
}