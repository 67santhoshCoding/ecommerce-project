<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name'=>"Super Admin",
            'email'=>"superadmin@gmail.com",
            'password' => bcrypt('12345678'),
            'profile'=>'',
        ]);
        User::create([
            'name'=>"Admin",
            'email'=>"admin@gmail.com",
            'password' => bcrypt('12345678'),
            'profile'=>'',
        ]);
    }
}
