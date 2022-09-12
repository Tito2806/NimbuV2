<?php


namespace Database\Seeders;


use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->where('email', 'admin@gmail.com')->delete();

        DB::table('users')->insert([
            'name' => 'Titomeo',
            'email' => 'admin@gmail.com',
            'image' => 'profile.png',
            'password' => bcrypt('12345'),
            'rol' => 'Administrador',
        ]);
        DB::table('users')->insert([
            'name' => 'Nayeli',
            'email' => 'usuario@gmail.com',
            'image' => 'profile.png',
            'password' => bcrypt('12345'),
            'rol' => 'Usuario',
        ]);
    }
}