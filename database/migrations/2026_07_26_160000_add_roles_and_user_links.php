<?php
/**
     * Down.
     *
     * @return public down
     */

    /**
     * Up.
     *
     * @return public up
     */


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('users') && ! Schema::hasColumn('users', 'role')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('role')->default('murid')->after('email')->index();
            });
        }

        if (Schema::hasTable('gurus') && ! Schema::hasColumn('gurus', 'user_id')) {
            Schema::table('gurus', function (Blueprint $table) {
                $table->foreignId('user_id')->nullable()->unique()->after('id')->constrained()->nullOnDelete();
            });
        }

        if (Schema::hasTable('siswas') && ! Schema::hasColumn('siswas', 'user_id')) {
            Schema::table('siswas', function (Blueprint $table) {
                $table->foreignId('user_id')->nullable()->unique()->after('id')->constrained()->nullOnDelete();
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('siswas') && Schema::hasColumn('siswas', 'user_id')) {
            Schema::table('siswas', function (Blueprint $table) {
                $table->dropConstrainedForeignId('user_id');
            });
        }

        if (Schema::hasTable('gurus') && Schema::hasColumn('gurus', 'user_id')) {
            Schema::table('gurus', function (Blueprint $table) {
                $table->dropConstrainedForeignId('user_id');
            });
        }

        if (Schema::hasTable('users') && Schema::hasColumn('users', 'role')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('role');
            });
        }
    }
};
