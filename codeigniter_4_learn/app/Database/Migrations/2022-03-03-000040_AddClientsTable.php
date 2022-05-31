<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddClientsTable extends Migration {

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
                'default' => 1
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
                'unique' => true
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
                ->createTable('clients');
    }

    public function down() {
        $this->forge->dropTable('clients');
    }

}
