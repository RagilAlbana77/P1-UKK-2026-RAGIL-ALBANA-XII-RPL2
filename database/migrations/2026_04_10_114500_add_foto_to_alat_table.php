<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('alat', function (Blueprint $table): void {
            $table->string('foto')->nullable()->after('nama_alat');
        });
    }

    public function down(): void
    {
        Schema::table('alat', function (Blueprint $table): void {
            $table->dropColumn('foto');
        });
    }
};
