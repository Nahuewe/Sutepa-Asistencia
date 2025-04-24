<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SexoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('sexo')->insert([
            ['nombre' => 'HOMBRE'],
            ['nombre' => 'MUJER'],
            ['nombre' => 'NO INFORMA'],
        ]);
    }
}
