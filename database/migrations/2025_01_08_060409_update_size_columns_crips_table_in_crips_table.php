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
        Schema::table('crips', function (Blueprint $table) {
            //
            $table->string('nama_crips', 30)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('crips', function (Blueprint $table) {
            //
            $table->string('nama_crips', 191)->change();
        });
    }
};
