<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddSalesTable extends Migration {

    protected $forge;

    public function __construct() {
        $this->forge = \Config\Database::forge();
    }

    public function up() {
        $fields = [
            'id' => [
                'type' => 'int',
                'constraint' => 10,
                'unsigned' => true,
                'auto_increment' => true
            ],
            'client_id' => [
                'type' => 'int',
                'constraint' => 10,
                'unsigned' => true
            ],
            'employee_id' => [
                'type' => 'int',
                'constraint' => 10,
                'unsigned' => true,
                'null' => false
            ],
            'operation_type' => [
                'type' => 'int',
                'constraint' => 3,
                'unsigned' => true,
                'default' => 1
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
                ->addForeignKey('client_id', 'clients', 'id', 'cascade')
                ->addForeignKey('employee_id', 'employees', 'id', 'cascade')
                ->addForeignKey('operation_type', 'operations_type', 'id', 'cascade')
                ->createTable('sales');
    }

    public function down() {
        $this->forge->dropTable('sales');
    }

}
