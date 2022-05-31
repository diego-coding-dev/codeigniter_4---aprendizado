<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use App\Models\BrandModel;

class BrandsSeeder extends Seeder {

    public function run() {

        $brandModel = new BrandModel;

        $brands = [
            'philips',
            'electrolux',
            'consul',
            'arno',
            'tigre',
            'amanco',
            'sharp',
            'samsung',
            'lg',
            'mallory',
            'philco',
            'bosh',
            'brastemp',
            'equation',
            'versace',
            'tramontina',
            'corsair'
        ];

        foreach ($brands as $brand) {

            $brandModel->insert([
                'description' => $brand
            ]);
        }
    }

}
