<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\Variant;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::factory(3)
                    ->has(Product::factory()->has(Variant::factory()->count(3))->count(3))
                    ->create();
        Product::factory(20)
                    ->has(Variant::factory()->count(3))
                    ->create();
        Product::factory(30)
                    ->create();                    
    }
}
