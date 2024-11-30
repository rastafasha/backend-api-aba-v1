<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Resources\PaginatedResourceCollection;
use App\Http\Resources\User\UserV2Resource;

/**
 * @OA\Schema(
 *     schema="PaginatedUserResponse",
 *     @OA\Property(property="current_page", type="integer", example=1),
 *     @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/User")),
 *     @OA\Property(property="first_page_url", type="string", example="http://example.com/api/v2/users?page=1"),
 *     @OA\Property(property="from", type="integer", example=1),
 *     @OA\Property(property="last_page", type="integer", example=1),
 *     @OA\Property(property="last_page_url", type="string", example="http://example.com/api/v2/users?page=1"),
 *     @OA\Property(property="next_page_url", type="string", nullable=true),
 *     @OA\Property(property="path", type="string", example="http://example.com/api/v2/users"),
 *     @OA\Property(property="per_page", type="integer", example=15),
 *     @OA\Property(property="prev_page_url", type="string", nullable=true),
 *     @OA\Property(property="to", type="integer", example=15),
 *     @OA\Property(property="total", type="integer", example=100)
 * )
 */
class UserV2Controller extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/v2/users",
     *     summary="Get paginated users",
     *     description="Retrieves a paginated list of users with optional filters",
     *     tags={"Users"},
     *     @OA\Parameter(
     *         name="role",
     *         in="query",
     *         description="Filter by user role",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="include",
     *         in="query",
     *         description="Include related models (comma-separated). Options: locations",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="per_page",
     *         in="query",
     *         description="Number of items per page",
     *         required=false,
     *         @OA\Schema(type="integer", default=15)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(
     *                 property="data",
     *                 ref="#/components/schemas/PaginatedUserResponse"
     *             )
     *         )
     *     )
     * )
     */
    public function index(Request $request)
    {
        $query = User::query();

        // Filter by role if provided
        if ($request->has('role')) {
            $query->role($request->role);
        }

        // Handle includes
        $allowedIncludes = ['locations'];
        $includes = [];
        if ($request->has('include')) {
            $includes = array_filter(
                explode(',', $request->input('include')),
                fn($include) => in_array(trim($include), $allowedIncludes)
            );
        }

        // Get paginated results
        $perPage = $request->input('per_page', 15);
        $users = $query->with($includes)
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);

        return response()->json([
            'status' => 'success',
            'data' => new PaginatedResourceCollection($users, UserV2Resource::class)
        ]);
    }

    /**
     * @OA\Get(
     *     path="/api/v2/users/{id}",
     *     summary="Get a single user",
     *     description="Retrieves a specific user by their ID",
     *     tags={"Users"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the user",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="include",
     *         in="query",
     *         description="Include related models (comma-separated). Options: locations",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 ref="#/components/schemas/User"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="User not found",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="message", type="string", example="User not found")
     *         )
     *     )
     * )
     */
    public function show(Request $request, $id)
    {
        // Handle includes
        $allowedIncludes = ['locations'];
        $includes = [];
        if ($request->has('include')) {
            $includes = array_filter(
                explode(',', $request->input('include')),
                fn($include) => in_array(trim($include), $allowedIncludes)
            );
        }

        $user = User::with($includes)->find($id);

        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'User not found'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $user
        ]);
    }
}
