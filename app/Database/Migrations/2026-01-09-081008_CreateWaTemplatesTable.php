<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateWaTemplatesTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'key' => ['type' => 'VARCHAR', 'constraint' => 50], // contoh: payment_confirm, order_status, dll
            'title' => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'message' => ['type' => 'TEXT'],
            'is_active' => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 1],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('key');
        $this->forge->createTable('wa_templates', true);

        // seed default template
        $this->db->table('wa_templates')->insert([
            'key' => 'payment_confirm',
            'title' => 'Konfirmasi Pembayaran',
            'message' =>
                "Hallo Admin Bakso Aci,
Saya ingin konfirmasi pembayaran.

Invoice: {invoice}
Nama: {customer_name}
WA: {customer_phone}
Total: Rp{total}

Pesanan:
{items}

Terima kasih.",
            'is_active' => 1,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
    }

    public function down()
    {
        $this->forge->dropTable('wa_templates', true);
    }
}
