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
        if (Schema::hasTable('gurus') && Schema::hasColumn('gurus', 'mata_pelajaran')) {
            Schema::table('gurus', function (Blueprint $table) {
                $table->dropColumn('mata_pelajaran');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('gurus') && ! Schema::hasColumn('gurus', 'mata_pelajaran')) {
            Schema::table('gurus', function (Blueprint $table) {
                $table->string('mata_pelajaran')->nullable();
            });
        }
    }
};
