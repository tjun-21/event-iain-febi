<?php

namespace Database\Factories;

use App\Models\Peserta;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Peserta>
 */
class PesertaFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Peserta::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $jenisPeserta = $this->faker->randomElement(['kampus', 'umum']);
        $jenisKelamin = $this->faker->randomElement(['L', 'P']);

        // Generate NIK (16 digit)
        $nik = '32' . $this->faker->numerify('##############');

        // Generate NIM only for kampus peserta (students)
        $nim = $jenisPeserta === 'kampus' ? '2021' . $this->faker->numerify('######') : null;

        // Different email domains based on jenis_peserta
        $emailDomain = $jenisPeserta === 'kampus'
            ? $this->faker->randomElement(['@student.syekhnurjati.ac.id', '@syekhnurjati.ac.id'])
            : '@gmail.com';

        // Different asal based on jenis_peserta
        $asal = $jenisPeserta === 'kampus'
            ? $this->faker->randomElement([
                'IAIN Syekh Nurjati Cirebon',
                'UIN Sunan Gunung Djati Bandung',
                'UIN Jakarta',
                'UGM Yogyakarta'
            ])
            : 'Masyarakat Umum';

        return [
            'nama' => $this->faker->name(),
            'nik' => $nik,
            'jenis_peserta' => $jenisPeserta,
            'nim' => $nim,
            'asal' => $asal,
            'email' => $this->faker->unique()->userName() . $emailDomain,
            'password' => Hash::make('password123'), // Default password for factory
            'no_telepon' => '08' . $this->faker->numerify('##########'),
            'jenis_kelamin' => $jenisKelamin,
            'alamat' => $this->faker->address(),
            'roles_id' => $this->faker->randomElement([1, 2]),
            'status_pendaftaran' => $this->faker->randomElement(['pending', 'approved', 'rejected']),
            'tanggal_daftar' => $this->faker->dateTimeBetween('-3 months', 'now'),
        ];
    }

    /**
     * Indicate that the peserta is from kampus (student/dosen).
     */
    public function kampus(): static
    {
        return $this->state(fn(array $attributes) => [
            'jenis_peserta' => 'kampus',
            'nim' => '2021' . $this->faker->numerify('######'),
            'asal' => 'IAIN Syekh Nurjati Cirebon',
            'email' => $this->faker->unique()->userName() . '@student.syekhnurjati.ac.id',
            'roles_id' => 1,
        ]);
    }

    /**
     * Indicate that the peserta is a dosen from kampus.
     */
    public function dosen(): static
    {
        return $this->state(fn(array $attributes) => [
            'jenis_peserta' => 'kampus',
            'nim' => null,
            'asal' => 'IAIN Syekh Nurjati Cirebon',
            'email' => $this->faker->unique()->userName() . '@syekhnurjati.ac.id',
            'roles_id' => 2,
            'status_pendaftaran' => 'approved',
        ]);
    }

    /**
     * Indicate that the peserta is umum.
     */
    public function umum(): static
    {
        return $this->state(fn(array $attributes) => [
            'jenis_peserta' => 'umum',
            'nim' => null,
            'asal' => 'Masyarakat Umum',
            'email' => $this->faker->unique()->userName() . '@gmail.com',
            'roles_id' => 1,
        ]);
    }

    /**
     * Indicate that the peserta is approved.
     */
    public function approved(): static
    {
        return $this->state(fn(array $attributes) => [
            'status_pendaftaran' => 'approved',
        ]);
    }
}
