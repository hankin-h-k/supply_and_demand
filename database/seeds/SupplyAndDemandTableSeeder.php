<?php

use Illuminate\Database\Seeder;

class SupplyAndDemandTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Models\SupplyAndDemand::class, 50)->create();
    }
}
