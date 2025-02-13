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
        Schema::create('todos', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->boolean('status')->default(false); // false = belum selesai, true = selesai
            $table->integer('prioritas')->default(1); // 1-5
            $table->timestamp('tanggal_dibuat')->useCurrent();
            $table->timestamp('tanggal_diceklis')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('todos');
    }
};
