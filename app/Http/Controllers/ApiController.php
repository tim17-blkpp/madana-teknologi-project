<?php

namespace App\Http\Controllers;

use App\Http\Resources\FaqResource;
use App\Models\Category;
use App\Models\Faq;
use App\Models\Project;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    //

    public function index()
    {
        return response()->json(['message' => 'Welcome to the API']);
    }

    public function faqs()
    {
        $faqs = FaqResource::collection(Faq::all());
        return response()->json($faqs);
    }

    public function categories()
    {
        $categories = Category::all();
        return response()->json($categories);
    }

    public function projects()
    {
        $projects = Project::all();
        return response()->json($projects);
    }

    public function project($id)
    {
        $project = Project::find($id);
        return response()->json($project);
    }

    public function projectDetails($id)
    {
        $project = Project::find($id);
        $details = $project->details;
        return response()->json($details);
    }

    public function projectGalleries($id)
    {
        $project = Project::find($id);
        $galleries = $project->galleries;
        return response()->json($galleries);
    }

}
