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
        Schema::create('remita_deductions', function (Blueprint $table) {
            $table->id();
            $table->string('loanid')->nullable();
            $table->string('customer_id')->nullable();
            $table->string('amount')->nullable();
            $table->string('telephone')->nullable();
            $table->string('mandatereference')->nullable();
            $table->string('status')->nullable()->default('0');
            $table->string('authcode')->nullable();
            $table->string('type')->nullable()->default('One-Time');
            $table->integer('no_of_times')->nullable()->default('1');
            $table->date('start_date')->nullable();
            $table->integer('paid')->nullable()->default('0');
            $table->string('created_by')->nullable();
            $table->string('date_of_collection')->nullable();
            $table->string('balance')->nullable();
            $table->string('amount_paid')->nullable()->default('0');
            $table->integer('setup_type')->nullable()->default('0');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('remita_deductions');
    }
};
