<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateQueuesTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'order_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => false,
            ],
            'queue_date' => [
                'type' => 'DATE',
                'null' => false,
            ],
            'queue_number' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => false,
            ],
            'status' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'default' => 'waiting', // waiting|cooking|done|cancelled
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);

        // agar nomor antrian unik per hari
        $this->forge->addUniqueKey(['queue_date', 'queue_number']);

        // index untuk order_id
        $this->forge->addKey('order_id');

        // FK (opsional): kalau tabel orders ada dan engine InnoDB
        $this->forge->addForeignKey('order_id', 'orders', 'id', 'CASCADE', 'CASCADE');

        $this->forge->createTable('queues', true);
    }

    public function down()
    {
        $this->forge->dropTable('queues', true);
    }
}
