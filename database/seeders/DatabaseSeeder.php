<?php

namespace Database\Seeders;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Seeder;
use App\Models\Restorant;
use App\Models\Area;
use App\Models\User;
use Database\Seeders\RolesAndPermissionSeeder;
use Spatie\Permission\Traits\HasRoles;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([RolesAndPermissionSeeder::class]);
        \App\Models\User::factory()->create([
          'name' => 'test',
          'email' => 'test@test.com'
        ]);
        User::find(1)->assignRole('Owner');
        \App\Models\User::factory(2)->create()->each(function($q) {
          $q->assignRole('Owner');
        });
        \App\Models\Category::factory(3)->create();
        \App\Models\Product::factory(15)->create();
        // \App\Models\Order::factory(8)->create();
        // \App\Models\Checkout::factory(8)->create();
        \App\Models\Restorant::factory()->create(['user_id' => 1])->each(function($restorant) {
          $areas = Area::factory(3)->make();
          $restorant->areas(rand(1,9))->saveMany($areas);
        });
        \App\Models\Restorant::factory(3)->create()->each(function($restorant, $index) {
          $areas = Area::factory(3)->make();
          $restorant->areas(rand(1,9))->saveMany($areas);
          if ($index == 1) {
            $restorant->user_id = 2;
          } else {
            $restorant->user_id = 3;
          }
        });


    }
}
