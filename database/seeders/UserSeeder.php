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
        $data_user = array('name' => 'manuel',
        'email' => 'manuelsansoresg@gmail.com', 'password' => bcrypt('demor00txx'));
        $user = new User($data_user);
        $user->save();

        $data_user = array('name' => 'Daniel Vázquez',
        'email' => 'daniel.yalku+admin@gmail.com', 'password' => bcrypt('k8fK3TmJUJC7n8'));
        $user = new User($data_user);
        $user->save();
    }
}
