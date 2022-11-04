<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $user = [
            'id' => null,
            'name' => '',
            'email' => '',
            'password' => bcrypt('admin123')
        ];

        for ($i = 1; $i <= 5; $i++) {
            $user['id'] = $i;
            $user['name'] = 'admin'.$i;
            $user['email'] = 'admin'.$i.'@gmail.com';

            User::updateOrCreate([
                'id' => $user['id']
            ], $user);
        }
    }
}
