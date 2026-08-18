<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Brand::insert([
            [
                'name' => 'Acura',
                'slug' => 'acura',
            ],
            [
                'name' => 'Toyota',
                'slug' => 'toyota',
            ],
            [
                'name' => 'Honda',
                'slug' => 'honda',
            ],
            [
                'name' => 'BMW',
                'slug' => 'bmw',
            ],
            [
                'name' => 'Mercedes-Benz',
                'slug' => 'mercedes-benz',
            ],
            [
                'name' => 'Audi',
                'slug' => 'audi',
            ],
            [
                'name' => 'Cadillac',
                'slug' => 'cadillac',
            ],
            [
                'name' => 'Ford',
                'slug' => 'ford',
            ],
            // Add more brands as needed
        ]);
    }
}
