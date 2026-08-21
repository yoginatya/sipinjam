<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('loans', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->string('loan_code')->unique();

            $table->date('borrow_date');
            $table->date('return_date');

            $table->text('purpose')->nullable();

            $table->enum('status', [
                'pending',
                'approved',
                'borrowed',
                'returned',
                'rejected',
                'cancelled'
            ])->default('pending');

            $table->timestamp('approved_at')->nullable();
            $table->timestamp('returned_at')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('loans');
    }
};
