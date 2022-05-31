<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddBrandTable extends Migration {

    public function up() {
        $fields = [
            'id' => [
                'type' => 'int',
                'constraint' => 10,
                'unsigned' => true,
                'auto_increment' => true
            ],
            'description' => [
                'type' => 'varchar',
                'constraint' => '50',
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

        $this->forge->addField($fields)
                ->addPrimaryKey(['id'])
                ->createTable('brands');
    }

    public function down() {
        $this->forge->dropTable('brands');
    }

}
