<?php

namespace App\Http\Controllers\MasterData;

use App\Http\Controllers\Controller;
use App\Models\RangeEvent;
use Illuminate\Http\Request;

// load service 
use App\Services\LingkupServices;

class LingkupController extends Controller
{
    public $lingkupService;

    public function __construct()
    {
        $this->lingkupService = new LingkupServices;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $lingkup = $this->lingkupService->getData();
        $data = [
            'title' => 'Master Data Lingkup',
            'lingkups' => $lingkup,
        ];

        return view('dashboard.lingkup.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data = [
            'title' => 'Tambah Lingkup Event',
        ];

        return view('dashboard.lingkup.form', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            // Validasi input
            $validated = $request->validate([
                'nama_range' => 'required|string|max:255',
                'slug' => 'required|string|max:255|unique:range_event,slug',
                'deskripsi' => 'nullable|string',
                'is_active' => 'nullable|boolean',
            ]);

            // Simpan data ke database
            $lingkup = RangeEvent::create([
                'nama_range' => $validated['nama_range'],
                'slug' => $validated['slug'],
                'deskripsi' => $validated['deskripsi'] ?? null,
                'is_active' => $request->has('is_active') ? true : false,
            ]);

            // Jika berhasil, redirect dengan pesan sukses
            return redirect_with_success('lingkup.index', 'Lingkup "' . $lingkup->nama_range . '" berhasil ditambahkan!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Jika validasi gagal, kembalikan dengan error validasi
            return back_with_error('Data yang dimasukkan tidak valid. Silakan periksa kembali.')
                ->withErrors($e->validator);
        } catch (\Illuminate\Database\QueryException $e) {
            // Jika error database (misal: constraint violation)
            return back_with_error('Gagal menyimpan data ke database. Pastikan data tidak duplikat.');
        } catch (\Exception $e) {
            // Jika error umum lainnya
            return back_with_error('Terjadi kesalahan sistem: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $lingkup = RangeEvent::findOrFail($id);

        $data = [
            'title' => 'Detail Lingkup: ' . $lingkup->nama_range,
            'lingkup' => $lingkup,
        ];

        return view('dashboard.lingkup.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $lingkup = RangeEvent::findOrFail($id);

        $data = [
            'title' => 'Edit Lingkup: ' . $lingkup->nama_range,
            'lingkup' => $lingkup,
        ];

        return view('dashboard.lingkup.form', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $lingkup = RangeEvent::findOrFail($id);

            // Validasi input
            $validated = $request->validate([
                'nama_range' => 'required|string|max:255',
                'slug' => 'required|string|max:255|unique:range_event,slug,' . $id,
                'deskripsi' => 'nullable|string',
                'is_active' => 'nullable|boolean',
            ]);

            // Update data
            $lingkup->update([
                'nama_range' => $validated['nama_range'],
                'slug' => $validated['slug'],
                'deskripsi' => $validated['deskripsi'] ?? null,
                'is_active' => $request->has('is_active') ? true : false,
            ]);

            return redirect_with_success('lingkup.index', 'Lingkup "' . $lingkup->nama_range . '" berhasil diperbarui!');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect_with_error('lingkup.index', 'Lingkup tidak ditemukan.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return back_with_error('Data yang dimasukkan tidak valid. Silakan periksa kembali.')
                ->withErrors($e->validator);
        } catch (\Illuminate\Database\QueryException $e) {
            return back_with_error('Gagal memperbarui data ke database. Pastikan data tidak duplikat.');
        } catch (\Exception $e) {
            return back_with_error('Terjadi kesalahan sistem: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $lingkup = RangeEvent::findOrFail($id);
            $namaLingkup = $lingkup->nama_range;

            // Check if lingkup is used by any events
            // Uncomment when Event model is ready
            // if ($lingkup->events()->count() > 0) {
            //     return back_with_error('Lingkup "' . $namaLingkup . '" tidak dapat dihapus karena masih digunakan oleh event!');
            // }

            $lingkup->delete();

            return redirect_with_success('lingkup.index', 'Lingkup "' . $namaLingkup . '" berhasil dihapus!');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect_with_error('lingkup.index', 'Lingkup tidak ditemukan.');
        } catch (\Illuminate\Database\QueryException $e) {
            return back_with_error('Gagal menghapus lingkup dari database. Data mungkin masih digunakan oleh data lain.');
        } catch (\Exception $e) {
            return back_with_error('Terjadi kesalahan sistem: ' . $e->getMessage());
        }
    }

    /**
     * Get lingkup data for AJAX requests
     */
    public function getLingkups()
    {
        $lingkups = RangeEvent::where('is_active', true)
            ->select('id', 'nama_range', 'slug')
            ->get();

        return response()->json($lingkups);
    }

    /**
     * Toggle status aktif/nonaktif
     */
    public function toggleStatus(string $id)
    {
        try {
            $lingkup = RangeEvent::findOrFail($id);
            $statusBaru = !$lingkup->is_active;

            $lingkup->update([
                'is_active' => $statusBaru
            ]);

            $status = $statusBaru ? 'diaktifkan' : 'dinonaktifkan';

            return back_with_success("Lingkup \"{$lingkup->nama_range}\" berhasil {$status}!");
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return back_with_error('Lingkup tidak ditemukan.');
        } catch (\Illuminate\Database\QueryException $e) {
            return back_with_error('Gagal mengubah status lingkup di database.');
        } catch (\Exception $e) {
            return back_with_error('Terjadi kesalahan sistem: ' . $e->getMessage());
        }
    }
}
