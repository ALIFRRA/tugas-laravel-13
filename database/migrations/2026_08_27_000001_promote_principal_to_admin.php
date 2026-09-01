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
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('users')
            ->where('role', 'guru')
            ->where('jabatan', 'like', 'Kepala Sekolah%')
            ->update(['role' => 'admin']);
    }

    public function down(): void
    {
        DB::table('users')
            ->where('role', 'admin')
            ->where('jabatan', 'like', 'Kepala Sekolah%')
            ->update(['role' => 'guru']);
    }
};
