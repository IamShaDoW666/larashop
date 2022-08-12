<?php

namespace Database\Seeders;

use App\Models\Area;
use App\Models\Restorant;
use App\Models\Config;
use App\Models\Hour;
use Illuminate\Database\Seeder;

class RestorantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Restorant::factory()->create(['user_id' => 1])->each(function ($restorant) {
            $areas = Area::factory(3)->make();
            Config::create([
                'can_deliver' => true,
                'can_dinein' => true,
                'restorant_id' => $restorant->id
            ]);
            Hour::create(['restorant_id' => $restorant->id]);
            $restorant->areas(rand(1, 9))->saveMany($areas);
        });        
    }
}
