<?php
namespace App\Models;

use CodeIgniter\Model;

class CustomerModel extends Model
{
    protected $table = 'customers';
    protected $allowedFields = ['name', 'phone', 'email', 'password_hash', 'address'];
    protected $useTimestamps = true;
}
