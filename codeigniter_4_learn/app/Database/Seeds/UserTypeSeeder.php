<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use App\Models\UserTypeModel;

class UserTypeSeeder extends Seeder {

    public function run() {
        $userType = new UserTypeModel;

        $dataDB = [
            'client',
            'provider',
            'manager',
            'administrator'
        ];

        foreach ($dataDB as $user) {
            $userType->insert(['description' => $user]);
        }
    }

}
