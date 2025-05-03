<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $items = Item::where('status', 'available')->latest()->get();
        return view('items.show', compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('items.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'description' => 'required',
            'category' => 'required',
            'condition' => 'required',
            'location' => 'required',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('photo', 'public');
        }

        $data['user_id'] = Auth::id();

        Item::create($data);

        return redirect()->route('items.index')->with('success', 'Item Berhasil Ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    public function myItems()
    {
        $items = Item::where('user_id', Auth::id())->latest()->get();
        return view('items.my_items', compact('items'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $item = Item::findOrFail($id);

        if ($item->user_id !== Auth::id()){
            abort(403, 'kamu tidak memiliki akses ke item ini.');
        }

        return view('items.edit', compact('item'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',  // Validasi kategori, jika ada
            'location' => 'required|string|max:255',  // Validasi lokasi, jika ada
            'condition' => 'required|string|in:layak,rusak ringan,rusak berat', // Validasi kondisi
            'description' => 'nullable|string',
            'photo' => 'nullable|image|max:2048', // Validasi foto, jika ada
        ]);

        // Cari item berdasarkan ID
        $item = Item::findOrFail($id);

        // Cek apakah user yang mengedit adalah pemilik item
        if ($item->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // Proses update data item
        $item->update([
            'name' => $request->input('name'),
            'category' => $request->input('category'),
            'location' => $request->input('location'),
            'condition' => $request->input('condition'),
            'description' => $request->input('description'),
        ]);

        // Jika ada foto yang diupload, proses penyimpanan foto
        if ($request->hasFile('photo')) {
            // Hapus foto lama jika ada
            if ($item->photo) {
                Storage::disk('public')->delete($item->photo);
            }

            // Simpan foto baru
            $path = $request->file('photo')->store('photos', 'public');
            $item->update(['photo' => $path]);
        }

        // Redirect kembali ke halaman yang sesuai dengan pesan sukses
        return redirect()->route('my.items')->with('success', 'Barang Berhasil Di Update!.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $item = Item::findOrFail($id);

        // Cek apakah user yang menghapus adalah pemilik item
        if ($item->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // Hapus foto jika ada
        if ($item->photo) {
            Storage::disk('public')->delete($item->photo);
        }

        // Hapus item
        $item->delete();

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('my.items')->with('success', 'Barang Berhasil Di Hapus!.');
    }
    public function adminDestroy(string $id)
    {
        $item = Item::findOrFail($id);

        // Cek apakah user yang menghapus adalah pemilik item
        if ($item->user_id !== Auth::id() && app('auth')->user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }


        // Hapus foto jika ada
        if ($item->photo) {
            Storage::disk('public')->delete($item->photo);
        }

        // Hapus item
        $item->delete();

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('my.items')->with('success', 'Barang Berhasil Di Hapus!.');
    }
}
