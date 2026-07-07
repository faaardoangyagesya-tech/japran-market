<?php

namespace Database\Seeders;

use App\Models\Game;
use Illuminate\Database\Seeder;

class GameSeeder extends Seeder
{
    public function run(): void
    {
        $games = [
            ['name' => 'Roblox', 'slug' => 'roblox', 'icon' => '🎮', 'description' => 'Akun Roblox dengan berbagai item dan robux'],
            ['name' => 'Minecraft', 'slug' => 'minecraft', 'icon' => '⛏️', 'description' => 'Akun Minecraft Java & Bedrock Edition'],
            ['name' => 'Free Fire', 'slug' => 'free-fire', 'icon' => '🔫', 'description' => 'Akun Free Fire dengan skin dan diamond'],
            ['name' => 'Mobile Legends', 'slug' => 'mobile-legends', 'icon' => '⚔️', 'description' => 'Akun Mobile Legends dengan hero dan skin'],
            ['name' => 'PUBG Mobile', 'slug' => 'pubg-mobile', 'icon' => '🎯', 'description' => 'Akun PUBG Mobile dengan outfit dan UC'],
            ['name' => 'Valorant', 'slug' => 'valorant', 'icon' => '🔫', 'description' => 'Akun Valorant dengan skin senjata'],
            ['name' => 'Genshin Impact', 'slug' => 'genshin-impact', 'icon' => '⭐', 'description' => 'Akun Genshin Impact dengan karakter 5★'],
            ['name' => 'Steam', 'slug' => 'steam', 'icon' => '💻', 'description' => 'Akun Steam dengan berbagai game'],
        ];

        foreach ($games as $game) {
            Game::create($game);
        }
    }
}
