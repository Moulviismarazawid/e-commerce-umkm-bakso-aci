<?php

namespace App\Models;

use CodeIgniter\Model;

class WaTemplateModel extends Model
{
    protected $table = 'wa_templates';
    protected $primaryKey = 'id';
    protected $allowedFields = ['key', 'title', 'message', 'is_active'];
    protected $useTimestamps = true;

    public function getActiveByKey(string $key): ?array
    {
        $row = $this->where('key', $key)->where('is_active', 1)->first();
        return is_array($row) ? $row : null;
    }
}
