<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddBatchProductSaleTable extends Migration {

    public function up() {
        $fields = [
            'id' => [
                'type' => 'int',
                'constraint' => 10,
                'unsigned' => true,
                'auto_increment' => true
            ],
            'product_sale_id' => [
                'type' => 'int',
                'constraint' => 10,
                'unsigned' => true,
                'null' => false
            ],
            'batch_storage_id' => [
                'type' => 'int',
                'constraint' => 10,
                'unsigned' => true,
                'null' => false
            ],
            'total' => [
                'type' => 'int',
                'constratint' => 5,
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

        $this->forge
                ->addField($fields)
                ->addPrimaryKey('id')
                ->addForeignKey('product_sale_id', 'products_sale', 'id', 'cascade')
                ->addForeignKey('batch_storage_id', 'batch_storage', 'id', 'cascade')
                ->createTable('batch_product_sale');
    }

    public function down() {
        $this->forge->dropTable('batch_product_sale');
    }

}
