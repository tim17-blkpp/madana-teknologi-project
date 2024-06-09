<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProjectResource;
use App\Http\Resources\PublicProjectResource;
use App\Models\Gallery;
use App\Models\Project;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log; // Import the Log facade

class ProjectController extends Controller
{
    public function index(Request $request)
    {
        if (!Auth::check()) {
            return response()->json([
                'message' => 'Unauthorized',
            ], JsonResponse::HTTP_UNAUTHORIZED);
        }

        // Get the search keyword from the request
        $searchKeyword = $request->input('search');

        // Fetch the categories based on the search keyword
        $projectQuery = Project::where('name', 'like', '%' . $searchKeyword . '%');

        // Get the pagination size from the request, default to 10 if not provided
        $perPage = $request->input('perPage', 10);

        // Fetch the FAQs with pagination
        $projects = $projectQuery->paginate($perPage);

        // Transform the fetched FAQs into a resource collection
        $result = ProjectResource::collection($projects);

        // Return the JSON response with pagination data
        return $result->additional([
            'pagination' => [
                'total' => $projects->total(),
                'perPage' => $projects->perPage(),
                'currentPage' => $projects->currentPage(),
                'lastPage' => $projects->lastPage(),
            ]
        ]);
    }

    public function publicProjects(Request $request)
    {
        $category = $request->input('category');

        $projectsQuery = Project::where('show_on_landing_page', 1)
            ->when($category, function ($query, $category) {
                return $query->where('category_id', $category);
            });

        // Apply pagination to the query before getting the results
        $projects = $projectsQuery->paginate(10);

        // Create a resource collection with the paginated result
        $result = PublicProjectResource::collection($projects);

        return $result->additional([
            'pagination' => [
                'total' => $projects->total(),
                'perPage' => $projects->perPage(),
                'currentPage' => $projects->currentPage(),
                'lastPage' => $projects->lastPage(),
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


        // Log::info($request->all());
        $request->validate([
            'name' => 'required',
            'category_id' => 'required',
            'client_id' => 'required',
            // 'thumbnail' => 'sometimes|nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);
        // Log::info($request->hasFile('thumbnail'));

        if ($request->hasFile('thumbnail')) {
            // Log::info("message: " . "thumbnail exists");
            $thumbnail = $request->file('thumbnail');

            // Check if the file is an array or a single file
            if (is_array($thumbnail)) {
                $thumbnail = $thumbnail[0]; // Get the first file in the array
            }

            $thumbnailName = time() . '_' . $thumbnail->getClientOriginalName();
            $thumbnailPath = '/storage/' . $thumbnail->storeAs('uploads', $thumbnailName, 'public');
        } else {
            // $thumbnailPath = 'uploads/default-thumbnail.jpg';
            Log::info("message: " . "thumbnail doesn't exist");
            $thumbnailPath = null;
        }


        try {

            // Create the project
            $project = Project::create([
                'name' => $request->name,
                'category_id' => $request->category_id,
                'client_id' => $request->client_id,
                'description' => $request->description,
                'url' => $request->url,
                'thumbnail_path' => $thumbnailPath,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'status' => $request->status,
                'show_on_landing_page' => $request->show_on_landing_page,
            ]);

            // Log::info("project: " . $project);


            return response()->json([
                'message' => 'Data berhasil ditambahkan',
            ], JsonResponse::HTTP_CREATED);
        } catch (\Exception $error) {
            Log::error('Error creating project: ' . $error->getMessage());
            Log::error('Stack trace: ' . $error->getTraceAsString());
            return response()->json([
                'message' => 'Data gagal ditambahkan',
                'error' => $error
            ], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function show(Project $project)
    {
    }

    public function edit(Project $project)
    {
    }

    public function update(Request $request, $id)
    {
        // Log::info($id);
        // Log::info(file_get_contents('php://input'));
        // Log::info($request->headers->all());
        // Log::info($request->all()); // This should log all request data
        // Log::info($request->getContent());

        // $data = json_decode($request->getContent());
        // $data = json_decode($data);
        // Log::info($data);
        if (!Auth::check()) {
            return response()->json([
                'message' => 'Unauthorized',
            ], JsonResponse::HTTP_UNAUTHORIZED);
        }


        $request->validate([
            'name' => 'sometimes',
            'category_id' => 'sometimes',
            'client_id' => 'sometimes',
            'description' => 'sometimes',
            'url' => 'sometimes',
            // 'thumbnail' => 'sometimes|nullable|image|mimes:jpeg,png,jpg|max:2048',
            'start_date' => 'sometimes',
            'end_date' => 'sometimes',
            'status' => 'sometimes',
            'show_on_landing_page' => 'sometimes',
        ]);

        $project = Project::find($id);
        // Log::info($project);
        if (!$project) {
            // dd($project)
            return response()->json([
                'message' => 'Data tidak ditemukan',
            ], JsonResponse::HTTP_NOT_FOUND);
        }

        if ($request->hasFile('thumbnail')) {
            // Log::info("message: " . "thumbnail exists");
            $thumbnail = $request->file('thumbnail');

            // Check if the file is an array or a single file
            if (is_array($thumbnail)) {
                $thumbnail = $thumbnail[0]; // Get the first file in the array
            }

            $thumbnailName = time() . '_' . $thumbnail->getClientOriginalName();
            $thumbnailPath = '/storage/' . $thumbnail->storeAs('uploads', $thumbnailName, 'public');
        } else {
            // $thumbnailPath = 'uploads/default-thumbnail.jpg';
            Log::info("message: " . "thumbnail doesn't exist");
            $thumbnailPath = $project->thumbnail_path;
        }

        try {
            $project->update([
                'name' => $request->name,
                'category_id' => $request->category_id,
                'client_id' => $request->client_id,
                'description' => $request->description,
                'url' => $request->url,
                'thumbnail_path' => $thumbnailPath,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'status' => $request->status,
                'show_on_landing_page' => $request->show_on_landing_page ? $request->show_on_landing_page : 0,
            ]);
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
            $project = Project::find($id);
            if (!$project) {
                return response()->json([
                    'message' => 'Data tidak ditemukan',
                ], JsonResponse::HTTP_NOT_FOUND);
            }

            $project->delete();
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
