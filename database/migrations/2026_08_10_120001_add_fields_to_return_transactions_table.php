<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('return_transactions', 'loan_id')) {
            Schema::table('return_transactions', function (Blueprint $table) {
                $table->foreignId('loan_id')->nullable()->after('id')->constrained('loans')->cascadeOnDelete();
                $table->foreignId('user_id')->nullable()->after('loan_id')->constrained('users')->nullOnDelete();
                $table->enum('condition_after', ['baik', 'rusak_ringan', 'rusak_berat'])->nullable();
                $table->text('notes')->nullable();
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('return_transactions', 'loan_id')) {
            Schema::table('return_transactions', function (Blueprint $table) {
                $table->dropForeign(['loan_id']);
                $table->dropForeign(['user_id']);
                $table->dropColumn(['loan_id', 'user_id', 'condition_after', 'notes']);
            });
        }
    }
};
