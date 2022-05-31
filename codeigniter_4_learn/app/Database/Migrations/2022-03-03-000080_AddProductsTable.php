<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddProductsTable extends Migration {

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
            'product_type_id' => [
                'type' => 'int',
                'constraint' => 3,
                'unsigned' => true,
                'null' => false
            ],
            'brand_id' => [
                'type' => 'int',
                'constraint' => 10,
                'unsigned' => true,
                'null'
            ],
            'description' => [
                'type' => 'varchar',
                'constraint' => '250',
                'null' => false
            ],
            'out_of_production' => [
                'type' => 'bool',
                'default' => false
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
                ->addForeignKey('product_type_id', 'products_type', 'id', 'cascade')
                ->addForeignKey('brand_id', 'brands', 'id', 'cascade')
                ->createTable('products');
    }

    public function down() {
        $this->forge->dropTable('products');
    }

}
