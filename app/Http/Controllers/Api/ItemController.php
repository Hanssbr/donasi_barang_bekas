<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Models\Item;
use Illuminate\Http\Request;

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
            'location' => 'required',
        ]);

        $user = $request->user();

        $item = new Item();
        $item->user_id = $user->id;
        $item->name = $request->name;
        $item->description = $request->description;
        $item->category = $request->category;
        $item->location = $request->location;
        $item->status = 'available';

        if($request->file('photo')){
            $photo = $request->file('photo');
            $photo->storeAs('public/photo', $photo->hashName());
            $item->photo = $photo->hashName();
        }

        $item->save();
        $item = Item::with('user')->find($item->id);

        return ResponseHelper::jsonResponseMethod(data: $item, status: 'success');
    }
}
