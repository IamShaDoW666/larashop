<?php

namespace Database\Seeders;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Seeder;
use App\Models\Restorant;
use App\Models\Area;
use App\Models\Config;
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
    $this->call([UserSeeder::class]);
    $this->call([CategorySeeder::class]);
    $this->call([RestorantSeeder::class]); 
  }
}
