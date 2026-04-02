<?php

namespace Database\Seeders;

use App\Models\Commune;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class CommuneSeeder extends Seeder
{
    public function run(): void
    {
        $json = File::get(database_path('data/communes.json'));
        $communes = json_decode($json, true);

        foreach ($communes as $commune) {
            Commune::updateOrCreate(
                ['id' => $commune['id']],
                [
                    'wilaya_id' => $commune['wilaya_id'],
                    'name'  => $commune['name'],
                ]
            );
        }
    }
}
