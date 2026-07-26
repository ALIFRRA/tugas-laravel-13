<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->default('murid')->after('email')->index();
        });

        Schema::table('gurus', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable()->unique()->after('id')->constrained()->nullOnDelete();
        });

        Schema::table('siswas', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable()->unique()->after('id')->constrained()->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('siswas', function (Blueprint $table) {
            $table->dropConstrainedForeignId('user_id');
        });

        Schema::table('gurus', function (Blueprint $table) {
            $table->dropConstrainedForeignId('user_id');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('role');
        });
    }
};
