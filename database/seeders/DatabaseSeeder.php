<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        if(App::environment('local')){
            DB::table('users')->insert([
                [
                    'name'=> 'User',
                    'email' => 'user@gmail.com',
                    'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                    'email_verified_at' => now(),
                    'updated_at' => now(),
                    'created_at'=> now(),
                    'remember_token' => Str::random(10),
                    'google_id' => null,
                    'role' => 0
                ],
                [
                    'name'=> 'Admin',
                    'email' => 'admin@gmail.com',
                    'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                    'email_verified_at' => \now(),
                    'updated_at' => now(),
                    'created_at'=> now(),
                    'remember_token' => Str::random(10),
                    'google_id' => null,
                    'role' => 1
                ]
            ]);
            // \App\Models\User::factory(5)->create();
        }

    }
}
