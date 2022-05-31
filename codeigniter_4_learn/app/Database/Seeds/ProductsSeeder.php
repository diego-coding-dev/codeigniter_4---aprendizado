<?php

namespace App\Database\Seeds;

use App\Models\ProductModel;
use CodeIgniter\Database\Seeder;

class ProductsSeeder extends Seeder {

    public function run() {

        $productModel = new \App\Models\ProductModel;
        $storageModel = new \App\Models\StorageModel;

        $productsList = [
            [
                'product_type_id' => '14',
                'brand_id' => '17',
                'description' => 'Fonte Atx 600W Corsair VS600 80 Plus White - Cp-9020224'
            ],
            [
                'product_type_id' => '1',
                'brand_id' => '9',
                'description' => 'Monitor LG 24MP400-B 23,8 Full Hd IPS HDMI FreeSync'
            ],
            [
                'product_type_id' => '1',
                'brand_id' => '8',
                'description' => 'Monitor Samsung 24 Full Hd HDMI Vga LF24T350FHLMZD'
            ],
            [
                'product_type_id' => '3',
                'brand_id' => '2',
                'description' => 'Refrigerador Electrolux Top Freezer 382L 2 Portas Frost Free Platinum 220V TF42S'
            ],
            [
                'product_type_id' => '15',
                'brand_id' => '3',
                'description' => 'Lavadora de Roupas 12kg Consul CWH12AB 110V'
            ],
            [
                'product_type_id' => '16',
                'brand_id' => '10',
                'description' => 'Ventilador de Coluna Mallory Air Timer TS+ 40cm Preto/Dourado 220V'
            ],
            [
                'product_type_id' => '4',
                'brand_id' => '16',
                'description' => 'Jogo de Utensílios 5 Peças Utility Aço Inox'
            ],
            [
                'product_type_id' => '4',
                'brand_id' => '16',
                'description' => 'Pote Hermético com Travas 537ML Verde Plástico'
            ],
            [
                'product_type_id' => '2',
                'brand_id' => '10',
                'description' => 'Kit Aparador de Pelos Mallory Wet&Dry Delling'
            ],
            [
                'product_type_id' => '10',
                'brand_id' => '6',
                'description' => 'Luva Soldável 60mm'
            ],
            [
                'product_type_id' => '10',
                'brand_id' => '5',
                'description' => 'União Soldável 50 Mm'
            ],
            [
                'product_type_id' => '18',
                'brand_id' => '12',
                'description' => 'Jogo de Ferramentas Bosch V-line 83 Peças'
            ],
            [
                'product_type_id' => '18',
                'brand_id' => '1',
                'description' => 'Oximetro de Pulso Oxygen Check'
            ],
            [
                'product_type_id' => '18',
                'brand_id' => '1',
                'description' => 'Compressor de Ar 12v'
            ],
            [
                'product_type_id' => '4',
                'brand_id' => '2',
                'description' => 'Air Fryer Fritadeira Elétrica Sem Óleo'
            ]
        ];

        foreach ($productsList as $product) {

            $productModel->transStart();

            $productModel->protect(false)->insert($product);

            $storageModel->addInStorage($productModel->getInsertID());

            $productModel->transComplete();
        }
    }

}
