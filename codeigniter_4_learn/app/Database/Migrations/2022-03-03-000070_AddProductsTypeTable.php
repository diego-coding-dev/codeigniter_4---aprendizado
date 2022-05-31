<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddProductsTypeTable extends Migration {

    protected $forge;

    public function __construct() {
        $this->forge = \Config\Database::forge();
    }

    public function up() {
        $fields = [
            'id' => [
                'type' => 'int',
                'constraint' => 3,
                'unsigned' => true,
                'auto_increment' => true
            ],
            'description' => [
                'type' => 'varchar',
                'constraint' => '250',
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
                ->createTable('products_type');
    }

    public function down() {
        $this->forge->dropTable('products_type');
    }

}
