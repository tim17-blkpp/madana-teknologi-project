<?php

namespace App\Http\Controllers;

use App\Http\Resources\RolesResource;
use App\Models\Roles;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RolesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if (!Auth::check()) {
            return response()->json([
                'message' => 'Unauthorized',
            ], JsonResponse::HTTP_UNAUTHORIZED);
        }

        // Get the search keyword from the request
        $searchKeyword = $request->input('search');

        // Fetch the roles based on the search keyword
        $rolesQuery = Roles::where('name', 'like', '%' . $searchKeyword . '%');

        // Get the pagination size from the request, default to 10 if not provided
        $perPage = $request->input('perPage', 10);

        // Fetch the FAQs with pagination
        $roles = $rolesQuery->paginate($perPage);

        // Transform the fetched FAQs into a resource collection
        $result = RolesResource::collection($roles);

        // Return the JSON response with pagination data
        return $result->additional([
            'pagination' => [
                'total' => $roles->total(),
                'perPage' => $roles->perPage(),
                'currentPage' => $roles->currentPage(),
                'lastPage' => $roles->lastPage(),
            ]
        ]);
    }

    public function publicRoles()
    {
        $rolesQuery = Roles::where('show_on_landing_page', 1);

        // Apply pagination to the query before getting the results
        $roles = $rolesQuery->paginate(10);

        // Transform the fetched FAQs into a resource collection
        $result = RolesResource::collection($roles);

        return $result->additional([
            'pagination' => [
                'total' => $roles->total(),
                'perPage' => $roles->perPage(),
                'currentPage' => $roles->currentPage(),
                'lastPage' => $roles->lastPage(),
            ]
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (!Auth::check()) {
            return response()->json([
                'message' => 'Unauthorized',
            ], JsonResponse::HTTP_UNAUTHORIZED);
        }

        // Log::info($request->all());
        $request->validate([
            'name' => 'required',
            'icon_upload' => 'required',
        ]);

        if ($request->hasFile('icon_upload')) {
            $icon = $request->file('icon_upload');
            if (is_array($icon)) {
                $icon = $icon[0];
            }
            $iconName = time() . '.' . $icon->getClientOriginalName();
            $iconPath = '/storage/' . $icon->storeAs('roles', $iconName, 'public');
        }

        try {
            $role = Roles::create([
                'name' => $request->name,
                'icon' => $iconPath ?? null,
                'show_on_landing_page' => $request->show_on_landing_page ?? 0
            ]);

            return response()->json([
                'message' => 'Role created successfully'
            ], JsonResponse::HTTP_CREATED);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Roles $roles)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Roles $roles)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        if (!Auth::check()) {
            return response()->json([
                'message' => 'Unauthorized',
            ], JsonResponse::HTTP_UNAUTHORIZED);
        }

        $request->validate([
            'name' => 'required',
            'icon_upload' => 'sometimes',
        ]);

        $role = Roles::find($id);

        if ($request->hasFile('icon_upload')) {
            $icon = $request->file('icon_upload');
            if (is_array($icon)) {
                $icon = $icon[0];
            }
            $iconName = time() . '.' . $icon->getClientOriginalName();
            $iconPath = '/storage/' . $icon->storeAs('tools', $iconName, 'public');
        } else {
            $iconPath = $role->icon;
        }

        if (!$role) {
            return response()->json([
                'message' => 'Role not found'
            ], JsonResponse::HTTP_NOT_FOUND);
        }

        try {
            $role->update([
                'name' => $request->name,
                'icon' => $iconPath ?? null,
                'show_on_landing_page' => $request->show_on_landing_page ?? $role->show_on_landing_page
            ]);

            return response()->json([
                'data' => $role,
                'message' => 'Tool updated successfully'
            ], JsonResponse::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        if (!Auth::check()) {
            return response()->json([
                'message' => 'Unauthorized',
            ], JsonResponse::HTTP_UNAUTHORIZED);
        }

        //
        $role = Roles::find($id);
        if (!$role) {
            return response()->json([
                'message' => 'Role not found'
            ], JsonResponse::HTTP_NOT_FOUND);
        }

        try {
            $role->delete();
            return response()->json([
                'message' => 'Tool deleted successfully'
            ], JsonResponse::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
