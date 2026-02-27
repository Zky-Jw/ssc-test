<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        Role::truncate();
        Schema::enableForeignKeyConstraints();
        $roles = [
            ['id' => '101', 'role' => 'Pengguna', 'createdby' => '999', 'created_at' => date('Y-m-d H:i:s')],
            ['id' => '102', 'role' => 'Petugas', 'createdby' => '999', 'created_at' => date('Y-m-d H:i:s')],
            ['id' => '103', 'role' => 'Pelaksana', 'createdby' => '999', 'created_at' => date('Y-m-d H:i:s')],
            ['id' => '104', 'role' => 'Pemimpin', 'createdby' => '999', 'created_at' => date('Y-m-d H:i:s')],
            ['id' => '105', 'role' => 'Pengamat', 'createdby' => '999', 'created_at' => date('Y-m-d H:i:s')],
            ['id' => '106', 'role' => 'Pengurus', 'createdby' => '999', 'created_at' => date('Y-m-d H:i:s')],
        ];
        //
        Role::insert($roles);
    }
}
