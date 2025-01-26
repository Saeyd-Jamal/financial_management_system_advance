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
            $table->foreignId('employee_id')->constrained('employees')->cascadeOnDelete();
            $table->string('month');
            $table->decimal('association_loan', 10, 2)->default(0)->comment('قرض الجمعية');
            $table->decimal('savings_loan', 10, 2)->default(0)->comment('قرض إدخار');
            $table->decimal('shekel_loan', 10, 2)->default(0)->comment('قرض شيكل');
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
