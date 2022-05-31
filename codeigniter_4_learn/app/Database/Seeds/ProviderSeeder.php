<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ProviderSeeder extends Seeder {

    public function run() {
        $providerModel = new \App\Models\ProviderModel;
        $telephoneProviderModel = new \App\Models\ProviderPhoneModel;

        $providers = [
            [
                'data' => [
                    'user_type' => 2,
                    'corporate_name' => 'LIDER COMERCIO E INDUSTRIA LTDA.',
                    'cnpj' => '05.054.671/0001-59',
                    'contact' => 'amélia',
                    'address' => 'Rua Pariquis, 1056',
                    'address_complement' => 'JURUNAS',
                    'email' => 'amelia@lidernet.com.br'
                ],
                'telephone' => [
                    [
                        'telephone_type_id' => 2,
                        'telephone' => '(91) 1272-5165'
                    ]
                ]
            ],
            [
                'data' => [
                    'user_type' => 2,
                    'corporate_name' => 'IMPORTADORA OPLIMA LTDA.',
                    'cnpj' => '04.945.481/0005-92',
                    'contact' => 'fiscal',
                    'address' => 'Rodovia Br 316, S/N',
                    'address_complement' => 'Km 04',
                    'email' => 'fiscal@oplima.com.br'
                ],
                'telephone' => [
                    [
                        'telephone_type_id' => 2,
                        'telephone' => '(91) 3181-8000'
                    ]
                ]
            ],
            [
                'data' => [
                    'user_type' => 2,
                    'corporate_name' => 'CASA CONTENTE COMERCIO DE MOVEIS LTDA.',
                    'cnpj' => '13.364.464/0001-29',
                    'contact' => 'fiscal',
                    'address' => 'Travessa Padre Eutiquio, 1198',
                    'address_complement' => 'BATISTA CAMPOS',
                    'email' => 'fiscal@ultralarnet.com.br'
                ],
                'telephone' => [
                    [
                        'telephone_type_id' => 2,
                        'telephone' => '(91) 3751-1770'
                    ]
                ]
            ],
            [
                'data' => [
                    'user_type' => 2,
                    'corporate_name' => 'DICASA COMERCIO DE MATERIAIS DE CONSTRUCAO LTDA.',
                    'cnpj' => '07.013.648/0001-41',
                    'contact' => 'fiscal',
                    'address' => 'Travessa Benjamim Constant, 1624',
                    'address_complement' => 'BATISTA CAMPOS',
                    'email' => 'isacontabilidade@isacontabilidade.com.br'
                ],
                'telephone' => [
                    [
                        'telephone_type_id' => 2,
                        'telephone' => '(91) 3201-0500'
                    ]
                ]
            ],
            [
                'data' => [
                    'user_type' => 2,
                    'corporate_name' => 'CROI COMPUTADORES LTDA.',
                    'cnpj' => '08.632.253/0001-90',
                    'contact' => 'fiscal',
                    'address' => 'Rodovia Br 316 Km 03, 1962 - Sala B',
                    'address_complement' => 'GUANABARA',
                    'email' => 'contabil@croicomputadores.com.br'
                ],
                'telephone' => [
                    [
                        'telephone_type_id' => 2,
                        'telephone' => '(91) 3235-4977'
                    ]
                ]
            ]
        ];

        $providerModel->transStart();

        foreach ($providers as $provider) {
            $providerModel->protect(false)->insert($provider['data']);
            $providerModel->protect(true);

            $providerId = $providerModel->getInsertID();

            foreach ($provider['telephone'] as $telephone) {
                $telephone['provider_id'] = $providerId;

                $telephoneProviderModel->protect(false)->insert($telephone);
                $telephoneProviderModel->protect(true);
            }
        }

        $providerModel->transComplete();
    }

}
