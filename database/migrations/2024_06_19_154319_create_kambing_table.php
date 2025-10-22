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
        Schema::create('kambing', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->date('tanggal_lahir')->nullable();
            $table->string('name');
            $table->enum('type_goat', ['Etawa', 'Boer', 'Skeang', 'Saaren'])->nullable();
            $table->integer('age');
            $table->integer('age_now')->default(0);
            $table->enum('jenis_kelamin', ['Jantan', 'Betina']);
            $table->string('image');
            $table->string('imageCaption');
            $table->float('weight');
            $table->float('weight_now')->default(0);
            $table->enum('for_sale', ['yes', 'no'])->default('no');
            $table->string('faksin_status', 50)->nullable();
            $table->string('healt_status');
            $table->bigInteger('harga')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kambing');
    }
};
