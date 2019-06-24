<?php

use App\User;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(User::class)->create([
            'password' => env('USER_PASSWORD', 'Test123'),
            'email' => env('USER_EMAIL', 'user@email.com'),
            'remember_token' => NULL,
        ]);
    }
}
