<?php

namespace Database\Seeders;

use App\Models\ServiceCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class ServiceCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        ServiceCategory::truncate();
        Schema::enableForeignKeyConstraints();
        $categories = [
            ['category' => 'Rendah', 'type' => 'time', 'createdby' => '999', 'created_at' => date('Y-m-d H:i:s')],
            ['category' => 'Sedang', 'type' => 'time', 'createdby' => '999', 'created_at' => date('Y-m-d H:i:s')],
            ['category' => 'Tinggi', 'type' => 'time', 'createdby' => '999', 'created_at' => date('Y-m-d H:i:s')],
            ['category' => 'Urgent', 'type' => 'time', 'createdby' => '999', 'created_at' => date('Y-m-d H:i:s')],
            ['category' => 'Permintaan', 'type' => 'order', 'createdby' => '999', 'created_at' => date('Y-m-d H:i:s')],
            ['category' => 'Insiden', 'type' => 'order', 'createdby' => '999', 'created_at' => date('Y-m-d H:i:s')],
        ];
        //
        ServiceCategory::insert($categories);
    }
}
