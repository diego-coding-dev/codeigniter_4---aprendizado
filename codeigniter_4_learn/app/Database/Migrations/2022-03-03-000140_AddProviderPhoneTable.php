<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddProviderPhoneTable extends Migration {

    public function up() {
        $fileds = [
            'id' => [
                'type' => 'int',
                'constraint' => 10,
                'unsigned' => true,
                'auto_increment' => true
            ],
            'telephone_type_id' => [
                'type' => 'int',
                'constraint' => 10,
                'unsigned' => true,
                'null' => false
            ],
            'provider_id' => [
                'type' => 'int',
                'constraint' => 10,
                'unsigned' => true,
                'null' => false
            ],
            'telephone' => [
                'type' => 'varchar',
                'constraint' => '18',
                'null' => false
            ],
            'created_at' => [
                'type' => 'datetime',
                'null' => true,
                'default' => null
            ],
            'updated_at' => [
                'type' => 'datetime',
                'null' => true,
                'default' => null
            ],
            'deleted_at' => [
                'type' => 'datetime',
                'null' => true,
                'default' => null
            ]
        ];

        $this->forge->addField($fileds)
                ->addPrimaryKey('id')
                ->addForeignKey('telephone_type_id', 'telephone_type', 'id', 'cascade')
                ->addForeignKey('provider_id', 'providers', 'id', 'cascade')
                ->createTable('providers_phone');
    }

    public function down() {
        $this->forge->dropTable('providers_phone');
    }

}
