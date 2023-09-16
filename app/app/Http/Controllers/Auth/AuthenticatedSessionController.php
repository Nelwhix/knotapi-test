<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;
use OpenApi\Attributes as OA;


class AuthenticatedSessionController extends Controller
{
    #[OA\Post(
        path: "/api/v1/auth/login",
        summary: "login",
        requestBody: new OA\RequestBody(required: true,
            content: new OA\MediaType(mediaType: "application/json",
                schema: new OA\Schema(required: ["email", "password"],
                    properties: [
                        new OA\Property(property: 'email', description: "User email", type: "string"),
                        new OA\Property(property: 'password', description: "User password", type: "string"),
                    ]
                ))),
        tags: ["Auth"],
        responses: [
            new OA\Response(response: Response::HTTP_OK, description: "login success"),
            new OA\Response(response: Response::HTTP_UNPROCESSABLE_ENTITY, description: "Unprocessable entity"),
            new OA\Response(response: Response::HTTP_BAD_REQUEST, description: "Bad Request"),
            new OA\Response(response: Response::HTTP_INTERNAL_SERVER_ERROR, description: "Server Error")
        ]
    )]
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
