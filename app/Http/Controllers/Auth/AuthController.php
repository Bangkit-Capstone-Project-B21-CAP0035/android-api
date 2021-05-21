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

    public function login(Request $request)
    {
        $this->validate($request, [
            'username' => ['required', 'alpha_num'],
            'password' => ['required', Password::min(8)->letters()]
        ]);

        if ($token = Auth::attempt($request->only('username', 'password'))) {
            return response()->json([
                'status' => 'success',
                'message' => 'Login Successfully',
                'data' => [
                    'api_token' => $token,
                    'token_type' => 'bearer',
                    'expires_in' => Auth::factory()->getTTL() * 60
                ],
            ], 200);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Please try to login again.',
        ], 401);
    }

    public function debug()
    {
        return User::all();
    }
}
