<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Konfigurasi;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(1)->create();

        \App\Models\User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@madana.com',
            'password' => bcrypt('qweqweqwe'),
        ]);

        // Konfigurasi::factory(1)->create();
        Konfigurasi::factory()->create([
            'nama' => 'Madana',
            'logo' => 'logo.png',
            'deskripsi' => 'Madana adalah sebuah perusahaan yang bergerak di bidang IT',
            'favicon' => 'favicon.png',
            'email' => 'contact@madana.com',
            'no_telp' => '08123456789',
            'alamat' => 'Jl. Madana No. 1',
            'facebook' => 'https://facebook.com/madana',
            'instagram' => 'https://instagram.com/madana',
            'twitter' => 'https://twitter.com/madana',
            'whatsapp' => 'https://wa.me/628123456789',
            'google_maps' => 'https://goo.gl/maps/madana',
        ]);
    }
}
