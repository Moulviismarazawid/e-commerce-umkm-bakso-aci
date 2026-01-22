<?php
namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCashLedger extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'order_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'null' => true],
            'trx_date' => ['type' => 'DATE'],
            'type' => ['type' => 'VARCHAR', 'constraint' => 15], // income/expense
            'amount' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'description' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('trx_date');
        $this->forge->addForeignKey('order_id', 'orders', 'id', 'SET NULL', 'CASCADE');
        $this->forge->createTable('cash_ledger');
    }
    public function down()
    {
        $this->forge->dropTable('cash_ledger');
    }
}
