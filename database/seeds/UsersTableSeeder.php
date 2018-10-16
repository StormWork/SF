<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\User::class)->create([
            'email' => 'heisenberg@breakingbad.com',
            'password' => password_hash('test', PASSWORD_BCRYPT)
        ]);
        factory(App\User::class)->create([
            'email' => 'jesse@breakingbad.com',
            'password' => password_hash('testb', PASSWORD_BCRYPT)
        ]);
    }
}
