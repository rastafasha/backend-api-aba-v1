<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Location\LocationResource;
use App\Models\Location;
use Illuminate\Http\Request;

/**
 * @OA\Schema(
 *     schema="PaginatedLocationResponse",
 *     @OA\Property(property="current_page", type="integer", example=1),
 *     @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/Location")),
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
class LocationV2Controller extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/v2/locations",
     *     summary="Get paginated locations list",
     *     description="Retrieves a paginated list of locations with optional filters",
     *     tags={"Admin/Locations"},
     *     @OA\Parameter(
     *         name="title",
     *         in="query",
     *         description="Filter by location title",
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
     *                 ref="#/components/schemas/PaginatedLocationResponse"
     *             )
     *         )
     *     )
     * )
     */
    public function index(Request $request)
    {
        $query = Location::query();

        if ($request->has('title')) {
            $query->where('title', 'like', '%' . $request->title . '%');
        }

        if ($request->has('city')) {
            $query->where('city', $request->city);
        }

        if ($request->has('state')) {
            $query->where('state', $request->state);
        }

        $perPage = $request->input('per_page', 15);
        $locations = $query->orderBy('created_at', 'desc')
            ->paginate($perPage);

        return response()->json([
            'status' => 'success',
            'data' => LocationResource::collection($locations)
        ]);
    }

    /**
     * @OA\Post(
     *     path="/api/v2/locations",
     *     summary="Create a new location",
     *     description="Creates a new location record",
     *     tags={"Admin/Locations"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"title"},
     *             @OA\Property(property="title", type="string"),
     *             @OA\Property(property="address", type="string"),
     *             @OA\Property(property="phone1", type="string"),
     *             @OA\Property(property="phone2", type="string"),
     *             @OA\Property(property="city", type="string"),
     *             @OA\Property(property="state", type="string"),
     *             @OA\Property(property="zip", type="string"),
     *             @OA\Property(property="email", type="string"),
     *             @OA\Property(property="telfax", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Location created successfully"
     *     )
     * )
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:150',
            'address' => 'nullable|string',
            'phone1' => 'nullable|string|max:50',
            'phone2' => 'nullable|string|max:50',
            'city' => 'nullable|string|max:150',
            'state' => 'nullable|string|max:150',
            'zip' => 'nullable|string|max:150',
            'email' => 'nullable|email|max:150',
            'telfax' => 'nullable|string',
            'avatar' => 'nullable|string'
        ]);

        $location = Location::create($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Location created successfully',
            'data' => LocationResource::make($location)
        ], 201);
    }

    /**
     * @OA\Get(
     *     path="/api/v2/locations/{id}",
     *     summary="Get a single location",
     *     description="Retrieves a specific location by its ID",
     *     tags={"Admin/Locations"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the location",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Location not found"
     *     )
     * )
     */
    public function show($id)
    {
        $location = Location::find($id);

        if (!$location) {
            return response()->json([
                'status' => 'error',
                'message' => 'Location not found'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => LocationResource::make($location)
        ]);
    }

    /**
     * @OA\Put(
     *     path="/api/v2/locations/{id}",
     *     summary="Update a location",
     *     description="Updates an existing location record",
     *     tags={"Admin/Locations"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the location",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="title", type="string"),
     *             @OA\Property(property="address", type="string"),
     *             @OA\Property(property="phone1", type="string"),
     *             @OA\Property(property="phone2", type="string"),
     *             @OA\Property(property="city", type="string"),
     *             @OA\Property(property="state", type="string"),
     *             @OA\Property(property="zip", type="string"),
     *             @OA\Property(property="email", type="string"),
     *             @OA\Property(property="telfax", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Location updated successfully"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Location not found"
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        $location = Location::find($id);

        if (!$location) {
            return response()->json([
                'status' => 'error',
                'message' => 'Location not found'
            ], 404);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:150',
            'address' => 'nullable|string',
            'phone1' => 'nullable|string|max:50',
            'phone2' => 'nullable|string|max:50',
            'city' => 'nullable|string|max:150',
            'state' => 'nullable|string|max:150',
            'zip' => 'nullable|string|max:150',
            'email' => 'nullable|email|max:150',
            'telfax' => 'nullable|string',
            'avatar' => 'nullable|string'
        ]);

        $location->update($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Location updated successfully',
            'data' => LocationResource::make($location->fresh())
        ]);
    }

    /**
     * @OA\Delete(
     *     path="/api/v2/locations/{id}",
     *     summary="Delete a location",
     *     description="Deletes an existing location record",
     *     tags={"Admin/Locations"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the location",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Location deleted successfully"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Location not found"
     *     )
     * )
     */
    public function destroy($id)
    {
        $location = Location::find($id);

        if (!$location) {
            return response()->json([
                'status' => 'error',
                'message' => 'Location not found'
            ], 404);
        }

        $location->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Location deleted successfully'
        ]);
    }
}