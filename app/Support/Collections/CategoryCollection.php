<?php

namespace App\Support\Collections;

use Illuminate\Database\Eloquent\Collection;

class CategoryCollection extends Collection
{
    public function all()
    {
        return $this->items;
    }
}