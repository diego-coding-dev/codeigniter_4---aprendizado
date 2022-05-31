<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddAcquisitionsTable extends Migration {

    public function up() {
        $fields = [
            'id' => [
                'type' => 'int',
                'constraint' => 10,
                'unsigned' => true,
                'auto_increment' => true
            ],
            'employee_id' => [
                'type' => 'int',
                'constraint' => 10,
                'unsigned' => true,
                'null' => false
            ],
            'provider_id' => [
                'type' => 'int',
                'constraint' => 3,
                'unsigned' => true,
                'null' => false
            ],
            'operation_type_id' => [
                'type' => 'int',
                'constraint' => 3,
                'unsigned' => true,
                'default' => 4
            ],
            'operation_value' => [
                'type' => 'numeric',
                'constraint' => '7,2',
                'null' => false,
            ],
            'document_number' => [
                'type' => 'varchar',
                'constraint' => '20',
                'null' => true,
                'default' => null
            ],
            'is_concluded' => [
                'type' => 'bool',
                'null' => false,
                'default' => false,
            ],
            'is_canceled' => [
                'type' => 'bool',
                'null' => false,
                'default' => false,
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

        $this->forge
                ->addField($fields)
                ->addPrimaryKey('id')
                ->addForeignKey('employee_id', 'employees', 'id', 'cascade')
                ->addForeignKey('provider_id', 'providers', 'id', 'cascade')
                ->addForeignKey('operation_type_id', 'operations_type', 'id', 'cascade')
                ->createTable('acquisitions');
    }

    public function down() {
        $this->forge->dropTable('acquisitions');
    }

}
