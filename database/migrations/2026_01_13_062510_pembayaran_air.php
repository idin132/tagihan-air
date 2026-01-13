<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pembayaran_air', function (Blueprint $table) {
            $table->id(); // ID internal Laravel
            $table->string('bulan');
            $table->unsignedBigInteger('no_pelanggan');
            $table->integer('stand_meter_awal');
            $table->integer('stand_meter_akhir');
            $table->integer('stand_meter_total');
            $table->decimal('total_tagihan', 15, 2);
            $table->date('tanggal_pembayaran');
            $table->unsignedBigInteger('no_pengelola');
            $table->timestamps();

            // Relasi Foreign Key
            // $table->foreign('no_pelanggan')->references('no_pelanggan')->on('pelanggan')->onDelete('cascade');
            // $table->foreign('no_pengelola')->references('no_pengelola')->on('pengelola')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
