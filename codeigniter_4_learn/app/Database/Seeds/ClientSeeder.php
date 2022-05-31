<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ClientSeeder extends Seeder {

    public function run() {

        $clientModel = new \App\Models\ClientModel;
        $telephoneClientModel = new \App\Models\ClientPhoneModel;

        $clients = [
            [
                'data' => [
                    'user_type_id' => 1,
                    'first_name' => 'fulano',
                    'last_name' => 'de tal',
                    'address' => 'rua fulano, número tal',
                    'address_complement' => 'perímetro do fulano',
                    'email' => 'fulano@mail.com'
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

        $clientModel->transStart();

        foreach ($clients as $client) {
            $clientModel->protect(false)->insert($client['data']);
            $clientModel->protect(true);

            $clientId = $clientModel->getInsertID();

            foreach ($client['telephone'] as $telephone) {
                $telephone['client_id'] = $clientId;
                $telephoneClientModel->protect(false)->insert($telephone);
                $telephoneClientModel->protect(true);
            }
        }

        $clientModel->transComplete();
    }

}
