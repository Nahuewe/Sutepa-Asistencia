<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsuarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('users')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        DB::table('users')->insert([
            [
                'nombre' => 'Nahuel',
                'apellido' => 'Soria Parodi',
                'dni' => '43.532.773',
                'username' => '99999',
                'password' => Hash::make('99999'),
                'roles_id' => 1,
                'seccional_id' => 24,
            ]
        ]);
    }
}