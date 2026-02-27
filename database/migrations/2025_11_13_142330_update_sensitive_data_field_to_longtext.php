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
        Schema::table('people', function (Blueprint $table) {
            $table->text('person')->change();
            $table->text('per_id')->change();
            $table->text('per_num')->change();
            $table->text('per_email')->change();
            $table->text('per_phone')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('people', function (Blueprint $table) {
            $table->string('person', 255)->change();
            $table->string('per_id', 255)->change();
            $table->string('per_num', 255)->change();
            $table->string('per_email', 255)->change();
            $table->string('per_phone', 255)->change();
        });
    }
};
