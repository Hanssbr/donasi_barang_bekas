<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Favorite;
use App\Models\History;
use App\Models\Item;
use App\Models\Report;
use App\Models\Submission;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'rayhan',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('123'),
            'role' => 'admin'
        ]);

        User::factory()->count(5)->create()->each(function ($user) {
            // Buat 2 item per user
            $user->items()->saveMany(Item::factory()->count(2)->make());

            // Buat submission
            $user->submissions()->saveMany(Submission::factory()->count(1)->make([
                'item_id' => Item::inRandomOrder()->first()->id
            ]));

            // Buat comment
            $user->comments()->saveMany(Comment::factory()->count(1)->make([
                'item_id' => Item::inRandomOrder()->first()->id
            ]));

            // Buat favorite
            $user->favorites()->saveMany(Favorite::factory()->count(1)->make([
                'item_id' => Item::inRandomOrder()->first()->id
            ]));

            // Buat report
            $user->reports()->saveMany(Report::factory()->count(1)->make([
                'item_id' => Item::inRandomOrder()->first()->id
            ]));

        });
    }
}
