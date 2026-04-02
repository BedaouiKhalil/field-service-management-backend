<?php

namespace Database\Seeders;

use App\Models\Wilaya;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class WilayaSeeder extends Seeder
{
    public function run(): void
    {
        $json = File::get(database_path('data/wilayas.json'));
        $wilayas = json_decode($json, true);

        foreach ($wilayas as $wilaya) {
            Wilaya::updateOrCreate(
                ['id' => $wilaya['id']],
                ['name' => $wilaya['name'],]
            );
        }
    }
}
