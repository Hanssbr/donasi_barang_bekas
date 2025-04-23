<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    public function toggle(Item $item)
    {
        $user = Auth::user(); // Ambil user yang sedang login

        // Cek apakah sudah ada favorit untuk item tersebut
        $favorite = $user->favorites()->where('item_id', $item->id)->first();

        if ($favorite) {
            // Jika sudah ada, hapus dari favorit
            $favorite->delete();
        } else {
            // Jika belum ada, tambahkan item ke favorit
            $user->favorites()->create([  // Menggunakan $user untuk mengakses relasi favorites()
                'item_id' => $item->id
            ]);
        }
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
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
