<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function toggle(Item $item)
    {
        $user = app('auth')->user();

        // Cek apakah item sudah difavoritkan
        if ($user->favoriteItems()->where('item_id', $item->id)->exists()) {
            // Jika sudah, hapus dari favorit
            $user->favoriteItems()->detach($item->id);

            return ResponseHelper::jsonResponseMethod(data: $item, status: 'unfavorited');
        } else {
            // Jika belum, tambahkan ke favorit
            $user->favoriteItems()->attach($item->id);

            return ResponseHelper::jsonResponseMethod(data: $item, status: 'favorited');
        }
    }
}
