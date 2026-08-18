<?php

namespace Database\Seeders;

use App\Models\AboutUs;
use App\Models\Brand;
use App\Models\Category;
use App\Models\ImageType;
use App\Models\SystemSetting;
use App\Models\Tag;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(PermissionSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(SpecificationSeeder::class);

        Category::insert([
            [
                'name' => 'Uncategorized',
                'slug' => 'uncategorized',
                'priority' => 0,
                'image' => 'default.jpg',
            ],
            [
                'name' => 'Luxury Cars',
                'slug' => 'luxury-cars',
                'priority' => 1,
                'image' => 'default.jpg',
            ],
            [
                'name' => 'SUVs Cars',
                'slug' => 'suvs-cars',
                'priority' => 2,
                'image' => 'default.jpg',
            ],
            [
                'name' => 'Family Cars',
                'slug' => 'family-cars',
                'priority' => 3,
                'image' => 'default.jpg',
            ],
            [
                'name' => 'Sports Cars',
                'slug' => 'sports-cars',
                'priority' => 4,
                'image' => 'default.jpg',
            ],
        ]);

        Brand::insert([
            [
                'name' => 'Unauthorized',
                'slug' => 'Unauthorized',
                'priority' => 0,
                'image' => 'default.jpg',
            ],
            [
                'name' => 'BMW',
                'slug' => 'bmw',
                'priority' => 1,
                'image' => 'default.jpg',
            ],
            [
                'name' => 'Audi',
                'slug' => 'audi',
                'priority' => 2,
                'image' => 'default.jpg',
            ],
            [
                'name' => 'Mercedes',
                'slug' => 'mercedes',
                'priority' => 3,
                'image' => 'default.jpg',
            ],
            [
                'name' => 'Porsche',
                'slug' => 'porsche',
                'priority' => 4,
                'image' => 'default.jpg',
            ],
            [
                'name' => 'Lamborghini',
                'slug' => 'lamborghini',
                'priority' => 5,
                'image' => 'default.jpg',
            ],
            [
                'name' => 'Ferrari',
                'slug' => 'ferrari',
                'priority' => 6,
                'image' => 'default.jpg',
            ],
            [
                'name' => 'Tesla',
                'slug' => 'tesla',
                'priority' => 7,
                'image' => 'default.jpg',
            ]
        ]);

        ImageType::insert([
            // Exterior Images
            [
                'name' => 'Driver Front',
                'type' => 'exterior',
            ],
            [
                'name' => 'Driver Back',
                'type' => 'exterior',
            ],
            [
                'name' => 'Driver Side',
                'type' => 'exterior',
            ],
            [
                'name' => 'Driver Rear',
                'type' => 'exterior',
            ],
            [
                'name' => 'Passenger Front',
                'type' => 'exterior',
            ],
            [
                'name' => 'Passenger Back',
                'type' => 'exterior',
            ],
            [
                'name' => 'Passenger Side',
                'type' => 'exterior',
            ],
            [
                'name' => 'Passenger Rear',
                'type' => 'exterior',
            ],
            [
                'name' => 'Front',
                'type' => 'exterior',
            ],
            [
                'name' => 'Back',
                'type' => 'exterior',
            ],
            [
                'name' => 'Side',
                'type' => 'exterior',
            ],
            [
                'name' => 'Rear',
                'type' => 'exterior',
            ],

            // Interior Images Type
            [
                'name' => 'Driver Front',
                'type' => 'interior',
            ],
            [
                'name' => 'Driver Back',
                'type' => 'interior',
            ],
            [
                'name' => 'Driver Side',
                'type' => 'interior',
            ],
            [
                'name' => 'Driver Rear',
                'type' => 'interior',
            ],
            [
                'name' => 'Passenger Front',
                'type' => 'interior',
            ],
            [
                'name' => 'Passenger Back',
                'type' => 'interior',
            ],
            [
                'name' => 'Passenger Side',
                'type' => 'interior',
            ],
            [
                'name' => 'Passenger Rear',
                'type' => 'interior',
            ],
            [
                'name' => 'Front',
                'type' => 'interior',
            ],
            [
                'name' => 'Back',
                'type' => 'interior',
            ],
            [
                'name' => 'Side',
                'type' => 'interior',
            ],
            [
                'name' => 'Rear',
                'type' => 'interior',
            ],
        ]);

        Tag::insert([
            [
                'name' => 'New',
                'slug' => 'new',
            ],
            [
                'name' => 'Used',
                'slug' => 'used',
            ],
            [
                'name' => 'Certified Pre-Owned',
                'slug' => 'certified-pre-owned',
            ],
            [
                'name' => 'Demo',
                'slug' => 'demo',
            ],
            [
                'name' => 'Salvage',
                'slug' => 'salvage',
            ],
            [
                'name' => 'Rebuilt',
                'slug' => 'rebuilt',
            ],
            [
                'name' => 'Restored',
                'slug' => 'restored',
            ],
            [
                'name' => 'Custom',
                'slug' => 'custom',
            ]
        ]);


        AboutUs::create([
            'desp' => "<p>At [Your Website Name], we believe buying and selling cars should be simple, transparent, and hassle-free. Our platform connects car owners directly with buyers, eliminating middlemen and unnecessary fees. Whether you're looking to sell your car quickly or find the perfect pre-owned vehicle at a great price, we've got you covered. We are passionate about making car transactions smoother by providing a secure, user-friendly, and efficient marketplace. </p>",
        ]);

        SystemSetting::create([
            'system_title'         => 'My System',
            'system_short_title'   => 'MS',
            'company_name'         => 'My Company',
            'tag_line'             => 'Your tagline here',
            'phone_code'           => '+1',
            'phone_number'         => '1234567890',
            'whatsapp'             => '1234567890',
            'email'                => 'info@example.com',
            'time_zone'            => 'UTC',
            'language'             => 'en',
            'admin_title'          => 'Admin Panel',
            'admin_short_title'    => 'AP',
            'copyright_text'       => '© 2025 My Company. All rights reserved.',
            'admin_copyright_text' => '© 2025 My Company. All rights reserved.',
        ]);
    }
}
