<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddProvidersTable extends Migration {

    protected $forge;

    public function __construct() {
        $this->forge = \Config\Database::forge();
    }

    public function up() {
        $this->forge->addField([
                    'id' => [
                        'type' => 'int',
                        'constraint' => 10,
                        'unsigned' => true,
                        'auto_increment' => true
                    ],
                    'user_type' => [
                        'type' => 'int',
                        'constraint' => 1,
                        'unsigned' => true,
                        'null' => false,
                        'default' => 1
                    ],
                    'corporate_name' => [
                        'type' => 'varchar',
                        'constraint' => '250',
                        'null' => false
                    ],
                    'cnpj' => [
                        'type' => 'varchar',
                        'constraint' => '18',
                        'null' => false
                    ],
                    'contact' => [
                        'type' => 'varchar',
                        'constraint' => '150',
                        'null' => false
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
                ])
                ->addPrimaryKey('id')
                ->addForeignKey('user_type', 'users_type', 'id')
                ->createTable('providers');
    }

    public function down() {
        $this->forge->dropTable('providers');
    }

}
