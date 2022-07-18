<?php

namespace Database\Seeders;

use App\Models\CService;
use Illuminate\Database\Seeder;

class catalogServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $service = array('Crédito nuevo', 'Solución de crédito');

        foreach ($service as $service) {
            $catalog = new CService(['name' => $service]);
            $catalog->save();
        }
    }
}
