<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('detail_pemesanan', function (Blueprint $table): void {
            $table->id('id_detail');
            $table->unsignedBigInteger('id_pemesanan');
            $table->unsignedBigInteger('id_pembayaran')->nullable();
            $table->date('tanggal_checkin');
            $table->date('tanggal_checkout');
            $table->decimal('harga_default', 15, 2);
            $table->decimal('sub_total', 15, 2);
            $table->timestamps();

            $table->foreign('id_pemesanan')
                ->references('id_pemesanan')->on('pemesanan')
                ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('detail_pemesanan');
    }
};
