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
        Schema::table('alternatif', function (Blueprint $table) {
            // rename columns
            $table->renameColumn('nip', 'jabatan');
            $table->renameColumn('jenis_kelamin', 'kelas');
            $table->dropColumn('tanggal_lahir');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('alternatif', function (Blueprint $table) {
            // rename columns
            $table->renameColumn('jabatan', 'nip');
            $table->renameColumn('kelas', 'jenis_kelamin');
            $table->date('tanggal_lahir');
        });
    }
};
