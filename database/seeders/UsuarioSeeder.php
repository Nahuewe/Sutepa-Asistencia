<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsuarioSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('users')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        DB::table('users')->insert([
            [
                'nombre' => 'NAHUEL',
                'apellido' => 'SORIA PARODI',
                'dni' => '43.532.773',
                'legajo' => '99999',
                'password' => Hash::make('99999'),
                'roles_id' => 1,
                'seccional_id' => 24,
            ],
            [
                'nombre' => 'GONZALO RAMIRO',
                'apellido' => 'TURATI',
                'dni' => '43.244.978',
                'legajo' => '11111',
                'password' => Hash::make('11111'),
                'roles_id' => 5,
                'seccional_id' => 3,
            ]
        ]);
    }
}