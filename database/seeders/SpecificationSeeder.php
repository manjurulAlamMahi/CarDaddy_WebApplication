<?php

namespace Database\Seeders;

use App\Models\BodyType;
use App\Models\Color;
use App\Models\Cylinder;
use App\Models\Door;
use App\Models\Drivetrain;
use App\Models\FuelType;
use App\Models\Mileage;
use App\Models\MPG;
use App\Models\Size;
use App\Models\Transmission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SpecificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        BodyType::insert([
            [
                'name' => 'Sedan',
                'slug' => 'sedan',
            ],
            [
                'name' => 'Hatchback',
                'slug' => 'hatchback',
            ],
            [
                'name' => 'SUV',
                'slug' => 'suv',
            ],
            [
                'name' => 'Other',
                'slug' => 'other',
            ]
        ]);

        Transmission::insert([
            [
                'name' => 'Automatic',
                'slug' => 'automatic',
            ],
            [
                'name' => 'Manual',
                'slug' => 'manual',
            ]
        ]);

        Mileage::insert([
            [
                'name' => '0-5000',
                'slug' => '0-5000',
            ],
            [
                'name' => '5000-10000',
                'slug' => '5000-10000',
            ]
        ]);

        FuelType::insert([
            [
                'name' => 'Petrol',
                'slug' => 'petrol',
            ],
            [
                'name' => 'Diesel',
                'slug' => 'diesel',
            ]
        ]);

        Size::insert([
            [
                'name' => 'Small',
                'slug' => 'small',
            ],
            [
                'name' => 'Medium',
                'slug' => 'medium',
            ],
            [
                'name' => 'Large',
                'slug' => 'large',
            ]
        ]);

        Door::insert([
            [
                'name' => '2',
                'slug' => '2',
            ],
            [
                'name' => '4',
                'slug' => '4',
            ]
        ]);

        Color::insert([
            [
                'name' => 'Black',
                'code' => '#000000',
            ],
            [
                'name' => 'White',
                'code' => '#FFFFFF',
            ],
            [
                'name' => 'Red',
                'code' => '#FF0000',
            ],
            [
                'name' => 'Blue',
                'code' => '#0000FF',
            ]
        ]);

        Drivetrain::insert([
            [
                'name' => 'FWD',
                'slug' => 'fwd',
            ],
            [
                'name' => 'RWD',
                'slug' => 'rwd',
            ],
            [
                'name' => 'AWD',
                'slug' => 'awd',
            ]
        ]);

        Cylinder::insert([
            [
                'name' => '4',
                'slug' => '4',
            ],
            [
                'name' => '6',
                'slug' => '6',
            ],
            [
                'name' => '8',
                'slug' => '8',
            ]
        ]);

        MPG::insert([
            [
                'name' => '20',
                'slug' => '20',
            ],
            [
                'name' => '25',
                'slug' => '25',
            ],
            [
                'name' => '30',
                'slug' => '30',
            ]
        ]);
    }
}
