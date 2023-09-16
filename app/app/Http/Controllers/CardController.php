<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCardRequest;
use App\Models\Card;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use OpenApi\Attributes as OA;

class CardController extends Controller
{
    #[OA\Post(
        path: "/api/v1/card",
        summary: "store new card",
        security: [
            [
                'bearerAuth' => []
            ]
        ],
        requestBody: new OA\RequestBody(required: true,
            content: new OA\MediaType(mediaType: "application/json",
                schema: new OA\Schema(required: ["card_number", "cvv", "expiration"],
                    properties: [
                        new OA\Property(property: 'card_number', description: "Card Number", type: "string"),
                        new OA\Property(property: 'cvv', description: "Card CVV", type: "string"),
                        new OA\Property(property: 'expiration', description: "card expiry", type: "string"),
                    ]
                ))),
        tags: ["Card"],
        responses: [
            new OA\Response(response: Response::HTTP_CREATED, description: "Card added Successfully"),
            new OA\Response(response: Response::HTTP_UNPROCESSABLE_ENTITY, description: "Unprocessable entity"),
            new OA\Response(response: Response::HTTP_BAD_REQUEST, description: "Bad Request"),
            new OA\Response(response: Response::HTTP_INTERNAL_SERVER_ERROR, description: "Server Error")
        ]
    )]
    public function store(StoreCardRequest $request) {
        $fields = $request->validated();

        Card::create([
            'user_id' => $request->user()->id,
            'card_number' => $fields['card_number'],
            'cvv' => $fields['cvv'],
            'expiration' => $fields['expiration']
        ]);

        return response([
            'success' => true,
            'message' => 'Card added successfully'
        ], Response::HTTP_CREATED);
    }
}
