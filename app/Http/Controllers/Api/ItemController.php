<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Models\Item;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ItemController extends Controller
{
    public function index(Request $request){
        $item = Item::with('user')->when($request->category, function ($query, $category){
            return $query->where('category', $category);
        })->orderBy('id', 'DESC')->get();

        return ResponseHelper::jsonResponseMethod(status: 'success', data:$item);
    }

    public function store(Request $request){
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'category' => 'required',
            'condition' => 'required',
            'location' => 'required',
            'photo' => 'nullable|image|max:2048',
        ]);

        $user = $request->user();

        $item = new Item();
        $item->user_id = $user->id;
        $item->name = $request->name;
        $item->description = $request->description;
        $item->category = $request->category;
        $item->condition = $request->condition;
        $item->location = $request->location;
        $item->status = 'available';

        if ($request->file('photo')) {
            $photo = $request->file('photo');
            // Menyimpan foto langsung ke disk public
            $photoPath = $photo->store('photo', 'public');  // 'public' adalah disk yang mengarah ke storage/app/public
            $item->photo = $photoPath;  // Menyimpan path relatif ke database
        }


        $item->save();
        $item = Item::with('user')->find($item->id);

        return ResponseHelper::jsonResponseMethod(data: $item, status: 'success');
    }

    public function recomendation()
    {
        $items = Item::withCount('favorites')
        ->orderByDesc('favorites_count')
        ->take(4) // Ambil 10 item teratas
        ->get();

        return response()->json($items);
    }

    public function show(string $id)
    {
        $item = Item::with('user')->find($id);
        if(!$item){
            return ResponseHelper::jsonResponseMethod(message: 'Product not found', status: 'error', errorCode: 404);
        }
        return ResponseHelper::jsonResponseMethod(data: $item, status: 'success');

    }

    public function update(Request $request, String $id){
        $item = Item::find($id);
        if(!$item){
            return ResponseHelper::jsonResponseMethod(message: "Item Not Found.", status: 'error', errorCode : 404);
        }

        $item->name = $request->name;
        $item->description = $request->description;
        $item->category = $request->category;
        $item->location = $request->location;
        $item->status = $request->status;

        if($request->file('photo')){
            $photo = $request->file('photo');
            $photo->storeAs('public/photo', $photo->hashName());
            $item->photo = $photo->hashName();
        }

        $item->save();

        return ResponseHelper::jsonResponseMethod(data: $item, status: 'success');

    }

    public function destroy(String $id){
        $item = Item::find($id);
        if(!$item){
            return ResponseHelper::jsonResponseMethod(message: 'Product not found', status: 'error', errorCode: 404);
        }
        $item->delete();
        return ResponseHelper::jsonResponseMethod(message: 'Product successfully deleted', status: 'success');
    }

    public function favItem(){
        $user = app('auth')->user();  // Ambil pengguna yang sedang login

        if (!$user) {
            return response()->json(['message' => 'Unauthenticated'], 401);
        }

        // Ambil item favorit dari user
        $favorites = $user->favorites()->with('item')->get();

        return response()->json($favorites);
    }

    public function myItemsApi()
    {
        $items = Item::where('user_id', Auth::id())->latest()->get();

        return ResponseHelper::jsonResponseMethod(data: $items, status: 'success');
    }

    public function destroyMyItem($id)
    {
        try {
        $item = Item::findOrFail($id);

        if ($item->user_id != Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $item->delete();

        return response()->json(['message' => 'Item deleted successfully']);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Item not found'], 404);
        }
    }

    public function toggleStatus(Request $request, $id)
{
    // Validasi input
    $request->validate([
        'status' => 'required|string',
    ]);

    // Cari item berdasarkan ID
    $item = Item::find($id);

    if (!$item) {
        return response()->json(['message' => 'Item not found'], 404);
    }

    // Update status item
    $item->status = $request->status;
    $item->save();

    // Mengembalikan respons dengan data lengkap
    return response()->json([
        'id' => $item->id,
        'user_id' => $item->user_id,
        'name' => $item->name,
        'description' => $item->description,
        'category' => $item->category,
        'condition' => $item->condition,
        'location' => $item->location,
        'photo' => $item->photo,
        'status' => $item->status,
        'created_at' => $item->created_at->toISOString(),
        'updated_at' => $item->updated_at->toISOString(),
        'user' => [
            'id' => $item->user->id,
            'name' => $item->user->name,
            'email' => $item->user->email,
        ]
    ], 200);
}
}
