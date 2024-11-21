<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\InsuranceRequest;
use App\Models\Insurance\Insurance;
use Illuminate\Http\Request;

/**
 * @OA\Schema(
 *     schema="PaginatedInsuranceResponse",
 *     @OA\Property(property="current_page", type="integer", example=1),
 *     @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/Insurance")),
 *     @OA\Property(property="first_page_url", type="string"),
 *     @OA\Property(property="from", type="integer"),
 *     @OA\Property(property="last_page", type="integer"),
 *     @OA\Property(property="last_page_url", type="string"),
 *     @OA\Property(property="next_page_url", type="string", nullable=true),
 *     @OA\Property(property="path", type="string"),
 *     @OA\Property(property="per_page", type="integer", example=15),
 *     @OA\Property(property="prev_page_url", type="string", nullable=true),
 *     @OA\Property(property="to", type="integer"),
 *     @OA\Property(property="total", type="integer")
 * )
 */
class InsuranceV2Controller extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/v2/insurance",
     *     summary="Get paginated insurance list",
     *     description="Retrieves a paginated list of insurance with optional filters",
     *     tags={"Admin/Insurance"},
     *     @OA\Parameter(
     *         name="name",
     *         in="query",
     *         description="Filter by name",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(name="city", in="query", description="Filter by city", required=false, @OA\Schema(type="string")),
     *     @OA\Parameter(name="state", in="query", description="Filter by state", required=false, @OA\Schema(type="string")),
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
     *                 ref="#/components/schemas/PaginatedInsuranceResponse"
     *             )
     *         )
     *     )
     * )
     */
    public function index(Request $request)
    {
        $query = Insurance::query();

        // Filter by name if provided
        if ($request->has('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        // Get paginated results
        $insurances = $query->orderBy('created_at', 'desc')
            ->filterByCity($request->city)
            ->filterByState($request->state)
            ->paginate($request->input('per_page', 15));

        return response()->json([
            'status' => 'success',
            'data' => $insurances,
        ]);
    }

    /**
     * @OA\Post(
     *     path="/api/v2/insurance",
     *     summary="Create a new insurance",
     *     description="Creates a new insurance record",
     *     tags={"Admin/Insurance"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name"},
     *             @OA\Property(property="name", type="string"),
     *             @OA\Property(property="services", type="object"),
     *             @OA\Property(property="notes", type="object"),
     *             @OA\Property(property="payer_id", type="string"),
     *             @OA\Property(property="street", type="string"),
     *             @OA\Property(property="street2", type="string"),
     *             @OA\Property(property="city", type="string"),
     *             @OA\Property(property="state", type="string"),
     *             @OA\Property(property="zip", type="string")
     *             @OA\Property(property="is_self_subscriber", type="boolean", default=false)
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Insurance created successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Insurance created successfully"),
     *             @OA\Property(property="data", ref="#/components/schemas/Insurance")
     *         )
     *     )
     * )
     */
    public function store(InsuranceRequest $request)
    {
        $insurance = Insurance::create($request->validated());

        return response()->json([
            'status' => 'success',
            'message' => 'Insurance created successfully',
            'data' => $insurance
        ], 201);
    }

    /**
     * @OA\Get(
     *     path="/api/v2/insurance/{id}",
     *     summary="Get a single insurance",
     *     description="Retrieves a specific insurance by its ID",
     *     tags={"Admin/Insurance"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the insurance",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="data", ref="#/components/schemas/Insurance")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Insurance not found"
     *     )
     * )
     */
    public function show($id)
    {
        $insurance = Insurance::find($id);

        if (!$insurance) {
            return response()->json([
                'status' => 'error',
                'message' => 'Insurance not found'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $insurance
        ]);
    }

    /**
     * @OA\Put(
     *     path="/api/v2/insurance/{id}",
     *     summary="Update an insurance",
     *     description="Updates an existing insurance record",
     *     tags={"Admin/Insurance"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the insurance",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="name", type="string"),
     *             @OA\Property(property="services", type="object"),
     *             @OA\Property(property="notes", type="object"),
     *             @OA\Property(property="payer_id", type="string"),
     *             @OA\Property(property="street", type="string"),
     *             @OA\Property(property="street2", type="string"),
     *             @OA\Property(property="city", type="string"),
     *             @OA\Property(property="state", type="string"),
     *             @OA\Property(property="zip", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Insurance updated successfully"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Insurance not found"
     *     )
     * )
     */
    public function update(InsuranceRequest $request, $id)
    {
        $insurance = Insurance::find($id);

        if (!$insurance) {
            return response()->json([
                'status' => 'error',
                'message' => 'Insurance not found'
            ], 404);
        }

        $insurance->update($request->validated());

        return response()->json([
            'status' => 'success',
            'message' => 'Insurance updated successfully',
            'data' => $insurance
        ]);
    }

    /**
     * @OA\Delete(
     *     path="/api/v2/insurance/{id}",
     *     summary="Delete an insurance",
     *     description="Deletes an existing insurance record",
     *     tags={"Admin/Insurance"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the insurance",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Insurance deleted successfully"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Insurance not found"
     *     )
     * )
     */
    public function destroy($id)
    {
        $insurance = Insurance::find($id);

        if (!$insurance) {
            return response()->json([
                'status' => 'error',
                'message' => 'Insurance not found'
            ], 404);
        }

        $insurance->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Insurance deleted successfully'
        ]);
    }
}
