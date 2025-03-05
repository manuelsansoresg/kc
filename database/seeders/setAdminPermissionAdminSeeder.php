<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class setAdminPermissionAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::whereHas("roles", function ($q) {
            $q->where("name", 'Administrador');
        })->get();
        foreach ($users as $user) {
            $user->givePermissionTo('Administración');
        }
    }
}
