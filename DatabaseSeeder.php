<?php

namespace Database\Seeders;

use App\Models\Fruit;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::forceCreate([
            'name' => 'Admin',
            'email' => 'admin@bloxcompass.test',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        $rows = [
            ['Rocket', 'Common', 'Natural', 'Sample entry'],
            ['Flame', 'Uncommon', 'Elemental', 'Sample entry'],
            ['Ice', 'Uncommon', 'Elemental', 'Sample entry'],
            ['Light', 'Rare', 'Elemental', 'Sample entry'],
            ['Magma', 'Rare', 'Elemental', 'Sample entry'],
            ['Buddha', 'Legendary', 'Beast', 'Sample entry'],
            ['Dough', 'Mythical', 'Natural', 'Sample entry'],
            ['Dragon', 'Mythical', 'Beast', 'Sample entry'],
        ];

        foreach ($rows as $i => [$name, $rarity, $type, $desc]) {
            $fruit = Fruit::create([
                'name' => $name,
                'rarity' => $rarity,
                'type' => $type,
                'description' => $desc . '. Replace with verified information.',
                'demand' => 'Unknown',
                'value' => ($i + 1) * 100,
                'data_status' => 'demo',
                'source' => 'DEMO DATA',
            ]);
            foreach ([3 => 0.8, 2 => 0.9, 1 => 1.0] as $monthsAgo => $factor) {
                $fruit->history()->create([
                    'value' => (int) ($fruit->value * $factor),
                    'recorded_at' => now()->subMonths($monthsAgo)->toDateString(),
                ]);
            }
        }
    }
}
