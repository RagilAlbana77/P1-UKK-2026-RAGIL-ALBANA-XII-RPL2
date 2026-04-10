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
        Schema::create('alat', function (Blueprint $table) {
            $table->id();
            $table->string('kode_alat')->unique();
            $table->string('nama_alat');
            $table->unsignedInteger('stok_total');
            $table->unsignedInteger('stok_tersedia');
            $table->enum('kondisi', ['baik', 'rusak_ringan', 'rusak']);
            $table->boolean('status_ketersediaan')->default(true);
            $table->timestamps();

            $table->index('nama_alat');
            $table->index('status_ketersediaan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alat');
    }
};
