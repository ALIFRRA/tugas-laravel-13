<?php
/**
     * Run.
     *
     * @return public run
     */


namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            AcademicSeeder::class,
        ]);
    }
}
