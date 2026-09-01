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
        if (Schema::hasTable('mata_pelajarans') && ! Schema::hasColumn('mata_pelajarans', 'deleted_at')) {
            Schema::table('mata_pelajarans', function (Blueprint $table) {
                $table->softDeletes();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('mata_pelajarans') && Schema::hasColumn('mata_pelajarans', 'deleted_at')) {
            Schema::table('mata_pelajarans', function (Blueprint $table) {
                $table->dropSoftDeletes();
            });
        }
    }
};
