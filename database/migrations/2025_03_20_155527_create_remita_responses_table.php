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
        Schema::create('remita_responses', function (Blueprint $table) {
            $table->id();
            $table->string('loanid')->nullable();
            $table->longText('request')->nullable();
            $table->longText('data')->nullable();
            $table->string('request_id')->nullable();
            $table->longText('parameter')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('remita_responses');
    }
};
