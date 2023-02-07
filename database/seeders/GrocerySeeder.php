<?php

namespace Database\Seeders;

use App\Models\Area;
use App\Models\grocery;
use App\Models\Config;
use App\Models\Hour;
use Illuminate\Database\Seeder;

class grocerySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        grocery::factory()->create(['user_id' => 1])->each(function ($grocery) {
            $areas = Area::factory(3)->make();
            Config::create([
                'can_deliver' => true,
                'can_dinein' => true,
                'grocery_id' => $grocery->id
            ]);
            Hour::create(['grocery_id' => $grocery->id]);
            $grocery->areas(rand(1, 9))->saveMany($areas);            
        });        
    }
}
