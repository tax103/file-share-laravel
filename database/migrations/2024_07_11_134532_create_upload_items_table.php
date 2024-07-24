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
        Schema::create('upload_items', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('file_name');
            $table->string('mail');
            $table->date('limit_date');
            $table->string('password')->nullable();
            $table->string('file_key')->index();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('upload_items');
    }
};
