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
        Schema::table('kriteria', function (Blueprint $table) {
            // Mengubah tipe data kolom 'attribut' menjadi ENUM
            $table->enum('attribut', ['Benefit', 'Cost'])->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kriteria', function (Blueprint $table) {
            // Mengembalikan tipe data kolom 'attribut' ke string
            $table->string('attribut', 191)->change();
        });
    }
};
