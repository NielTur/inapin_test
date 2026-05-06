<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dokumen_villa', function (Blueprint $table): void {
            $table->id('id_dokumen_villa');
            $table->unsignedBigInteger('id_villa');
            $table->unsignedBigInteger('id_owner')->nullable();
            $table->string('file_path');
            $table->enum('status', ['pending', 'disetujui', 'ditolak'])->default('disetujui');
            $table->timestamps();

            $table->foreign('id_villa')
                ->references('id_villa')
                ->on('villa')
                ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dokumen_villa');
    }
};
