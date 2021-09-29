<?php

namespace App\Http\Controllers;

use App\Exceptions\ApiException;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class UserController extends Controller
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string',
            'password' => 'required|string'
        ]);

        if ($validator->fails()) {
            throw new ApiException(422, 'Validation error', $validator->errors());
        }

        $user = User::where([
            'email' => $request->email,
            'password' => $request->password,
        ])->first();


        if (!$user) {
            throw new ApiException(401, 'Authentication failed');
        }

        return [
            'data' => [
                'user_token' => $user->generateToken()
            ]
        ];
    }

    public function signup(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'fio' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6'
        ]);

        if ($validator->fails()) {
            throw new ApiException(422, 'Validation error', $validator->errors());
        }

        $user = User::create(
            $request->all()
            + [
                'role_id' => Role::where('code', 'user')->first()->id
            ]
        );

        return [
            'data' => [
                'user_token' => $user->generateToken()
            ]
        ];
    }

    public function logout()
    {
        Auth::user()->api_token = null;
        Auth::user()->save();
        return [
            'data' => [
                'message' => 'logout'
            ]
        ];
    }
}
