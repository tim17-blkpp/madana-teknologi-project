<?php

namespace App\Http\Controllers;

use App\Models\Konfigurasi;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class KonfigurasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //

        $konfigurasi = Konfigurasi::all()->first();
        return response()->json($konfigurasi, JsonResponse::HTTP_OK);
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Konfigurasi $konfigurasi)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Konfigurasi $konfigurasi)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        if (!Auth::check()) {
            return response()->json([
                'message' => 'Unauthorized',
            ], JsonResponse::HTTP_UNAUTHORIZED);
        }

        //
        $request->validate([
            'nama' => 'sometimes',
            'logo' => 'sometimes',
            'deskripsi' => 'sometimes',
            'favicon' => 'sometimes',
            'email' => 'sometimes',
            'no_telp' => 'sometimes',
            'alamat' => 'sometimes',
            'facebook' => 'sometimes',
            'instagram' => 'sometimes',
            'twitter' => 'sometimes',
            'whatsapp' => 'sometimes',
            'google_maps' => 'sometimes',
        ]);

        if ($request->hasFile('logo')) {
            $logo = $request->file('logo');
            if (is_array($logo)) {
                $logo = $logo[0];
            }
            $logoName = 'logo.' . $logo->getClientOriginalExtension() ?? 'png';
            $logoPath = '/storage/' . $logo->storeAs('', $logoName, 'public');
        } else {
            $logoPath = $request->logo ?? null;
        }

        $konfigurasi = Konfigurasi::all()->first();

        try {
            $konfigurasi->update([
                'nama' => $request->nama ?? $konfigurasi->nama,
                'logo' => $logoPath ?? $konfigurasi->logo,
                'deskripsi' => $request->deskripsi ?? $konfigurasi->deskripsi,
                'favicon' => $request->favicon ?? $konfigurasi->favicon,
                'email' => $request->email ?? $konfigurasi->email,
                'no_telp' => $request->no_telp ?? $konfigurasi->no_telp,
                'alamat' => $request->alamat ?? $konfigurasi->alamat,
                'facebook' => $request->facebook ?? $konfigurasi->facebook,
                'instagram' => $request->instagram ?? $konfigurasi->instagram,
                'twitter' => $request->twitter ?? $konfigurasi->twitter,
                'whatsapp' => $request->whatsapp ?? $konfigurasi->whatsapp,
                'google_maps' => $request->google_maps ?? $konfigurasi->google_maps,
            ]);

            Log::info($request->all());
            return response()->json([
                'message' => 'Konfigurasi berhasil diubah'
            ], JsonResponse::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error menyimpan konfigurasi',
                'error' => $e->getMessage()
            ], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Konfigurasi $konfigurasi)
    {
        //
    }
}
