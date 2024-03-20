<?php

namespace App\Http\Controllers;

use App\Http\Resources\FaqResource;
use App\Models\Faq;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Get the search keyword from the request
        $searchKeyword = $request->input('search');

        // Fetch the FAQs based on the search keyword
        $faqsQuery = Faq::where('question', 'like', '%' . $searchKeyword . '%')
            ->orWhere('answer', 'like', '%' . $searchKeyword . '%');

        // Get the pagination size from the request, default to 10 if not provided
        $perPage = $request->input('perPage', 10);

        // Fetch the FAQs with pagination
        $faqs = $faqsQuery->paginate($perPage);

        // Transform the fetched FAQs into a resource collection
        $faqsResource = FaqResource::collection($faqs);

        // Return the JSON response with pagination data
        return $faqsResource->additional([
            'pagination' => [
                'total' => $faqs->total(),
                'perPage' => $faqs->perPage(),
                'currentPage' => $faqs->currentPage(),
                'lastPage' => $faqs->lastPage(),
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
        $request->validate([
            'question' => 'required',
            'answer' => 'required'
        ]);
        try {
            $faqInput = Faq::create(
                [
                    'question' => $request->question,
                    'answer' => $request->answer
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

    /**
     * Display the specified resource.
     */
    public function show(Faq $faq)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Faq $faq)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'question' => 'required',
            'answer' => 'required'
        ]);
        try {
            $faq = Faq::find($id);
            if (!$faq) {
                return response()->json([
                    'message' => 'Data tidak ditemukan',
                ], JsonResponse::HTTP_NOT_FOUND);
            }

            $faq->update($request->all());
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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $faq = Faq::find($id);
            if (!$faq) {
                return response()->json([
                    'message' => 'Data tidak ditemukan',
                ], JsonResponse::HTTP_NOT_FOUND);
            }

            $faq->delete();
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
