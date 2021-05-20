<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;
use App\Models\User;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $this->validate($request, [
            'name' => ['required'],
            'username' => ['required', 'unique:users,username', 'alpha_num'],
            'password' => ['required', Password::min(8)->letters()]
        ]);

        User::create( $request->except('password') + ['password' => Hash::make($request->password)] );

        return response()->json([
            'status' => 'success',
            'message' => 'Register Successfully'
        ], 200);
    }

    public function debug()
    {
        return User::all();
    }
}
