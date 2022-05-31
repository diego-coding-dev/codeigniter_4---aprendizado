<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddEmployeesTable extends Migration {

    public function up() {
        $fields = [
            'id' => [
                'type' => 'int',
                'constraint' => 10,
                'unsigned' => true,
                'auto_increment' => true
            ],
            'user_type_id' => [
                'type' => 'int',
                'constraint' => 1,
                'unsigned' => true,
                'null' => false,
                'default' => 3
            ],
            'first_name' => [
                'type' => 'varchar',
                'constraint' => '150',
                'null' => false,
            ],
            'last_name' => [
                'type' => 'varchar',
                'constraint' => '150',
                'null' => false,
            ],
            'address' => [
                'type' => 'varchar',
                'constraint' => '200',
                'null' => false,
            ],
            'address_complement' => [
                'type' => 'varchar',
                'constraint' => '100',
                'null' => true,
                'default' => null
            ],
            'email' => [
                'type' => 'varchar',
                'constraint' => '200',
                'null' => true,
//                'unique' => true
            ],
            'username' => [
                'type' => 'varchar',
                'constraint' => '100',
                'null' => false
            ],
            'password_hash' => [
                'type' => 'varchar',
                'constraint' => '255',
                'null' => false
            ],
            'activation_hash' => [
                'type' => 'varchar',
                'constraint' => '64',
                'null' => true,
                'unique' => true
            ],
            'reset_hash' => [
                'type' => 'varchar',
                'constraint' => '64',
                'null' => true
            ],
            'is_active' => [
                'type' => 'bool',
                'null' => false,
                'default' => false
            ],
            'is_first_login' => [
                'type' => 'bool',
                'null' => false,
                'default' => true
            ],
            'unique_timestamp' => [
                'type' => 'datetime',
                'null' => true,
                'default' => null
            ],
            'expired_hash_in' => [
                'type' => 'datetime',
                'null' => true,
                'default' => null
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
                ->addForeignKey('user_type_id', 'users_type', 'id', 'cascade')
                ->createTable('employees');
    }

    public function down() {
        $this->forge->dropTable('employees');
    }

}
