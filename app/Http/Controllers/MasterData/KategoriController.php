<?php

namespace App\Http\Controllers\MasterData;

use App\Http\Controllers\Controller;
use App\Models\KategoriEvent;
use Illuminate\Http\Request;

// load service 
use App\Services\KategoriServices;

class KategoriController extends Controller
{
    public $kategoriService;

    public function __construct()
    {
        $this->kategoriService = new KategoriServices;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kategori = $this->kategoriService->getData();
        $data = [
            'title' => 'Master Data Kategori',
            'kategoris' => $kategori,
        ];

        return view('dashboard.kategori.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data = [
            'title' => 'Tambah Kategori Event',
        ];

        return view('dashboard.kategori.form', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            // Validasi input
            $validated = $request->validate([
                'nama_kategori' => 'required|string|max:255',
                'slug' => 'required|string|max:255|unique:kategori_event,slug',
                'deskripsi' => 'nullable|string',
                'is_active' => 'nullable|boolean',
            ]);

            // Simpan data ke database
            $kategori = KategoriEvent::create([
                'nama_kategori' => $validated['nama_kategori'],
                'slug' => $validated['slug'],
                'deskripsi' => $validated['deskripsi'] ?? null,
                'is_active' => $request->has('is_active') ? true : false,
            ]);

            // Jika berhasil, redirect dengan pesan sukses
            return redirect_with_success('kategori.index', 'Kategori "' . $kategori->nama_kategori . '" berhasil ditambahkan!');
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
        $kategori = KategoriEvent::findOrFail($id);

        $data = [
            'title' => 'Detail Kategori: ' . $kategori->nama_kategori,
            'kategori' => $kategori,
        ];

        return view('dashboard.kategori.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $kategori = KategoriEvent::findOrFail($id);

        $data = [
            'title' => 'Edit Kategori: ' . $kategori->nama_kategori,
            'kategori' => $kategori,
        ];

        return view('dashboard.kategori.form', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $kategori = KategoriEvent::findOrFail($id);

            // Validasi input
            $validated = $request->validate([
                'nama_kategori' => 'required|string|max:255',
                'slug' => 'required|string|max:255|unique:kategori_event,slug,' . $id,
                'deskripsi' => 'nullable|string',
                'is_active' => 'nullable|boolean',
            ]);

            // Update data
            $kategori->update([
                'nama_kategori' => $validated['nama_kategori'],
                'slug' => $validated['slug'],
                'deskripsi' => $validated['deskripsi'] ?? null,
                'is_active' => $request->has('is_active') ? true : false,
            ]);

            return redirect_with_success('kategori.index', 'Kategori "' . $kategori->nama_kategori . '" berhasil diperbarui!');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect_with_error('kategori.index', 'Kategori tidak ditemukan.');
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
            $kategori = KategoriEvent::findOrFail($id);
            $namaKategori = $kategori->nama_kategori;

            // Check if kategori is used by any events
            // Uncomment when Event model is ready
            // if ($kategori->events()->count() > 0) {
            //     return redirect()->back()
            //         ->with('error', 'Kategori "' . $namaKategori . '" tidak dapat dihapus karena masih digunakan oleh event!');
            // }

            $kategori->delete();

            return redirect_with_success('kategori.index', 'Kategori "' . $namaKategori . '" berhasil dihapus!');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect_with_error('kategori.index', 'Kategori tidak ditemukan.');
        } catch (\Illuminate\Database\QueryException $e) {
            return back_with_error('Gagal menghapus kategori dari database. Data mungkin masih digunakan oleh data lain.');
        } catch (\Exception $e) {
            return back_with_error('Terjadi kesalahan sistem: ' . $e->getMessage());
        }
    }

    /**
     * Get kategori data for AJAX requests
     */
    public function getKategoris()
    {
        $kategoris = KategoriEvent::where('is_active', true)
            ->select('id', 'nama_kategori', 'slug')
            ->get();

        return response()->json($kategoris);
    }

    /**
     * Toggle status aktif/nonaktif
     */
    public function toggleStatus(string $id)
    {
        try {
            $kategori = KategoriEvent::findOrFail($id);
            $statusBaru = !$kategori->is_active;

            $kategori->update([
                'is_active' => $statusBaru
            ]);

            $status = $statusBaru ? 'diaktifkan' : 'dinonaktifkan';

            return back_with_success("Kategori \"{$kategori->nama_kategori}\" berhasil {$status}!");
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return back_with_error('Kategori tidak ditemukan.');
        } catch (\Illuminate\Database\QueryException $e) {
            return back_with_error('Gagal mengubah status kategori di database.');
        } catch (\Exception $e) {
            return back_with_error('Terjadi kesalahan sistem: ' . $e->getMessage());
        }
    }
}
