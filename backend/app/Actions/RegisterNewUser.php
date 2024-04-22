<?php

namespace App\Actions;

use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RegisterNewUser
{

    public function handle(StoreUserRequest $request)
    {
        return User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);
    }

    /**
     * Login Action
     */
    // static function login(Request $request) {
    //     $user = User::where('email', $request->email)->first();

    //     if (!$user) {
    //         return response()->json([
    //             'status' => false,
    //             'message' => 'Email not found',
    //             'status_code' => Response::HTTP_NOT_FOUND
    //         ]);
    //     }

    //     if (!Auth::attempt($request->only(['email', 'password']))) {
    //         return response()->json([
    //             'status' => false,
    //             "message" => "Username or Password Not Found!",
    //             'status_code' => Response::HTTP_NOT_FOUND,
    //             'data' => []
    //         ]);
    //     }

    //     return response()->json([
    //         'status' => true,
    //         'message' => "Login Successful!",
    //         'status_code' => Response::HTTP_CONTINUE,
    //         'data' => $user
    //     ]);
    // }
}
