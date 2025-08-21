<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /* Permission::create(['name' => 'Administración']);
        Permission::create(['name' => 'RRHH']); */
        Permission::create(['name' => 'Administración']);
        Permission::create(['name' => 'Gestionar colaboradores']);
        Permission::create(['name' => 'Otorgar Vo.Bo']);
        
    }
}
