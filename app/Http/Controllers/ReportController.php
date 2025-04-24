<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Item $item)
    {
        return view('reports.store', compact('item'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Item $item)
    {
        $request->validate([
            'report'=>'required|string'
        ]);

        Report::create([
            'user_id'=>Auth::id(),
            'item_id'=>$item->id,
            'report'=>$request->report
        ]);

        return redirect()->route('items.index')->with('success', 'Laporan berhasil dikirim.');
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        $reports = Report::with('item', 'user')->get(); // Menambahkan relasi ke 'item' dan 'user'

        return view('reports.show', compact('reports'));
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
