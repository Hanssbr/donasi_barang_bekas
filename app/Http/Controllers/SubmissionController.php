<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Submission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubmissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $submissions = Submission::where('user_id', Auth::id())->get();
        return view('submissions.my_submissions', compact('submissions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Item $item)
    {
        return view('submissions.create', compact('item'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $itemId)
    {
        $request->validate([
            'message' => 'nullable|string|max:1000'
        ]);

        Submission::create([
            'item_id' => $itemId,
            'user_id' => Auth::id(),
            'message' => $request->input('message'),
            'status' => 'pending',
        ]);

        return redirect()->route('items.index')->with('success', 'Permintaan Berhasil Diajukan!.');
    }

    public function incoming()
    {
        $user = Auth::user();

        $submissions = Submission::with('item', 'user')
        ->whereHas('item', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->latest()->get();

        return view('submissions.incoming', compact('submissions'));
    }


        public function approve($id)
    {
        $submission = Submission::findOrFail($id);

        $submission->status = 'disetujui';
        $submission->save();

        // Redirect kembali dengan pesan sukses
        return redirect()->route('submissions.incoming')->with('success', 'Pengajuan donasi telah disetujui.');
    }

    public function reject($id)
    {
        // Cari submission berdasarkan ID
        $submission = Submission::findOrFail($id);

        // Update status submission menjadi 'rejected'
        $submission->status = 'rejected';
        $submission->save();

        // Redirect kembali dengan pesan sukses
        return redirect()->route('submissions.incoming')->with('success', 'Pengajuan donasi telah ditolak.');
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
