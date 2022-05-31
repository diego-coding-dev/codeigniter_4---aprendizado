<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class TelephoneTypeSeeder extends Seeder {

    public function run() {
        $telephoneTypeModel = new \App\Models\TelephoneTypeModel;

        $dataType = [
            [
                'description' => 'residencial'
            ],
            [
                'description' => 'comercial'
            ],
            [
                'description' => 'fax'
            ]
        ];

        foreach ($dataType as $type) {
            $telephoneTypeModel->insert($type);
        }
    }

}
