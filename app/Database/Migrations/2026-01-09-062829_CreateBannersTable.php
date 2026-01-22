<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateBannersTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],

            'title' => ['type' => 'VARCHAR', 'constraint' => 150, 'null' => true],
            'subtitle' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],

            // alamat toko ditaruh di banner biar mudah edit
            'store_address' => ['type' => 'TEXT', 'null' => true],

            // gambar banner (path: uploads/banners/xxx.jpg)
            'image' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],

            // optional: link tombol (google maps / promo page)
            'cta_label' => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'cta_url' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],

            'sort_order' => ['type' => 'INT', 'constraint' => 11, 'default' => 0],
            'is_active' => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 1],

            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addKey(['is_active', 'sort_order']);
        $this->forge->createTable('banners', true);
    }

    public function down()
    {
        $this->forge->dropTable('banners', true);
    }
}
