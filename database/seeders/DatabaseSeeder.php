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
        for($i=0; $i<=10; $i++){
            DB::table('users')->insert([
                'name' => Str::random(7) . ' ' . Str::random(7) . ' '. Str::random(7) . ' ' .Str::random(7),
                'email' => Str::random(10).'@example.com',
                'password' => Hash::make('password'),
                'email_verified_at' => '2024-02-08 19:25:52',
                'rfc' => Str::random(10),
            ]);

            if($i == 0) 
            {
                DB::table('tipos')->insert([
                    'user_id' => $i + 1,
                    'rol' => 'ADMIN',
                ]);
            }
            else {
                DB::table('tipos')->insert([
                    'user_id' => $i + 1,
                    'rol' => 'EMPLEADO',
                ]);
            }
           
        }
    }
}
