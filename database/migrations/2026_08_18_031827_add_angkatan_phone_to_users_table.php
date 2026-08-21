<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('angkatan', 10)
                ->nullable()
                ->after('prodi');

            $table->string('phone', 20)
                ->nullable()
                ->after('angkatan');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'angkatan',
                'phone',
            ]);
        });
    }
};