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
        Schema::create('setorans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('peternak_id')->constrained()->onDelete('cascade');
            $table->integer('jumlah_pagi')->nullable();
            $table->integer('jumlah_sore')->nullable();
            $table->integer('jumlah_setoran');
            $table->date('tanggal_setoran');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('setorans');
    }
};
