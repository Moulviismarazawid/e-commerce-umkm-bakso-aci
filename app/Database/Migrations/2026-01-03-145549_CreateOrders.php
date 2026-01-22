<?php
namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateOrders extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'invoice' => ['type' => 'VARCHAR', 'constraint' => 30, 'unique' => true],
            'customer_name' => ['type' => 'VARCHAR', 'constraint' => 120],
            'customer_phone' => ['type' => 'VARCHAR', 'constraint' => 30],
            'customer_address' => ['type' => 'TEXT', 'null' => true],
            'notes' => ['type' => 'TEXT', 'null' => true],

            'subtotal' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
            'discount' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
            'total' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'default' => 0],

            'promo_code' => ['type' => 'VARCHAR', 'constraint' => 30, 'null' => true],
            'status' => ['type' => 'VARCHAR', 'constraint' => 30, 'default' => 'pending'], // pending, confirmed, cooking, done, cancelled

            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('orders');
    }

    public function down()
    {
        $this->forge->dropTable('orders');
    }
}
