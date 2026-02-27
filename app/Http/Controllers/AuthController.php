<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpKernel\Event\ResponseEvent;

use function PHPUnit\Framework\returnArgument;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(),
        [
            'username'=>'required|unique:users,username',
            'password'=>'required|min:6|confirmed',
        ]);

        if($validator->fails()){
            return response()->json([
                'message'=>'invalid field',
                'errors'=>$validator->errors()
            ], 422);
        }

        $user = User::create([
            'username'=>$request->username,
            'password'=>Hash::make($request->password),
        ]);
        return response()->json([
            'message'=>'register success'
        ], 200);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(),
        [
            'username'=>'required',
            'password'=>'required',
        ]);

        if($validator->fails()){
            return response()->json([
                'message'=>'Username or Password incorrect'
            ], 401);
        }

        $user = User::where('username', $request->username)->first();
        if(!$user || !Hash::check($request->password, $user->password)){
            return response()->json([
                'message'=>'Username or Password incoreect'
            ], 401);
        }

        $token = $user->createToken('auth.token')->plainTextToken;
        return Response()->json([
            'message'=>'Login success',
            'accessToken'=>$token
        ], 200);
    }

    public function logout(Request $request)
    {
        $user = $request->user();

        if($user){
            $user->currentAccessToken()->delete();
            return response()->json([
                'message'=>'Logout success'
            ], 200);
        }
        return response()->json([
            'message'=>'invalid token'
        ],401);

        
    }
}
