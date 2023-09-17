<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\Response;

class GetTaskHistory extends Controller
{
    #[OA\Get(
        path: "/api/v1/task-history",
        summary: "get latest task history for a user",
        security: [
            [
                'bearerAuth' => []
            ]
        ],
        tags: ["Task"],
        responses: [
            new OA\Response(response: Response::HTTP_OK, description: "task history retrieved success"),
            new OA\Response(response: Response::HTTP_UNAUTHORIZED, description: "Unauthorized"),
            new OA\Response(response: Response::HTTP_NOT_FOUND, description: "not found"),
            new OA\Response(response: Response::HTTP_INTERNAL_SERVER_ERROR, description: "Server Error")
        ]
    )]
    public function __invoke(Request $request)
    {
        $query = "
            WITH LatestTasks AS (
            SELECT
                t.merchant_id, t.id AS latest_task_id
            FROM
                tasks t
            WHERE
                t.user_id = :user_id
                AND t.status = 1
                AND t.updated_at = (
                    SELECT MAX(updated_at)
                    FROM tasks
                    WHERE merchant_id = t.merchant_id
                    AND user_id = :user_id
                    AND status = 1
                )
            GROUP BY
                t.merchant_id
        )

        SELECT
            lt.merchant_id,
            t.card_id
        FROM
            LatestTasks lt
        INNER JOIN
            tasks t ON lt.merchant_id = t.merchant_id AND lt.latest_task_id = t.id
        INNER JOIN
            cards c ON t.card_id = c.id;
        ";

        $results = DB::select($query, ['user_id' => $request->user()->id]);

        return response([
            'success' => true,
            'message' => "latest task history retrieved successfully",
            'data' => $results
        ]);
    }
}
