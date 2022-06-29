<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function createToken(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'device_name' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }
        $user->tokens()->delete();
        $data = [
            'token' => $user->createToken($request->device_name)->plainTextToken,
            'name' => $user->name,
            'email' => $user->email
        ];

        return json_encode($data);

    }

    public function check(Request $request)
    {   
        $request->validate([
            'token' => 'required'
        ]);
        
        
    }

    public function logout(Request $request)
    {
        return $request->user()->tokens()->delete();
    }

}
