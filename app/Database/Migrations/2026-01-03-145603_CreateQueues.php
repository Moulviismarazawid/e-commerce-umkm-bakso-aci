<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateQueues extends Migration
{
  public function up()
  {
    $this->forge->addField([
      'id' => ['type'=>'INT','constraint'=>11,'unsigned'=>true,'auto_increment'=>true],
      'order_id' => ['type'=>'INT','constraint'=>11,'unsigned'=>true],
      'queue_date' => ['type'=>'DATE'],
      'queue_number' => ['type'=>'INT','constraint'=>11,'unsigned'=>true],
      'status' => ['type'=>'VARCHAR','constraint'=>30,'default'=>'waiting'], // waiting, processing, done
      'created_at' => ['type'=>'DATETIME','null'=>true],
      'updated_at' => ['type'=>'DATETIME','null'=>true],
    ]);
    $this->forge->addKey('id', true);
    $this->forge->addUniqueKey(['queue_date','queue_number']);
    $this->forge->addForeignKey('order_id','orders','id','CASCADE','CASCADE');
    $this->forge->createTable('queues');
  }
  public function down() { $this->forge->dropTable('queues'); }
}
