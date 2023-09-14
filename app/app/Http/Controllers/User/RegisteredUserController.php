<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegistrationRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class RegisteredUserController extends Controller
{
    public function store(RegistrationRequest $request) {
        $fields = $request->validated();

        $user = User::create([
           'firstName' => $fields['firstName'],
           'lastName' => $fields['lastName'],
           'email' => $fields['email'],
            'password' => Hash::make($fields['password'])
        ]);

        return response([
            'success' => true,
            'data' => [
                'user' => $user
            ]
        ], Response::HTTP_CREATED);
    }
}
