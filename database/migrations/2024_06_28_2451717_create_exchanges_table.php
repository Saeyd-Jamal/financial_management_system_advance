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
        Schema::create('exchanges', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained('employees')->cascadeOnDelete();
            
            $table->decimal('receivables_discount', 10, 2)->default(0);
            $table->decimal('receivables_addition', 10, 2)->default(0);
            $table->decimal('savings_discount', 10, 2)->default(0);
            $table->decimal('savings_addition', 10, 2)->default(0);
            $table->decimal('association_loan', 10, 2)->default(0)->comment('قرض الجمعية');
            $table->decimal('savings_loan', 10, 2)->default(0)->comment('قرض إدخار');
            $table->decimal('shekel_loan', 10, 2)->default(0)->comment('قرض شيكل');

            $table->enum('exchange_type', ['receivables_discount','receivables_addition','savings_discount','savings_addition' ,'savings_loan', 'shekel_loan', 'association_loan','reward'])->nullable();
            
            $table->date('exchange_date');
            $table->text('notes')->nullable();
            $table->string('username');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exchanges');
    }
};
