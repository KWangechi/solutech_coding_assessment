<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Actions\RegisterNewUser;
use Illuminate\Support\Facades\Auth;

class AuthenticationController extends Controller
{
    public function login(Request $request)
    {
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'Email not found',
                'status_code' => Response::HTTP_NOT_FOUND
            ]);
        }

        if (!Auth::attempt($request->only(['email', 'password']))) {
            return response()->json([
                'status' => false,
                "message" => "Username or Password Not Found!",
                'status_code' => Response::HTTP_NOT_FOUND,
                'data' => []
            ]);
        }

        return response()->json([
            'status' => true,
            'message' => "Login Successful!",
            'status_code' => Response::HTTP_CONTINUE,
            'data' => $user
        ]);
    }

    public function register(StoreUserRequest $storeUserRequest, RegisterNewUser $registerNewUser)
    {
        try {
            $user = $registerNewUser->handle($storeUserRequest);

            // dd($user);

            if (!$user) {
                return response()->json([
                    'status' => false,
                    'message' => "Something went wrong! Try again",
                    'status_code' => Response::HTTP_BAD_REQUEST,
                    'data' => [],
                ]);
            }
            return response()->json([
                'status' => true,
                'message' => "User Created Successfully!",
                'status_code' => Response::HTTP_CREATED,
                'data' => $user,
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
                'status_code' => Response::HTTP_BAD_REQUEST,
                'data' => [],
            ]);
        }
    }

    public function logout()
    {
        try {
            Auth::logout();
            return response()->json([
                'status' => true,
                'message' => "Logout Successful!",
                'status_code' => Response::HTTP_OK,
                'data' => [],
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
                'status' => Response::HTTP_BAD_REQUEST,
                'data' => []
            ]);
        }
    }
}
