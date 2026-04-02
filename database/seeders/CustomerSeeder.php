<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Wilaya;
use App\Models\Commune;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class CustomerSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();

        $wilayaIds = Commune::distinct()->pluck('wilaya_id')->toArray();

        foreach (range(1, 10) as $index) {

            $wilayaId = $faker->randomElement($wilayaIds);

            $commune = Commune::where('wilaya_id', $wilayaId)->inRandomOrder()->first();

            if ($commune) {
                Customer::create([
                    'name' => $faker->company,
                    'contact_name' => $faker->name,
                    'phone'        => $faker->unique()->regexify('0[567][0-9]{8}'),
                    'email'        => $faker->unique()->safeEmail,
                    'nif'          => $faker->numerify('###############'),
                    'wilaya_id'    => $wilayaId,
                    'commune_id'   => $commune->id,
                    'address'      => $faker->streetAddress,
                    'created_by'   => 1,
                ]);
            }
        }
    }
}
