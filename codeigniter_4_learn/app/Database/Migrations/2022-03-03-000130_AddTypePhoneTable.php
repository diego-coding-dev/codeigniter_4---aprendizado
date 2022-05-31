<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddTypePhoneTable extends Migration {

    public function up() {
        $fields = [
            'id' => [
                'type' => 'int',
                'constraint' => 10,
                'unsigned' => true,
                'auto_increment' => true
            ],
            'description' => [
                'type' => 'varchar',
                'constraint' => '15',
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

        $this->forge->addField($fields)
                ->addPrimaryKey('id')
                ->createTable('telephone_type');
    }

    public function down() {
        $this->forge->dropTable('telephone_type');
    }

}
