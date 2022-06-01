<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class CartController extends Controller
{
    public function index(User $user)
    {
      return $user;
    }
}
