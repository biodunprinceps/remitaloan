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
        Schema::create('loans', function (Blueprint $table) {
            $table->id();
            $table->string('firstname')->nullable();
            $table->string('lastname')->nullable();
            $table->string('email')->nullable();
            $table->string('telephone')->nullable();
            $table->string('gender')->nullable();
            $table->string('ippisnumber')->nullable();
            $table->string('house_address')->nullable();
            $table->string('place_of_work')->nullable();
            $table->float('loan_amount')->nullable();
            $table->integer('tenor')->nullable();
            $table->string('salary_bank_name')->nullable();
            $table->string('salary_bank_account')->nullable();
            $table->float('monthly_repayment')->nullable();
            $table->date('date_of_disbursement')->nullable();
            $table->date('firstrepaymentdate')->nullable();
            $table->date('maturity_date')->nullable();
            $table->date('dob')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loans');
    }
};
