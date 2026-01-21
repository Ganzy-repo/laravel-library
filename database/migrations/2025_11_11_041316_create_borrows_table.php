<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('borrows', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('book_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->enum('status_borrow', ['pending', 'borrowed', 'returned', 'overdue', 'cancelled'])->default('pending');
            $table->integer('qty');
            $table->date('start_borrow');
            $table->date('exp_borrow');
            $table->date('return_date')->nullable();
            $table->date('real_return_date')->nullable();
            $table->decimal('fine', 10, 2)->nullable()->default(0);
            $table->timestamps();
            
            $table->index(['member_id', 'status_borrow']);
            $table->index(['exp_borrow', 'status_borrow']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('borrows');
    }
};