<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegistrationRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class RegisteredUserController extends Controller
{
    #[OA\Post(
        path: "/api/v1/auth/register",
        summary: "signup",
        requestBody: new OA\RequestBody(required: true,
            content: new OA\MediaType(mediaType: "application/json",
                schema: new OA\Schema(required: ["first_name", "last_name", "email", "password", "password_confirmation"],
                    properties: [
                        new OA\Property(property: 'firstName', description: "User first name", type: "string"),
                        new OA\Property(property: 'lastName', description: "User last name", type: "string"),
                        new OA\Property(property: 'email', description: "User email", type: "string"),
                        new OA\Property(property: 'password', description: "User password", type: "string"),
                        new OA\Property(property: 'password_confirmation', description: "User password confirmation", type: "string")
                    ]
                ))),
        tags: ["Auth"],
        responses: [
            new OA\Response(response: ResponseAlias::HTTP_CREATED, description: "Register Successfully"),
            new OA\Response(response: ResponseAlias::HTTP_UNPROCESSABLE_ENTITY, description: "Unprocessable entity"),
            new OA\Response(response: ResponseAlias::HTTP_BAD_REQUEST, description: "Bad Request"),
            new OA\Response(response: ResponseAlias::HTTP_INTERNAL_SERVER_ERROR, description: "Server Error")
        ]
    )]
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
