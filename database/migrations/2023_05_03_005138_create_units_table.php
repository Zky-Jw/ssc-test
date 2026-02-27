<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasTable('units') === false) {
            Schema::create('units', function (Blueprint $table) {
                $table->uuid('id')->primary()->default(DB::raw('(UUID())'));
                $table->string('unit', 100);
                $table->string('icons', 100)->nullable(); //filled with the icons 
                $table->string('icon', 100)->nullable(); //filled with icon name
                $table->string('colors', 100)->nullable(); //filled with the short version of unit name
                $table->string('unit_parent', 100)->nullable(); //if the unit is child like 'PRODI' to 'FAKULTAS'
                $table->char('show', 1)->default('Y'); //to soft delete
                $table->char('active', 1)->default('Y'); //to soft delete
                $table->string('createdby', 100);
                $table->string('updatedby', 100)->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('units');
    }
};
