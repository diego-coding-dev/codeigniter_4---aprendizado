<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddBatchStorageTable extends Migration {

    public function up() {
        $fields = [
            'id' => [
                'type' => 'int',
                'constraint' => 10,
                'unsigned' => true,
                'auto_increment' => true
            ],
            'batch_product_acquisition_id' => [
                'type' => 'int',
                'constraint' => 10,
                'unsigned' => true,
                'null' => false
            ],
            'storage_id' => [
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
                ->addForeignKey('batch_product_acquisition_id', 'batch_product_acquisition', 'id', 'cascade')
                ->addForeignKey('storage_id', 'storage', 'id', 'cascade')
                ->createTable('batch_storage');
    }

    public function down() {
        $this->forge->dropTable('batch_storage');
    }

}
