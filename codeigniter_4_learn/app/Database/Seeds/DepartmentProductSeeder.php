<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DepartmentProductSeeder extends Seeder {

    public function run() {
        $departmentStorageModel = new \App\Models\DepartamentProductModel;

        $departments = [
            'informática',
            'material escolar',
            'material de construção',
            'eletrodoméstico',
            'tecnologia',
            'artigos para o lar',
            'eletronicos'
        ];

        foreach ($departments as $department) {
            $departmentStorageModel->insert(['description' => $department]);
        }
    }

}
