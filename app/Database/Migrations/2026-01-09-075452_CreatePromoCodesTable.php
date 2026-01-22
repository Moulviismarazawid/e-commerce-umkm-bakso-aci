<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePromoCodesTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'code' => ['type' => 'VARCHAR', 'constraint' => 30, 'null' => false],
            'type' => ['type' => 'VARCHAR', 'constraint' => 10, 'default' => 'percent'], // percent|fixed
            'value' => ['type' => 'INT', 'default' => 0], // percent (0-100) or fixed amount
            'min_subtotal' => ['type' => 'INT', 'default' => 0],
            'max_discount' => ['type' => 'INT', 'null' => true], // optional for percent
            'start_date' => ['type' => 'DATE', 'null' => true],
            'end_date' => ['type' => 'DATE', 'null' => true],
            'usage_limit' => ['type' => 'INT', 'null' => true],
            'used_count' => ['type' => 'INT', 'default' => 0],
            'is_active' => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 1],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('code');
        $this->forge->addKey(['is_active', 'start_date', 'end_date']);
        $this->forge->createTable('promo_codes', true);
    }

    public function down()
    {
        $this->forge->dropTable('promo_codes', true);
    }
}
