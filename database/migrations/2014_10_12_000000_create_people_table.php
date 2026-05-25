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
    if (Schema::hasTable('people') === false) {
        Schema::create('people', function (Blueprint $table) {
            $table->uuid('id')->primary();
            // KOLOM YANG DIENKRIPSI HARUS LEBIH PANJANG (Gunakan text atau string 255+)
            $table->text('person');
            $table->text('per_num');
            $table->text('per_id');
            $table->text('per_phone'); // CipherSweet tidak akan muat di string(20)
            $table->text('per_email');
            $table->text('per_group');
            $table->char('active', 1)->default('Y');
            $table->timestamps();
        });
    }

   
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('people');
    }
};
