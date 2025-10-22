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
        Schema::create('domba_histories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('domba_id')->nullable();
            $table->string('bulan', 10)->nullable();
            $table->decimal('berat', 8, 2)->nullable();
            $table->decimal('harga', 12, 2)->nullable();
            $table->date('tanggal')->nullable();
            $table->timestamps();

            $table->foreign('domba_id')
                  ->references('id')->on('domba')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('domba_histories');
    }
};