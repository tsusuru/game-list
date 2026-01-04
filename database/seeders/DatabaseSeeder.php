<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Publisher;
use App\Models\Genre;
use App\Models\Developer;
use App\Models\Game;
use App\Models\Favourite;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // --- Users ---
        $admin = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]
        );

        $user = User::firstOrCreate(
            ['email' => 'user@example.com'],
            [
                'name' => 'Normal User',
                'password' => Hash::make('password'),
                'role' => 'user',
            ]
        );

        // --- Publishers ---
        $publishers = collect([
            'Nintendo',
            'Sony',
            'Microsoft',
            'Valve',
            'Ubisoft',
        ])->map(fn ($name) => Publisher::firstOrCreate(['name' => $name]));

        // --- Genres ---
        $genres = collect([
            'Action',
            'RPG',
            'Adventure',
            'Puzzle',
            'Strategy',
        ])->map(fn ($name) => Genre::firstOrCreate(['name' => $name], ['user_id' => $admin->id]));

        // --- Developers ---
        $developers = collect([
            'FromSoftware',
            'CD Projekt',
            'Rockstar Games',
            'Naughty Dog',
            'Supergiant Games',
        ])->map(fn ($name) => Developer::firstOrCreate(['name' => $name], ['user_id' => $admin->id]));

        // --- Games ---
        $gamesData = [
            [
                'title' => 'Elden Ring',
                'synopsis' => 'Open-world action RPG met uitdagende bosses en veel build-variatie.',
                'release_date' => '2022-02-25',
                'playtime_hours' => 80,
            ],
            [
                'title' => 'The Witcher 3',
                'synopsis' => 'Verhaalgedreven RPG met quests, keuzes en exploration.',
                'release_date' => '2015-05-19',
                'playtime_hours' => 120,
            ],
            [
                'title' => 'Hades',
                'synopsis' => 'Rogue-like action met snelle combat en runs die steeds anders zijn.',
                'release_date' => '2020-09-17',
                'playtime_hours' => 30,
            ],
            [
                'title' => 'Portal 2',
                'synopsis' => 'Puzzle game met portals en sterke humor in de dialogen.',
                'release_date' => '2011-04-19',
                'playtime_hours' => 12,
            ],
            [
                'title' => 'The Last of Us Part I',
                'synopsis' => 'Cinematic action-adventure met focus op verhaal en stealth.',
                'release_date' => '2013-06-14',
                'playtime_hours' => 18,
            ],
            [
                'title' => 'Civilization VI',
                'synopsis' => 'Turn-based strategy: bouw een rijk en win via meerdere routes.',
                'release_date' => '2016-10-21',
                'playtime_hours' => 60,
            ],
        ];

        $createdGames = collect();

        foreach ($gamesData as $i => $data) {
            // Mix owner om je policy te testen: sommige games van admin, sommige van user
            $ownerId = ($i % 2 === 0) ? $admin->id : $user->id;

            $game = Game::firstOrCreate(
                ['title' => $data['title']],
                $data + [
                    'is_active' => true,
                    'publisher_id' => $publishers->random()->id,
                    'genre_id' => $genres->random()->id,
                    'developer_id' => $developers->random()->id,
                    'user_id' => $ownerId,
                ]
            );

            $createdGames->push($game);
        }

        // --- Favourites ---
        // Maak alvast 5 favourites voor de normale user (handig voor jouw "diepere validatie")
        $createdGames->take(5)->each(function (Game $game) use ($user) {
            Favourite::firstOrCreate([
                'user_id' => $user->id,
                'game_id' => $game->id,
            ]);
        });
    }
}
