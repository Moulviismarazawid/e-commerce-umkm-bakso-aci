<?php
namespace App\Models;

use CodeIgniter\Model;

class MenuModel extends Model
{
    protected $table = 'menus';
    protected $allowedFields = ['category_id', 'name', 'description', 'price', 'image', 'is_active'];
    protected $useTimestamps = true;
}
