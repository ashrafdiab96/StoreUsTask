<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    /**
     * @method register()
     * @desc register a new account
     * @param Request $request -> variable which carry the body
     * @return object
     */
    public function register(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|min:2|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8',
            ]);
            $user = User::create([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'password' => Hash::make($request->input('password')),
            ]);
            Auth::login($user);
            return response()->json([
                "message" => "Your account has been created successfully",
            ], 201);

        } catch(\Exception $e) {
            return response()->json([
                "message" => "An unexpected error is occured",
                "error" => $e->getMessage()
            ], 500);
        }
    }

    /**
     * @method login()
     * @desc login into user account
     * @param Request $request -> variable which carry the body
     * @return object
     */
    public function login(Request $request)
    {
        try {
            $credentials = $request->only('email', 'password');
            if (Auth::attempt($credentials)) {
                $user = User::where('email', $request->email)->first();
                $token = Str::random(80);
                $user->remember_token = $token;
                $user->save();
                return response()->json([
                    'user' => $user,
                    'token' => $token,
                ], 200);
            }
            return response()->json([
                'email' => 'Invalid login credentials'
            ], 401);

        } catch(\Exception $e) {
            return response()->json([
                "message" => "An unexpected error is occured",
                "error" => $e->getMessage()
            ], 500);
        }
    }

    /**
     * @method logout()
     * @desc logout from account
     * @return void
     */
    public function logout(Request $request)
    {
        try {
            $token = substr($request->header('Authorization'), 7);
            $user = User::where('remember_token', $token)->first();
            if (!$user) {
                return response()->json([
                    "message" => "Unautherized user",
                ], 401);
            }
            $user->remember_token = null;
            $user->save();
            Auth::logout();

            return response()->json([
                "message" => "logged out successfully"
            ], 200);

        } catch(\Exception $e) {
            return response()->json([
                "message" => "An unexpected error is occured",
                "error" => $e->getMessage()
            ], 500);
        }
    }

}
