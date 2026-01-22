<?php
namespace App\Models;

use CodeIgniter\Model;

class OrderItemModel extends Model
{
    protected $table = 'order_items';
    protected $allowedFields = ['order_id', 'menu_id', 'menu_name', 'price', 'qty', 'line_total'];
    protected $useTimestamps = false;
}
