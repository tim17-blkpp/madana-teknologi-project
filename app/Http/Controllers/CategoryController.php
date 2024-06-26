<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{

    public function index(Request $request)
    {
        // Get the search keyword from the request
        $searchKeyword = $request->input('search');

        // Fetch the categories based on the search keyword
        $categoryQuery = Category::where('name', 'like', '%' . $searchKeyword . '%');

        // Get the pagination size from the request, default to 10 if not provided
        $perPage = $request->input('perPage', 10);

        // Fetch the FAQs with pagination
        $categories = $categoryQuery->paginate($perPage);

        // Transform the fetched FAQs into a resource collection
        $result = CategoryResource::collection($categories);

        // Return the JSON response with pagination data
        return $result->additional([
            'pagination' => [
                'total' => $categories->total(),
                'perPage' => $categories->perPage(),
                'currentPage' => $categories->currentPage(),
                'lastPage' => $categories->lastPage(),
            ]
        ]);
    }

    public function create()
    {
    }

    public function store(Request $request)
    {
        if (!Auth::check()) {
            return response()->json([
                'message' => 'Unauthorized',
            ], JsonResponse::HTTP_UNAUTHORIZED);
        }

        $request->validate([
            'name' => 'required',
        ]);

        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Data gagal ditambahkan',
                'errors' => $validator->errors()
            ], JsonResponse::HTTP_BAD_REQUEST);
        }

        try {
            $categoryInput = Category::create(
                [
                    'name' => $request->name,
                ]
            );
            return response()->json([
                'message' => 'Data berhasil ditambahkan',
            ], JsonResponse::HTTP_CREATED);
        } catch (\Exception $error) {
            return response()->json([
                'message' => 'Data gagal ditambahkan',
                'error' => $error
            ], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function show(Category $category)
    {
    }

    public function edit(Category $category)
    {
    }

    public function update(Request $request, $id)
    {
        if (!Auth::check()) {
            return response()->json([
                'message' => 'Unauthorized',
            ], JsonResponse::HTTP_UNAUTHORIZED);
        }

        $request->validate([
            'name' => 'sometimes',
        ]);

        $validator = Validator::make($request->all(), [
            'name' => 'sometimes',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Data gagal diperbarui',
                'errors' => $validator->errors()
            ], JsonResponse::HTTP_BAD_REQUEST);
        }

        try {
            $category = Category::find($id);
            if (!$category) {
                return response()->json([
                    'message' => 'Data tidak ditemukan',
                ], JsonResponse::HTTP_NOT_FOUND);
            }

            $category->update($request->all());
            return response()->json([
                'message' => 'Data berhasil diperbarui',
            ], JsonResponse::HTTP_OK);
        } catch (\Exception $error) {
            return response()->json([
                'message' => 'Data gagal diperbarui',
                'error' => $error
            ], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function destroy($id)
    {
        if (!Auth::check()) {
            return response()->json([
                'message' => 'Unauthorized',
            ], JsonResponse::HTTP_UNAUTHORIZED);
        }

        try {
            $category = Category::find($id);
            if (!$category) {
                return response()->json([
                    'message' => 'Data tidak ditemukan',
                ], JsonResponse::HTTP_NOT_FOUND);
            }

            // check if the category has projects
            if ($category->projects()->exists()) {
                return response()->json([
                    'message' => 'Masih terdapat proyek yang terkait dengan kategori ini',
                ], JsonResponse::HTTP_BAD_REQUEST);
            }

            $category->delete();
            return response()->json([
                'message' => 'Data berhasil dihapus',
            ], JsonResponse::HTTP_OK);
        } catch (\Exception $error) {
            return response()->json([
                'message' => 'Data gagal dihapus',
                'error' => $error
            ], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
