<?php

namespace App\Http\Controllers;

use App\Enums\Status;
use App\Http\Requests\StoreTaskRequest;
use App\Models\Task;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use OpenApi\Attributes as OA;

class TaskController extends Controller
{
    #[OA\Post(
        path: "/api/v1/task",
        summary: "store a new task",
        security: [
            [
                'bearerAuth' => []
            ]
        ],
        requestBody: new OA\RequestBody(required: true,
            content: new OA\MediaType(mediaType: "application/json",
                schema: new OA\Schema(required: ["card_id", "merchant_id"],
                    properties: [
                        new OA\Property(property: 'card_id', description: "ID for a stored card on the system", type: "string"),
                        new OA\Property(property: 'merchant_id', description: "ID for a merchant on the system, you can find that at GET /api/v1/merchant", type: "string"),
                    ]
                ))),
        tags: ["Task"],
        responses: [
            new OA\Response(response: Response::HTTP_CREATED, description: "Task added Successfully"),
            new OA\Response(response: Response::HTTP_UNPROCESSABLE_ENTITY, description: "Unprocessable entity"),
            new OA\Response(response: Response::HTTP_BAD_REQUEST, description: "Bad Request"),
            new OA\Response(response: Response::HTTP_INTERNAL_SERVER_ERROR, description: "Server Error")
        ]
    )]
    public function store(StoreTaskRequest $request) {
        $fields = $request->validated();

        Task::create([
            'user_id' => $request->user()->id,
            'merchant_id' => $fields['merchant_id'],
            'card_id' => $fields['card_id']
        ]);

        return response([
            'success' => true,
            'message' => "card switcher task created successfully"
        ], Response::HTTP_CREATED);
    }

    #[OA\Patch(
        path: "/api/v1/task/{uuid}",
        summary: "update task status",
        security: [
            [
                'bearerAuth' => []
            ]
        ],
        requestBody: new OA\RequestBody(required: true,
            content: new OA\MediaType(mediaType: "application/json",
                schema: new OA\Schema(required: ["status"],
                    properties: [
                        new OA\Property(property: 'status', description: "status of the task, 0 for failed. 1 for finished", type: "number"),
                    ]
                ))),
        tags: ["Task"],
        parameters: [
            new OA\Parameter(name: "uuid", description: "task's uuid", in: "path", required: true)
        ],
        responses: [
            new OA\Response(response: Response::HTTP_OK, description: "Task updated Successfully"),
            new OA\Response(response: Response::HTTP_UNPROCESSABLE_ENTITY, description: "Unprocessable entity"),
            new OA\Response(response: Response::HTTP_BAD_REQUEST, description: "Bad Request"),
            new OA\Response(response: Response::HTTP_INTERNAL_SERVER_ERROR, description: "Server Error")
        ]
    )]
    public function update(Request $request, Task $task) {
        $status = $request->input('status');

        if (!in_array($status, Status::values())) {
            return response([
                'success' => false,
                'message' => 'invalid status'
            ], Response::HTTP_BAD_REQUEST);
        }

        $task->status = $status;
        $task->save();

        return response([
            'success' => true,
            'message' => 'task status updated',
            'data' => $task
        ]);
    }
}
