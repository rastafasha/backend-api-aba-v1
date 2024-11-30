<?php

namespace App\Http\Controllers\Admin\Role;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

/**
 * @OA\Schema(
 *     schema="Role",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="name", type="string", example="RBT"),
 *     @OA\Property(property="guard_name", type="string", example="api"),
 *     @OA\Property(
 *         property="permissions",
 *         type="array",
 *         @OA\Items(
 *             type="object",
 *             @OA\Property(property="id", type="integer", example=1),
 *             @OA\Property(property="name", type="string", example="register_rol"),
 *             @OA\Property(property="guard_name", type="string", example="api"),
 *             @OA\Property(property="created_at", type="string", format="datetime", example="2024-11-19T17:18:13.000000Z"),
 *             @OA\Property(property="updated_at", type="string", format="datetime", example="2024-11-19T17:18:13.000000Z"),
 *             @OA\Property(
 *                 property="pivot",
 *                 type="object",
 *                 @OA\Property(property="role_id", type="integer", example=1),
 *                 @OA\Property(property="permission_id", type="integer", example=1)
 *             )
 *         )
 *     ),
 *     @OA\Property(
 *         property="permissions_names",
 *         type="array",
 *         @OA\Items(type="string", example="view_users")
 *     ),
 *     @OA\Property(property="created_at", type="string", format="datetime", example="2024-03-20 10:00:00")
 * )
 */

class RoleV2Controller extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/v2/roles",
     *     summary="Get paginated roles",
     *     description="Retrieves a paginated list of roles with optional search filter",
     *     tags={"Admin/Roles"},
     *     @OA\Parameter(
     *         name="search",
     *         in="query",
     *         description="Search roles by name",
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
     *             @OA\Property(property="data", type="object", ref="#/components/schemas/Role")
     *         )
     *     )
     * )
     */
    public function index(Request $request)
    {
        $roles = Role::query()
            ->when($request->search, function ($query, $search) {
                return $query->where('name', 'like', "%{$search}%");
            })
            ->orderBy('id', 'desc')
            ->paginate($request->input('per_page', 15));


        return response()->json([
            'status' => 'success',
            'data' => $roles
        ]);
    }

    /**
     * @OA\Post(
     *     path="/api/v2/roles",
     *     summary="Create a new role",
     *     description="Creates a new role with the specified permissions",
     *     tags={"Admin/Roles"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name", "permissions"},
     *             @OA\Property(property="name", type="string", example="RBT"),
     *             @OA\Property(
     *                 property="permissions",
     *                 type="array",
     *                 @OA\Items(type="string", example="view_users")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Role created successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Role created successfully"),
     *             @OA\Property(property="data", ref="#/components/schemas/Role")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     )
     * )
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:roles,name',
            'permissions' => 'required|array'
        ]);

        $role = Role::create([
            'guard_name' => 'api',
            'name' => $request->name,
        ]);

        $role->syncPermissions($request->permissions);

        return response()->json([
            'status' => 'success',
            'message' => 'Role created successfully',
            'data' => $role
        ], 201);
    }

    /**
     * @OA\Get(
     *     path="/api/v2/roles/{id}",
     *     summary="Get a single role",
     *     description="Retrieves a specific role by its ID",
     *     tags={"Admin/Roles"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the role",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="data", ref="#/components/schemas/Role")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Role not found"
     *     )
     * )
     */
    public function show($id)
    {
        $role = Role::find($id);

        if (!$role) {
            return response()->json([
                'status' => 'error',
                'message' => 'Role not found'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => [
                'id' => $role->id,
                'name' => $role->name,
                'permissions' => $role->permissions,
                'permissions_names' => $role->permissions->pluck('name'),
                'created_at' => $role->created_at->format('Y-m-d H:i:s')
            ]
        ]);
    }

    /**
     * @OA\Put(
     *     path="/api/v2/roles/{id}",
     *     summary="Update a role",
     *     description="Updates an existing role",
     *     tags={"Admin/Roles"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the role",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name", "permissions"},
     *             @OA\Property(property="name", type="string", example="RBT"),
     *             @OA\Property(
     *                 property="permissions",
     *                 type="array",
     *                 @OA\Items(type="string", example="view_users")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Role updated successfully"),
     *             @OA\Property(property="data", ref="#/components/schemas/Role")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Role not found"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        $role = Role::find($id);

        if (!$role) {
            return response()->json([
                'status' => 'error',
                'message' => 'Role not found'
            ], 404);
        }

        $request->validate([
            'name' => 'required|string|unique:roles,name,' . $id,
            'permissions' => 'required|array'
        ]);

        $role->update(['name' => $request->name]);
        $role->syncPermissions($request->permissions);

        return response()->json([
            'status' => 'success',
            'message' => 'Role updated successfully',
            'data' => $role
        ]);
    }

    /**
     * @OA\Delete(
     *     path="/api/v2/roles/{id}",
     *     summary="Delete a role",
     *     description="Deletes an existing role if it has no associated users",
     *     tags={"Admin/Roles"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the role",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Role deleted successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Role not found"
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Role cannot be deleted due to associated users"
     *     )
     * )
     */
    public function destroy($id)
    {
        $role = Role::find($id);

        if (!$role) {
            return response()->json([
                'status' => 'error',
                'message' => 'Role not found'
            ], 404);
        }

        if ($role->users->count() > 0) {
            return response()->json([
                'status' => 'error',
                'message' => 'Role cannot be deleted because it has associated users'
            ], 403);
        }

        $role->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Role deleted successfully'
        ]);
    }
}
