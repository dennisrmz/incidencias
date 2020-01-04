<?php

use Illuminate\Database\Seeder;
use Caffeinated\Shinobi\Models\Role;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create([
            'name'        => 'Admin',
            'slug'        => 'admin',
            'special'     => 'all-access' 
        ]);

        Role::create([
            'name'        => 'Encargado',
            'slug'        => 'encargado'
        ]);

        App\User::create([
            'name'=> 'administrador',
            'email'=> 'admin@gmail.com',
            'password'=> bcrypt('1234'),
        ]);

        DB::table('role_user')->insert([
            'role_id'  => '1',
            'user_id'   => '1',
           ]);

           DB::table('states')->insert([
            'id'  => '1',
            'nombre'   => 'En Espera',
           ]);
        
           DB::table('states')->insert([
            'id'  => '2',
            'nombre'   => 'En Progreso',
           ]);
           DB::table('states')->insert([
            'id'  => '3',
            'nombre'   => 'Finalizada',
           ]);
           DB::table('states')->insert([
            'id'  => '4',
            'nombre'   => 'Rechazada',
           ]);
    }
}
