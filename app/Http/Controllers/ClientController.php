<?php

namespace App\Http\Controllers;

use App\Http\Resources\ClientResource;
use App\Http\Resources\PublicClientResource;
use App\Models\Client;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ClientController extends Controller
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

        // Fetch the clients based on the search keyword
        $clientQuery = Client::where('name', 'like', '%' . $searchKeyword . '%');

        // Get the pagination size from the request, default to 10 if not provided
        $perPage = $request->input('perPage', 10);

        // Fetch the FAQs with pagination
        $clients = $clientQuery->paginate($perPage);

        // Transform the fetched FAQs into a resource collection
        $result = ClientResource::collection($clients);

        // Return the JSON response with pagination data
        return $result->additional([
            'pagination' => [
                'total' => $clients->total(),
                'perPage' => $clients->perPage(),
                'currentPage' => $clients->currentPage(),
                'lastPage' => $clients->lastPage(),
            ]
        ]);
    }

    public function publicClients()
    {
        $clientsQuery = Client::where('show_on_landing_page', 1);

        // Apply pagination to the query before getting the results
        $clients = $clientsQuery->paginate(10);

        // Transform the fetched FAQs into a resource collection
        $result = PublicClientResource::collection($clients);

        // Return the JSON response with pagination data
        return $result->additional([
            'pagination' => [
                'total' => $clients->total(),
                'perPage' => $clients->perPage(),
                'currentPage' => $clients->currentPage(),
                'lastPage' => $clients->lastPage(),
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

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'address' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Data gagal ditambahkan',
                'errors' => $validator->errors()
            ], JsonResponse::HTTP_BAD_REQUEST);
        }

        if ($request->hasFile('logo_upload')) {
            $logo = $request->file('logo_upload');
            if (is_array($logo)) {
                $logo = $logo[0];
            }
            $logoName = time() . '_' . $logo->getClientOriginalName();
            $logoPath = '/storage/' . $logo->storeAs('uploads', $logoName, 'public');
        } else {
            // $logoPath = 'uploads/default-logo.jpg';
            $logoPath = null;
        }

        try {
            $clientInput = Client::create(
                [
                    'name' => $request->name,
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'address' => $request->address,
                    'show_on_landing_page' => $request->show_on_landing_page ?? 0,
                    'logo' => $logoPath ?? null
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
    public function show(Client $client)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Client $client)
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
        $validator = Validator::make($request->all(), [
            'name' => 'sometimes',
            'email' => 'sometimes',
            'phone' => 'sometimes',
            'address' => 'sometimes',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Data gagal diperbarui',
                'errors' => $validator->errors()
            ], JsonResponse::HTTP_BAD_REQUEST);
        }

        if ($request->hasFile('logo_upload')) {
            $logo = $request->file('logo_upload');
            if (is_array($logo)) {
                $logo = $logo[0];
            }
            $logoName = time() . '_' . $logo->getClientOriginalName();
            $logoPath = '/storage/' . $logo->storeAs('uploads', $logoName, 'public');
        } else {
            // $logoPath = 'uploads/default-logo.jpg';
            // $logoPath = null;
        }

        try {
            $client = Client::find($id);
            if (!$client) {
                return response()->json([
                    'message' => 'Data tidak ditemukan',
                ], JsonResponse::HTTP_NOT_FOUND);
            }

            $client->update([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'address' => $request->address,
                'show_on_landing_page' => $request->show_on_landing_page ?? $client->show_on_landing_page,
                'logo' => $logoPath ?? $client->logo
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


        try {
            $client = Client::find($id);
            if (!$client) {
                return response()->json([
                    'message' => 'Data tidak ditemukan',
                ], JsonResponse::HTTP_NOT_FOUND);
            }

            // check if the client has projects
            if ($client->projects()->exists()) {
                return response()->json([
                    'message' => 'Masih terdapat proyek yang terkait dengan kategori ini',
                ], JsonResponse::HTTP_BAD_REQUEST);
            }

            $client->delete();
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
