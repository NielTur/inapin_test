<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fasilitas_villa', function (Blueprint $table): void {
            $table->id('id_fasilitas');
            $table->unsignedBigInteger('id_villa');
            $table->string('fasilitas');
            $table->timestamps();

            $table->foreign('id_villa')
                ->references('id_villa')
                ->on('villa')
                ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fasilitas_villa');
    }
};
