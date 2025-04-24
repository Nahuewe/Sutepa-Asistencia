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
                'username' => 'nsoria',
                'password' => Hash::make('123456'),
                'correo' => 'nahuelsoriap@gmail.com',
                'telefono' => "3834523702",
                'roles_id' => 1,
                'estados_id' => 1,
            ],
            [
                'nombre' => 'Monica',
                'apellido' => 'Parodi',
                'username' => 'mparodi',
                'password' => Hash::make('123456'),
                'correo' => 'monikparodi_70@hotmail.com',
                'telefono' => "3834606959",
                'roles_id' => 1,
                'estados_id' => 1,
            ]
        ]);
    }
}