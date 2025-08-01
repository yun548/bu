<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Store;
use App\Models\Activity;

class ActivitySeeder extends Seeder
{
    public function run(): void
    {
        // Crée les activités si elles n'existent pas
        $activities = [
            'Tabac',
            'Vapotage',
            'Boissons / petite restauration',
            'Presse',
            'Jeux',
            'Services financiers & administratifs',
            'Services de proximité',
        ];
        
        $activityIds = [];
        foreach ($activities as $name) {
            $activityIds[] = Activity::firstOrCreate(['name' => $name])->id;
        }
    }
}