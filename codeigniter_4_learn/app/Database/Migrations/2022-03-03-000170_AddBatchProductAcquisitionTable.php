<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddBatchProductAcquisitionTable extends Migration {

    public function up() {
        $fields = [
            'id' => [
                'type' => 'int',
                'constraint' => 10,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'products_acquisition_id' => [
                'type' => 'int',
                'constraint' => 10,
                'unsigned' => true,
                'null' => false
            ],
            'batch' => [
                'type' => 'varchar',
                'constraint' => '50',
                'null' => false,
                'unique' => true
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
                ->addForeignKey('products_acquisition_id', 'products_acquisitions', 'id', 'cascade')
                ->createTable('batch_product_acquisition');
    }

    public function down() {
        $this->forge->dropTable('batch_product_acquisition');
    }

}
