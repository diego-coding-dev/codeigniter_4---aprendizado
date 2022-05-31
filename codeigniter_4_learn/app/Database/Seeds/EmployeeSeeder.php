<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class EmployeeSeeder extends Seeder {

    public function run() {

        $employeeModel = new \App\Models\EmployeeModel;
        $telephoneEmployeeModel = new \App\Models\EmployeePhoneModel;

        $employees = [
            [
                'data' => [
                    'user_type_id' => 3,
                    'first_name' => 'funcionario',
                    'last_name' => 'exemplo',
                    'address' => 'endereço funcionario exemplo',
                    'address_complement' => 'complemento funcionario exemplo',
                    'email' => 'funcionario@mail.com',
                    'username' => 'funcionario',
                    'password_hash' => password_hash('12345', PASSWORD_DEFAULT),
                    'is_active' => true,
                    'is_first_login' => false
                ],
                'telephone' => [
                    [
                        'telephone_type_id' => 1,
                        'telephone' => '(99) 99999-9999',
                    ],
                    [
                        'telephone_type_id' => 1,
                        'telephone' => '(99) 88888-8888',
                    ]
                ]
            ]
        ];

        $employeeModel->transStart();

        foreach ($employees as $employee) {
            $employeeModel->protect(false)->insert($employee['data']);
            $employeeModel->protect(true);

            $employeeId = $employeeModel->getInsertID();

            foreach ($employee['telephone'] as $telephone) {
                $telephone['employee_id'] = $employeeId;
                $telephoneEmployeeModel->protect(false)->insert($telephone);
                $telephoneEmployeeModel->protect(true);
            }
        }

        $employeeModel->transComplete();
    }

}
