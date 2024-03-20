<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Konfigurasi extends Model
{
    use HasFactory;

    protected $table = 'konfigurasi';
    protected $fillable = ['nama', 'logo', 'deskripsi', 'favicon', 'email', 'no_telp', 'alamat', 'facebook', 'instagram', 'twitter', 'whatsapp', 'google_maps'];

}
