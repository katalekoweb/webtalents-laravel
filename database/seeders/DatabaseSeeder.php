<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\Country;
use App\Models\State;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@webtalenkts.com',
        ]);

        User::factory()->create([
            'name' => 'Candidate User',
            'email' => 'candidate@webtalenkts.com',
        ]);

        $locationsData = [
            "Angola" => [
                "Benguela" => ["Benguela", "Cubal", "Lobito", "Navegantes", "Baia Farta", "Catumbela", "Ganda", "Caimbambo", "Balombo", "Chongoroi", "Bocoio"],
                "Luanda" => ["Viana", "Belas", "Cazenga", "Mussulo", "Talatona", "Kilamba Kiaxi", "Cacuaco"],
                "Huambo" => ["Huambo", "Caála", "Ucuma"],
                "Huíla" => ["Lubango", "Humpata", "Quilengues", "kaconda", "Cacula", "Matala"]
            ],
            "Brasil" => [
                "São Paulo" => ["São Paulo", "São José dos Campos"],
                "Rio de Janeiro" => ["Rio de Janeiro"]
            ],
            "Portugal" => [
                "Porto" => ["Porto"],
                "Lisboa" => ["Lisboa"]
            ]
        ];

        foreach ($locationsData as $countryName => $states) {
            $country = Country::query()->createOrFirst([
                "name" => $countryName
            ]);

            foreach ($states as $stateName => $cities) {
                $state = State::query()->createOrFirst([
                    'country_id' => $country->id,
                    "name" => $stateName
                ]);

                foreach ($cities as $key => $city) {
                City::query()->createOrFirst([
                    'country_id' => $country->id,
                    'state_id' => $state->id,
                    "name" => $city
                ]);
            }
            }
        }
    }
}
