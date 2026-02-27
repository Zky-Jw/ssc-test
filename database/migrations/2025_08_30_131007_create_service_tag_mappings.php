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
        Schema::create('service_tag_mappings', function (Blueprint $table) {
            $table->uuid('service_id');
            $table->unsignedBigInteger('service_tag_id');
            $table->foreign('service_id')->references('id')->on('services')->onDelete('cascade');
            $table->foreign('service_tag_id')->references('id')->on('service_tags')->onDelete('cascade');

            $table->primary(['service_id', 'service_tag_id']);
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_tag_mappings');
    }
};
