<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddStorageTable extends Migration {

    protected $forge;

    public function __construct() {
        $this->forge = \Config\Database::forge();
    }

    public function up() {
        $field = [
            'id' => [
                'type' => 'int',
                'constraint' => 10,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'product_id' => [
                'type' => 'int',
                'constraint' => 10,
                'unsigned' => true,
                'null' => false
            ],
            'cost_price' => [
                'type' => 'numeric',
                'constraint' => '7,2',
                'null' => false,
                'default' => 0.0
            ],
            'sale_price' => [
                'type' => 'numeric',
                'constraint' => '7,2',
                'null' => false,
                'default' => 0.0
            ],
            'total' => [
                'type' => 'int',
                'constraint' => 5,
                'unsigned' => true,
                'null' => false,
                'default' => 0
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
                ->addField($field)
                ->addPrimaryKey(['id'])
                ->addForeignKey('product_id', 'products', 'id')
                ->createTable('storage');
    }

    public function down() {
        $this->forge->dropTable('storage');
    }

}
