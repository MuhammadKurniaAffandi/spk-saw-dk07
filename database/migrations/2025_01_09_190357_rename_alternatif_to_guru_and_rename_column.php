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
        // Rename table from 'alternatif' to 'guru'
        Schema::rename('alternatif', 'guru');

        // Rename column 'nama_alternatif' to 'nama_guru'
        Schema::table('guru', function (Blueprint $table) {
            $table->renameColumn('nama_alternatif', 'nama_guru');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Rename column 'nama_guru' back to 'nama_alternatif'
        Schema::table('guru', function (Blueprint $table) {
            $table->renameColumn('nama_guru', 'nama_alternatif');
        });

        // Rename table back from 'guru' to 'alternatif'
        Schema::rename('guru', 'alternatif');
    }
};
