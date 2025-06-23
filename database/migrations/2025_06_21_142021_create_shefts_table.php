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
        Schema::create('shefts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->date('date');
            $table->boolean('is_closed')->default(false);
            $table->timestamps();
        });
        Schema::create('sale_header_sheft', function (Blueprint $table) {
            $table->primary(['sheft_id', 'sale_header_id']);
            $table->foreignId('sheft_id');
            $table->foreignId('sale_header_id');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shefts');
    }
};
