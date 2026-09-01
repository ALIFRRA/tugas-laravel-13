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
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasTable('gurus') && ! Schema::hasColumn('gurus', 'wali_kelas')) {
            Schema::table('gurus', function (Blueprint $table) {
                $table->string('wali_kelas')->nullable()->after('no_telepon');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('gurus') && Schema::hasColumn('gurus', 'wali_kelas')) {
            Schema::table('gurus', function (Blueprint $table) {
                $table->dropColumn('wali_kelas');
            });
        }
    }
};
