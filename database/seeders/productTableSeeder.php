<?php

namespace Database\Seeders;


use App\Models\User;
use Illuminate\Database\Seeder;

class productTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i=0;$i<1;$i++)
        {
            User::create(
                [
                    'name'=>'admin',
                    'password'=>bcrypt('admin123'),
                    'email'=>'admin@gmail.com',
                    'perfil'=>'image/avatars/profiles/avatar-1.jpg',
                    'role'=>'ADMIN',
                    'phone'=>'999888777'
            ]);
        }
    }
}
