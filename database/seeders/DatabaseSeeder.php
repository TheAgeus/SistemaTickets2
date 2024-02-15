<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        /* AGREAGR USUARIOS EMPLEADOS Y ADMIN */
        for($i=1; $i<=10; $i++){
            DB::table('users')->insert([
                'name' => Str::random(7) . ' ' . Str::random(7) . ' '. Str::random(7) . ' ' .Str::random(7),
                'email' => Str::random(10).'@example.com',
                'password' => Hash::make('password'),
                'email_verified_at' => '2024-02-08 19:25:52',
                'rfc' => Str::random(10),
            ]);

            if($i == 1) 
            {
                DB::table('tipos')->insert([
                    'user_id' => $i,
                    'rol' => 'ADMIN',
                ]);
            }
            elseif($i % 2 == 0) 
            {
                DB::table('tipos')->insert([
                    'user_id' => $i,
                    'rol' => 'EMPLEADO',
                ]);
            }
            else 
            {
                DB::table('tipos')->insert([
                    'user_id' => $i,
                    'rol' => 'CLIENTE',
                ]);
            }
        }

        /* AGREGAR TICKETS DE PRUEBA PENDIENTES */
        for($i=1; $i<=10; $i++) {
            DB::table('tickets')->insert([
                'titulo' => Str::random(7) . ' ' . Str::random(7) . ' '. Str::random(7) . ' ' .Str::random(7),
                'descripcion' => Str::random(17) . ' ' . Str::random(17) . ' '. Str::random(17) . ' ' .Str::random(17),
                'prioridad' => 'BAJA',
                'estado' => 'PENDIENTE',
            ]);
        }

        for($i=1; $i<=10; $i++) {
            DB::table('tickets')->insert([
                'titulo' => Str::random(7) . ' ' . Str::random(7) . ' '. Str::random(7) . ' ' .Str::random(7),
                'descripcion' => Str::random(17) . ' ' . Str::random(17) . ' '. Str::random(17) . ' ' .Str::random(17),
                'prioridad' => 'MEDIA',
                'estado' => 'PENDIENTE',
            ]);
        }

        for($i=1; $i<=10; $i++) {
            DB::table('tickets')->insert([
                'titulo' => Str::random(7) . ' ' . Str::random(7) . ' '. Str::random(7) . ' ' .Str::random(7),
                'descripcion' => Str::random(17) . ' ' . Str::random(17) . ' '. Str::random(17) . ' ' .Str::random(17),
                'prioridad' => 'ALTA',
                'estado' => 'PENDIENTE',
            ]);
        }

        /* ASIGNAR TICKET A EMPLEADOS Y A CLIENTES */


    }
}
