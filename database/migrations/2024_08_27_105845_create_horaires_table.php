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
    Schema::create('horaires', function (Blueprint $table) {
        $table->id();
        
        $table->unsignedBigInteger('userId');
        $table->foreign('userId')->references('id')->on('users')->onDelete('cascade');
        $table->boolean('arriver')->default(false);
        $table->boolean('descente')->default(false);
        $table->dateTime('date')->nullable();
        $table->time('heurArriver')->nullable();
        $table->time('heurSortie')->nullable();
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('horaires');
    }
};
