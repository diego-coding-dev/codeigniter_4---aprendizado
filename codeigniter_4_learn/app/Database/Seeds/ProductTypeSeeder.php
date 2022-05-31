<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ProductTypeSeeder extends Seeder {

    public function run() {
        $productTypeModel = new \App\Models\ProductTypeModel;

        $dataDB = [
            'monitor',
            'fogão',
            'geladeira',
            'panela',
            'gabinete',
            'tv',
            'luminária',
            'smartphone',
            'smart tv',
            'encanamento',
            'cimento',
            'caderno',
            'caneta',
            'fonte',
            'lavadoura',
            'ventilador',
            'utencílio',
            'ferramenta'
        ];

        foreach ($dataDB as $value) {
            $productTypeModel->insert(['description' => $value]);
        }
    }

}
