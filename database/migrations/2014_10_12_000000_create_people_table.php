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
                $table->uuid('id')->primary()->default(DB::raw('(UUID())'));
                $table->string('person', 100);
                $table->text('per_num');
                $table->text('per_id');
                $table->string('per_phone', 20);
                $table->string('per_email', 150);
                $table->text('per_group'); //it is either 'mahasiswa' or 'pegawai' or 'struktural'
                $table->char('active', 1)->default('Y'); //to soft delete
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
