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
        if (Schema::hasTable('unit_people') === false) {
            Schema::create('unit_people', function (Blueprint $table) {
                $table->uuid('id')->primary()->default(DB::raw('(UUID())'));
                $table->char('person_id', 36);
                $table->char('unit_id', 36);
                $table->text('position'); //like 'KABAG' or 'KAUR' or just 'PEGAWAI' or even 'MAHASISWA' etc
                $table->date('start_date');
                $table->char('active', 1)->default('Y'); //to soft delete
                $table->string('createdby', 100);
                $table->string('updatedby', 100)->nullable();
                $table->timestamps();

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
        Schema::dropIfExists('unit_people');
    }
};
