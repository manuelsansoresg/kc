<?php

namespace Database\Seeders;

use App\Models\CProduct;
use Illuminate\Database\Seeder;

class catalogProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $products = array('Crédito nónima', 'Crédito personal', 'Tarjeta de crédito');

        foreach ($products as $product) {
            $catalog = new CProduct(['name' => $product]);
            $catalog->save();
        }
    }
}
