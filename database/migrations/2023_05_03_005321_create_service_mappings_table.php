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
        if (Schema::hasTable('service_mappings') === false) {
            Schema::create('service_mappings', function (Blueprint $table) {
                $table->uuid('id')->primary()->default(DB::raw('(UUID())'));
                $table->char('service_id', 36);
                $table->char('unit_id', 36)->nullable();
                $table->char('service_category_id', 150)->nullable();
                $table->char('service_additional_id', 36)->nullable();
                $table->char('person_id', 36)->nullable();
                $table->char('active', 1)->default('Y'); //to soft delete
                $table->string('createdby', 100);
                $table->string('updatedby', 100)->nullable();
                $table->timestamps();

                $table->foreign('service_additional_id')->references('id')->on('service_additionals');
                $table->foreign('service_id')->references('id')->on('services');
                $table->foreign('unit_id')->references('id')->on('units');
                $table->foreign('person_id')->references('id')->on('people');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_mappings');
    }
};
