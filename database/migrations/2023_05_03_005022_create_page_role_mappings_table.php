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
        if (Schema::hasTable('page_role_mappings') === false) {
            Schema::create('page_role_mappings', function (Blueprint $table) {
                $table->uuid('id')->primary()->default(DB::raw('(UUID())'));
                $table->char('page_id', 36);
                $table->char('role_id', 36);
                $table->string('access', 50); //CRUD in json
                $table->char('active', 1)->default('Y'); //to soft delete
                $table->string('createdby', 100);
                $table->string('updatedby', 100)->nullable();
                $table->timestamps();

                $table->foreign('page_id')->references('id')->on('pages');
                $table->foreign('role_id')->references('id')->on('roles');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('page_role_mappings');
    }
};
