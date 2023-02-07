<?php

namespace App\Http\Controllers;

use App\Models\Grocery;
use Illuminate\Http\Request;

class SuperAdminController extends Controller
{
    public function index() 
    {
        $groceries = Grocery::all();
        return inertia('views/super/Groceries', compact('groceries'));
 
  
  
  
    }
}



