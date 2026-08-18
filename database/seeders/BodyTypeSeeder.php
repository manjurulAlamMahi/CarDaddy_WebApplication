<?php

namespace Database\Seeders;

use App\Models\BodyType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BodyTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        BodyType::insert([
            [
                'name' => 'Convertibles',
                'slug' => 'convertibles',
            ],
            [
                'name' => 'Coupes',
                'slug' => 'coupes',
            ],
            [
                'name' => 'Crossovers',
                'slug' => 'crossovers',
            ],
            [
                'name' => 'Luxury Vehicles',
                'slug' => 'luxury_vehicles',
            ],
            [
                'name' => 'Sedans',
                'slug' => 'sedans',
            ],
            [
                'name' => 'Sports Cars',
                'slug' => 'sports_cars',
            ],
            // Add more brands as needed
        ]);
    }
}
