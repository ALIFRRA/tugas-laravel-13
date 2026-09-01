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
     * Run the migrations to ensure deleted_at exists across all tables.
     */
    public function up(): void
    {
        $tables = [
            'siswas',
            'gurus',
            'mata_pelajarans',
            'jadwals',
            'nilais',
            'pelanggarans',
            'pengumumans',
            'agendas',
            'ekskuls',
        ];

        foreach ($tables as $tableName) {
            if (Schema::hasTable($tableName)) {
                if (! Schema::hasColumn($tableName, 'deleted_at')) {
                    Schema::table($tableName, function (Blueprint $table) {
                        $table->softDeletes();
                    });
                }
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $tables = [
            'siswas',
            'gurus',
            'mata_pelajarans',
            'jadwals',
            'nilais',
            'pelanggarans',
            'pengumumans',
            'agendas',
            'ekskuls',
        ];

        foreach ($tables as $tableName) {
            if (Schema::hasTable($tableName) && Schema::hasColumn($tableName, 'deleted_at')) {
                Schema::table($tableName, function (Blueprint $table) {
                    $table->dropSoftDeletes();
                });
            }
        }
    }
};
