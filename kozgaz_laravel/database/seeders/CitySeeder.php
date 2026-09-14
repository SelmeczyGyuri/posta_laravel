<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\County;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;


class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Példa: minden megyéhez létrehozunk néhány várost

        $counties = County::all();

        foreach ($counties as $county) {

            City::create([
                'name' => $county->name . ' város 1',
                'zip_code' => '1000',
                'id_county' => $county->id,
            ]);

            City::create([
                'name' => $county->name . ' város 2',
                'zip_code' => '2000',
                'id_county' => $county->id,
            ]);
        }
    }
}
