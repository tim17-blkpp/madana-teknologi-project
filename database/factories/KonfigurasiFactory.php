<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Konfigurasi>
 */
class KonfigurasiFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //
            'nama' => $this->faker->name(),
            // 'logo' => 'logo.png',
            'deskripsi' => $this->faker->sentence(),
            // 'favicon' => 'favicon.png',
            'email' => $this->faker->unique()->safeEmail(),
            'no_telp' => $this->faker->phoneNumber(),
            'alamat' => $this->faker->address(),
            // 'facebook' => 'https://facebook.com/madana',
            // 'instagram' => 'https://instagram.com/madana',
            // 'twitter' => 'https://twitter.com/madana',
            // 'whatsapp' => 'https://wa.me/628123456789',
            // 'google_maps' => 'https://goo.gl/maps/madana',
        ];
    }
}
