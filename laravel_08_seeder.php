<?php
// PATH ...\database\seeds\UsersTableSeeder.php

//adciucionar na RUN(){} a classe UsersTableSeeder.php
// ...\database\seeds\DatabaseSeeder.php
// $this->call(UsersTableSeeder::class);

// ==============SEEDERS=COMANDOS======================
// // criar classe para inserir dados automaticamente na tabela
// php artisan make:seeder UsersTableSeeder

// // inserir dados dos seeders
// php artisan db:seed

// // se nao encontrar a classe seeder com comando php artisan db:seed
// //deve ser necessario recarregar o autoload no composer
// composer dump-autoload

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{

    public function run()
    {

      DB::table('users')->insert([
              'name' => Str::random(10),
              'email' => Str::random(10).'@gmail.com',
              'password' => bcrypt('password'),
          ]);

    }

}
