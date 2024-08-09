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
        Schema::create('tagihan', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('pinjaman_id');
            $table->integer('angsuran');
            $table->decimal('tagihan_pokok', 13, 2);
            $table->decimal('tunggakan', 13, 2)->nullable();
            $table->decimal('total_tagihan', 13, 2);
            $table->date('jatuh_tempo')->nullable();
            $table->string('status');
            $table->timestamps();

            $table->foreign('pinjaman_id')->references('id')->on('pinjaman')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tagihan');
    }
};
