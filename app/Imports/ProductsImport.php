<?php

namespace App\Imports;

use App\Models\Category;
use App\Models\Product;
use App\Models\Restorant;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductsImport implements ToModel, WithHeadingRow
{
    public function __construct(Restorant $restorant)
    {
        $this->restorant = $restorant;
        $this->lastCategoryName = "";
        $this->lastCategoryID = 0;
    }

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $category = Category::where(['name' => $row['category'], 'restorant_id' => $this->restorant->id])->first();
        $CATID = null;
        if ($category != null) {
            $CATID = $category->id;
        } else {
            //Check last inssert category
            if ($this->lastCategoryName == $row['category']) {
                $CATID = $this->lastCategoryID;
            }
        }
        if ($CATID != null) {

            $item = Product::where(['name' => $row['name'], 'category_id' => $CATID])->first();

            if ($item == null) {
                return new Product([
                    'name' => $row['name'],
                    'description' => $row['description'] ?? '',
                    'price' => money($row['price'], config('global.currency'), true)->getAmount(),
                    'category_id' => $CATID,
                    'image_path' => $row['image'] ?? '/imgs/32dfb5fb-bcf0-4b3c-8388-238ac128a5bf_xl.webp',
                ]);
            } else {
                //Update
                $item->price = money($row['price'], config('global.currency'), true)->getAmount();
                $item->image = $row['image'] ?? '/imgs/32dfb5fb-bcf0-4b3c-8388-238ac128a5bf_xl.webp';
                $item->category_id = $CATID;
                $item->description = $row['description'] ?? '';
            }
        } else {

            $categoryID = DB::table('categories')->insertGetId([
                'name' => $row['category'],
                'restorant_id' => $this->restorant->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            $this->lastCategoryID = $categoryID;
            $this->lastCategoryName = $row['category'];




            return new Product([
                'name' => $row['name'],
                'description' => $row['description'],
                'price' => money($row['price'], config('global.currency'), true)->getAmount(),
                'category_id' => $categoryID,
                'image_path' => $row['image'] ?? '/imgs/32dfb5fb-bcf0-4b3c-8388-238ac128a5bf_xl.webp',
            ]);
        }
    }
}
