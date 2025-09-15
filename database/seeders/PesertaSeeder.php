<?php

namespace Database\Seeders;

use App\Models\Peserta;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class PesertaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Data sample peserta untuk testing
        $pesertaData = [
            [
                'nama' => 'Ahmad Rizki Pratama',
                'nik' => '3201234567890001',
                'jenis_peserta' => 'kampus',
                'nim' => '20210101001',
                'asal' => 'IAIN Syekh Nurjati Cirebon',
                'email' => 'ahmad.rizki@student.syekhnurjati.ac.id',
                'password' => Hash::make('password123'), // Password: password123
                'no_telepon' => '081234567001',
                'jenis_kelamin' => 'L',
                'alamat' => 'Jl. Perjuangan No. 1, Cirebon',
                'roles_id' => 1,
                'status_pendaftaran' => 'approved',
                'tanggal_daftar' => Carbon::now()->subDays(30),
            ],
            [
                'nama' => 'Siti Nurhalimah',
                'nik' => '3201234567890002',
                'jenis_peserta' => 'kampus',
                'nim' => '20210101002',
                'asal' => 'IAIN Syekh Nurjati Cirebon',
                'email' => 'siti.nurhalimah@student.syekhnurjati.ac.id',
                'password' => Hash::make('password123'), // Password: password123
                'no_telepon' => '081234567002',
                'jenis_kelamin' => 'P',
                'alamat' => 'Jl. Kesambi No. 15, Cirebon',
                'roles_id' => 1,
                'status_pendaftaran' => 'approved',
                'tanggal_daftar' => Carbon::now()->subDays(25),
            ],
            [
                'nama' => 'Muhammad Fauzan',
                'nik' => '3201234567890003',
                'jenis_peserta' => 'kampus',
                'nim' => '20210101003',
                'asal' => 'IAIN Syekh Nurjati Cirebon',
                'email' => 'muhammad.fauzan@student.syekhnurjati.ac.id',
                'no_telepon' => '081234567003',
                'jenis_kelamin' => 'L',
                'alamat' => 'Jl. Tuparev No. 20, Cirebon',
                'roles_id' => 1,
                'status_pendaftaran' => 'approved',
                'tanggal_daftar' => Carbon::now()->subDays(20),
            ],
            [
                'nama' => 'Fatimah Azzahra',
                'nik' => '3201234567890004',
                'jenis_peserta' => 'kampus',
                'nim' => '20210101004',
                'asal' => 'IAIN Syekh Nurjati Cirebon',
                'email' => 'fatimah.azzahra@student.syekhnurjati.ac.id',
                'no_telepon' => '081234567004',
                'jenis_kelamin' => 'P',
                'alamat' => 'Jl. Siliwangi No. 25, Cirebon',
                'roles_id' => 1,
                'status_pendaftaran' => 'approved',
                'tanggal_daftar' => Carbon::now()->subDays(15),
            ],
            [
                'nama' => 'Abdul Rahman',
                'nik' => '3201234567890005',
                'jenis_peserta' => 'kampus',
                'nim' => '20210101005',
                'asal' => 'IAIN Syekh Nurjati Cirebon',
                'email' => 'abdul.rahman@student.syekhnurjati.ac.id',
                'no_telepon' => '081234567005',
                'jenis_kelamin' => 'L',
                'alamat' => 'Jl. Dr. Cipto No. 30, Cirebon',
                'roles_id' => 1,
                'status_pendaftaran' => 'approved',
                'tanggal_daftar' => Carbon::now()->subDays(10),
            ],
            [
                'nama' => 'Dr. Andi Setiawan, M.Pd',
                'nik' => '3201234567890006',
                'jenis_peserta' => 'kampus',
                'nim' => null, // Dosen tidak punya NIM
                'asal' => 'IAIN Syekh Nurjati Cirebon',
                'email' => 'andi.setiawan@syekhnurjati.ac.id',
                'no_telepon' => '081234567006',
                'jenis_kelamin' => 'L',
                'alamat' => 'Jl. Pemuda No. 40, Cirebon',
                'roles_id' => 2,
                'status_pendaftaran' => 'approved',
                'tanggal_daftar' => Carbon::now()->subDays(5),
            ],
            [
                'nama' => 'Prof. Dr. Siti Maryam, M.A',
                'nik' => '3201234567890007',
                'jenis_peserta' => 'kampus',
                'nim' => null, // Dosen tidak punya NIM
                'asal' => 'IAIN Syekh Nurjati Cirebon',
                'email' => 'siti.maryam@syekhnurjati.ac.id',
                'no_telepon' => '081234567007',
                'jenis_kelamin' => 'P',
                'alamat' => 'Jl. Ahmad Yani No. 45, Cirebon',
                'roles_id' => 2,
                'status_pendaftaran' => 'approved',
                'tanggal_daftar' => Carbon::now()->subDays(3),
            ],
            [
                'nama' => 'Budi Santoso',
                'nik' => '3201234567890008',
                'jenis_peserta' => 'umum',
                'nim' => null,
                'asal' => 'Masyarakat Umum',
                'email' => 'budi.santoso@gmail.com',
                'password' => Hash::make('password123'), // Password: password123
                'no_telepon' => '081234567008',
                'jenis_kelamin' => 'L',
                'alamat' => 'Jl. Merdeka No. 50, Cirebon',
                'roles_id' => 1,
                'status_pendaftaran' => 'pending',
                'tanggal_daftar' => Carbon::now()->subDays(1),
            ],
            [
                'nama' => 'Rina Wulandari',
                'nik' => '3201234567890009',
                'jenis_peserta' => 'umum',
                'nim' => null,
                'asal' => 'Masyarakat Umum',
                'email' => 'rina.wulandari@gmail.com',
                'password' => Hash::make('password123'), // Password: password123
                'no_telepon' => '081234567009',
                'jenis_kelamin' => 'P',
                'alamat' => 'Jl. Sudirman No. 55, Cirebon',
                'roles_id' => 1,
                'status_pendaftaran' => 'approved',
                'tanggal_daftar' => Carbon::now(),
            ],
            [
                'nama' => 'Indra Gunawan',
                'nik' => '3201234567890010',
                'jenis_peserta' => 'kampus',
                'nim' => '20210101010',
                'asal' => 'Universitas Negeri Jakarta',
                'email' => 'indra.gunawan@unj.ac.id',
                'no_telepon' => '081234567010',
                'jenis_kelamin' => 'L',
                'alamat' => 'Jl. Rawamangun Muka, Jakarta',
                'roles_id' => 1,
                'status_pendaftaran' => 'approved',
                'tanggal_daftar' => Carbon::now()->subDays(7),
            ],
        ];

        // Insert data ke database
        foreach ($pesertaData as $data) {
            Peserta::create($data);
        }

        // Generate additional random data using factory if needed
        // Peserta::factory(10)->kampus()->create();
        // Peserta::factory(5)->umum()->create();

        $this->command->info('Peserta seeder completed successfully!');
        $this->command->info('Created ' . count($pesertaData) . ' peserta records.');
        $this->command->info('');
        $this->command->info('=== LOGIN TEST DATA ===');
        $this->command->info('PESERTA LOGIN (with password):');
        $this->command->info('Email: ahmad.rizki@student.syekhnurjati.ac.id');
        $this->command->info('Password: password123');
        $this->command->info('');
        $this->command->info('Email: budi.santoso@gmail.com');
        $this->command->info('Password: password123');
        $this->command->info('');
        $this->command->info('PESERTA LOGIN (with NIK - fallback):');
        $this->command->info('Any peserta email + their NIK as password');
    }
}
