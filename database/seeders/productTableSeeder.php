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
        for($i=0;$i<35;$i++)
        {
            User::create(
                [
                    'name'=>'repartidor'.$i,
                    'password'=>bcrypt('123123123'),
                    'email'=>'repartidor'.$i.'@gmail.com',
                    'perfil'=>'image/avatars/profiles/avatar-1.jpg',
                    'role'=>'REPA',
                    'phone'=>'999888777'
            ]);
        }
    }
}
