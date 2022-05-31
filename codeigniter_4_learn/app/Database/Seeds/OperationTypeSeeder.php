<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class OperationTypeSeeder extends Seeder {

    public function run() {
        $operationType = new \App\Models\OperationTypeModel;

        $dataDB = [
            'venda',
            'assistência',
            'garantia',
            'aquisição'
        ];

        foreach ($dataDB as $operation) {
            $operationType->insert(['description' => $operation]);
        }
    }

}
