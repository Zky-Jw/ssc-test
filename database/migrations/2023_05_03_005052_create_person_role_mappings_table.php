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
        if (Schema::hasTable('person_role_mappings') === false) {
            Schema::create('person_role_mappings', function (Blueprint $table) {
                $table->uuid('id')->primary()->default(DB::raw('(UUID())'));
                $table->char('person_id', 36);
                $table->char('role_id', 36);
                $table->char('active', 1)->default('Y'); //to soft delete
                $table->string('createdby', 100);
                $table->string('updatedby', 100)->nullable();
                $table->timestamps();

                $table->foreign('person_id')->references('id')->on('people');
                $table->foreign('role_id')->references('id')->on('roles');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('person_role_mappings');
    }
};
