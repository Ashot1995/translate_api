<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        try {
            $path = public_path('world_university_names.sql');
            $sql = file_get_contents($path);
            DB::unprepared($sql);
        }catch(\ErrorException $e){
            dd($e->getMessage());
        }

    }
}
