<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class AuthenticatedSessionController extends Controller
{
    public function store(LoginRequest $request) {
        $fields = $request->validated();

        $user = User::where('email', $fields['email'])->first();
        if ($user === null) {
            return response([
                'success' => false,
               'message' => 'invalid email/password'
            ], Response::HTTP_BAD_REQUEST);
        }

        if (!Hash::check($fields['password'], $user->password)) {
            return response([
                'success' => false,
                'message' => 'invalid email/password'
            ], Response::HTTP_BAD_REQUEST);
        }

        $token = $user->createToken('access_token')->accessToken;

        return response([
            'success' => true,
            'data' => [
                ...$user->toArray(),
                'access_token' => $token
            ]
        ]);
    }

    public function destroy(Request $request) {
        $token = $request->user()->token();
        $token->revoke();

        return response([
            'success' => true,
            'message' => 'logout success'
        ]);
    }
}
