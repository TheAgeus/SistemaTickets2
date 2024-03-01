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
        
        DB::table('users')->insert([
            'name' => 'Ageus Admin',
            'email' => 'ageus94@gmail.com',
            'password' => Hash::make('password'),
            'email_verified_at' => '2024-02-08 19:25:52',
            'rfc' => Str::random(10),
        ]);
        DB::table('users')->insert([
            'name' => 'Ageus Empleado',
            'email' => 'ageus699@gmail.com',
            'password' => Hash::make('password'),
            'email_verified_at' => '2024-02-08 19:25:52',
            'rfc' => Str::random(10),
        ]);
        DB::table('users')->insert([
            'name' => 'Armando Cliente',
            'email' => 'newlifenv@hotmail.com',
            'password' => Hash::make('password'),
            'email_verified_at' => '2024-02-08 19:25:52',
            'rfc' => Str::random(10),
        ]);
        DB::table('tipos')->insert([
            'user_id' => 1,
            'rol' => 'ADMIN',
        ]);
        DB::table('tipos')->insert([
            'user_id' => 2,
            'rol' => 'EMPLEADO',
        ]);
        DB::table('tipos')->insert([
            'user_id' => 3,
            'rol' => 'CLIENTE',
        ]);

        /*
        for($i=1; $i<=10; $i++)
        {

            DB::table('users')->insert([
                'name' => 'Usuario Userino ' . $i,
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
        */
        /* AGREGAR TICKETS DE PRUEBA PENDIENTES */
        /*
        for($i=1; $i<=10; $i++) 
        {
            DB::table('tickets')->insert([
                'titulo' => Str::random(7) . ' ' . Str::random(7) . ' '. Str::random(7) . ' ' .Str::random(7),
                'descripcion' => Str::random(17) . ' ' . Str::random(17) . ' '. Str::random(17) . ' ' .Str::random(17),
                'prioridad' => 'BAJA',
                'estado' => 'PENDIENTE',
            ]);
            DB::table('ticket_user')->insert([ // Todos estos tickets son del cliente con id de usuario 3
                'cliente_id' => '3',
                'ticket_id' => $i
            ]);
        }
        */
    }
}
