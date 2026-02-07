<?php

namespace App\Models;

use CodeIgniter\Model;

class SettingModel extends Model
{
    protected $table = 'settings';
    protected $primaryKey = 'id';
    protected $allowedFields = ['key', 'value', 'updated_at'];
    public $timestamps = false;

    public function getMany(array $keys): array
    {
        $rows = $this->whereIn('key', $keys)->findAll();
        $out = [];
        foreach ($rows as $r)
            $out[$r['key']] = $r['value'];
        return $out;
    }

    public function setValue(string $key, ?string $value): void
    {
        $existing = $this->where('key', $key)->first();
        $data = ['key' => $key, 'value' => $value, 'updated_at' => date('Y-m-d H:i:s')];

        if ($existing)
            $this->update($existing['id'], $data);
        else
            $this->insert($data);
    }
}
