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

        Log::info($request->all());

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
            'linkedin' => 'sometimes',
            'twitter' => 'sometimes',
            'whatsapp' => 'sometimes',
            'google_maps' => 'sometimes',
            'portfolio' => 'sometimes',
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

        if ($request->hasFile('favicon')) {
            $favicon = $request->file('favicon');
            if (is_array($favicon)) {
                $favicon = $favicon[0];
            }
            $faviconName = 'favicon.' . $favicon->getClientOriginalExtension() ?? 'ico';
            $faviconPath = '/storage/' . $favicon->storeAs('', $faviconName, 'public');
        } else {
            $faviconPath = $request->favicon ?? null;
        }

        if ($request->hasFile('portfolio')) {
            $portfolio = $request->file('portfolio');
            if (is_array($portfolio)) {
                $portfolio = $portfolio[0];
            }
            $portfolioName = 'portfolio.' . $portfolio->getClientOriginalExtension();
            $portfolioPath = '/storage/' . $portfolio->storeAs('', $portfolioName, 'public');
        } else {
            $portfolioPath = $request->portfolio ?? null;
        }

        $konfigurasi = Konfigurasi::all()->first();

        try {
            $konfigurasi->update([
                'nama' => $request->nama ?? $konfigurasi->nama,
                'logo' => $logoPath ?? $konfigurasi->logo,
                'deskripsi' => $request->deskripsi ?? $konfigurasi->deskripsi,
                'favicon' => $faviconPath ?? $konfigurasi->favicon,
                'email' => $request->email ?? $konfigurasi->email,
                'no_telp' => $request->no_telp ?? $konfigurasi->no_telp,
                'alamat' => $request->alamat ?? $konfigurasi->alamat,
                'facebook' => $request->facebook ?? $konfigurasi->facebook,
                'instagram' => $request->instagram ?? $konfigurasi->instagram,
                'linkedin' => $request->linkedin ?? $konfigurasi->linkedin,
                'twitter' => $request->twitter ?? $konfigurasi->twitter,
                'whatsapp' => $request->whatsapp ?? $konfigurasi->whatsapp,
                'google_maps' => $request->google_maps ?? $konfigurasi->google_maps,
                'portfolio' => $portfolioPath ?? $konfigurasi->portfolio,
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
