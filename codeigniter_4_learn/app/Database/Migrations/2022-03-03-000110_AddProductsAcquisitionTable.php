<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddProductsAcquisitionTable extends Migration {

    public function up() {
        $fields = [
            'id' => [
                'type' => 'int',
                'constraint' => 10,
                'unsigned' => true,
                'auto_increment' => true
            ],
            'acquisition_id' => [
                'type' => 'int',
                'constraint' => 10,
                'unsigned' => true
            ],
            'storage_id' => [
                'type' => 'int',
                'constraint' => 10,
                'unsigned' => true
            ],
            'total' => [
                'type' => 'int',
                'constraint' => 10,
                'unsigned' => true,
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
                ->addPrimaryKey(['id'])
                ->addForeignKey('acquisition_id', 'acquisitions', 'id', 'cascade')
                ->addForeignKey('storage_id', 'storage', 'id', 'cascade')
                ->createTable('products_acquisitions');
    }

    public function down() {
        $this->forge->dropTable('products_acquisitions');
    }

}
