<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMerchantRequest;
use App\Models\Merchant;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\Response;

class MerchantController extends Controller
{
    #[OA\Get(
        path: "/api/v1/merchant",
        summary: "List all merchants",
        security: [
            [
                'bearerAuth' => []
            ]
        ],
        tags: ["Merchant"],
        responses: [
            new OA\Response(response: Response::HTTP_OK, description: "merchants retrieved success"),
            new OA\Response(response: Response::HTTP_UNAUTHORIZED, description: "Unauthorized"),
            new OA\Response(response: Response::HTTP_NOT_FOUND, description: "not found"),
            new OA\Response(response: Response::HTTP_INTERNAL_SERVER_ERROR, description: "Server Error")
        ]
    )]
    public function index() {
        return response([
            'success' => true,
            'data' => Merchant::all()
        ]);
    }

    #[OA\Post(
        path: "/api/v1/merchant",
        summary: "add a new merchant",
        security: [
            [
                'bearerAuth' => []
            ]
        ],
        requestBody: new OA\RequestBody(required: true,
            content: new OA\MediaType(mediaType: "application/json",
                schema: new OA\Schema(required: ["name", "website"],
                    properties: [
                        new OA\Property(property: 'name', description: "Merchant name", type: "string"),
                        new OA\Property(property: 'website', description: "Merchant Website", type: "string"),
                    ]
                ))),
        tags: ["Merchant"],
        responses: [
            new OA\Response(response: Response::HTTP_CREATED, description: "Merchant added Successfully"),
            new OA\Response(response: Response::HTTP_UNPROCESSABLE_ENTITY, description: "Unprocessable entity"),
            new OA\Response(response: Response::HTTP_BAD_REQUEST, description: "Bad Request"),
            new OA\Response(response: Response::HTTP_INTERNAL_SERVER_ERROR, description: "Server Error")
        ]
    )]
    public function store(StoreMerchantRequest $request) {
        $fields = $request->validated();

        $merchant = Merchant::create([
            'name' => $fields['name'],
            'website' => $fields['website']
        ]);

        return response([
            'success' => 'true',
            'data' => [
                'merchant' => $merchant
            ]
        ], Response::HTTP_CREATED);
    }
}
