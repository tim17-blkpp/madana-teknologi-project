<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\SendContactEmail;
use App\Models\Konfigurasi;
use Mail;

class ContactFormController extends Controller
{
    public function send(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        $recipient = Konfigurasi::all()->first()->email;

        // dd($recipient);

        Mail::to($recipient)->send(new SendContactEmail($validatedData));

        return response()->json(['message' => 'Email sent successfully!'], 200);
    }
}
