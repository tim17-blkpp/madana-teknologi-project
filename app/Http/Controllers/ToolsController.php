<?php

namespace App\Http\Controllers;

use App\Http\Resources\ToolsResource;
use App\Models\Tools;
use Illuminate\Database\Eloquent\Casts\Json;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ToolsController extends Controller
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

        // Fetch the tools based on the search keyword
        $toolsQuery = Tools::where('name', 'like', '%' . $searchKeyword . '%');

        // Get the pagination size from the request, default to 10 if not provided
        $perPage = $request->input('perPage', 10);

        // Fetch the FAQs with pagination
        $tools = $toolsQuery->paginate($perPage);

        // Transform the fetched FAQs into a resource collection
        $result = ToolsResource::collection($tools);

        // Return the JSON response with pagination data
        return $result->additional([
            'pagination' => [
                'total' => $tools->total(),
                'perPage' => $tools->perPage(),
                'currentPage' => $tools->currentPage(),
                'lastPage' => $tools->lastPage(),
            ]
        ]);
    }

    public function publicTools()
    {
        $toolsQuery = Tools::where('show_on_landing_page', 1);

        // Apply pagination to the query before getting the results
        $tools = $toolsQuery->paginate(10);

        // Transform the fetched FAQs into a resource collection
        $result = ToolsResource::collection($tools);

        return $result->additional([
            'pagination' => [
                'total' => $tools->total(),
                'perPage' => $tools->perPage(),
                'currentPage' => $tools->currentPage(),
                'lastPage' => $tools->lastPage(),
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

        //
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
            $iconPath = '/storage/' . $icon->storeAs('tools', $iconName, 'public');
        }

        try {
            $tool = Tools::create([
                'name' => $request->name,
                'icon' => $iconPath ?? null,
                'show_on_landing_page' => $request->show_on_landing_page ?? 0
            ]);

            // Log::info("message: " . "Tool created successfully");

            return response()->json([
                // 'data' => $tool,
                'message' => 'Tool created successfully'
            ], JsonResponse::HTTP_CREATED);
        } catch (\Exception $e) {
            // Log::error('Error creating tool: ' . $e->getMessage());
            // Log::error('Error creating tool: ' . $e->getTraceAsString());
            return response()->json([
                'message' => $e->getMessage()
            ], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Tools $tools)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tools $tools)
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

        //
        Log::info($request->all());

        $request->validate([
            'name' => 'required',
            'icon_upload' => 'sometimes',
        ]);

        $tools = Tools::find($id);

        if ($request->hasFile('icon_upload')) {
            $icon = $request->file('icon_upload');
            if (is_array($icon)) {
                $icon = $icon[0];
            }
            $iconName = time() . '.' . $icon->getClientOriginalName();
            $iconPath = '/storage/' . $icon->storeAs('tools', $iconName, 'public');
        } else {
            $iconPath = $tools->icon;
        }

        if (!$tools) {
            return response()->json([
                'message' => 'Tool not found'
            ], JsonResponse::HTTP_NOT_FOUND);
        }

        try {
            $tools->update([
                'name' => $request->name,
                'icon' => $iconPath ?? null,
                'show_on_landing_page' => $request->show_on_landing_page ?? $tools->show_on_landing_page
            ]);

            return response()->json([
                'data' => $tools,
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
        $tools = Tools::find($id);
        if (!$tools) {
            return response()->json([
                'message' => 'Tool not found'
            ], JsonResponse::HTTP_NOT_FOUND);
        }

        try {
            $tools->delete();
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
