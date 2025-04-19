<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'description',
        'category',
        'condition',
        'location',
        'photo'
    ];


    public function users() {
        return $this->belongsTo(User::class);
    }

    public function submissions() {
        return $this->hasMany(Submission::class);
    }

    public function comments() {
        return $this->hasMany(Comment::class);
    }

    public function favorites() {
        return $this->hasMany(Favorite::class);
    }

    public function reports() {
        return $this->hasMany(Report::class);
    }
}
