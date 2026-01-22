<?php

namespace App\Models;

use CodeIgniter\Model;

class QueueModel extends Model
{
    protected $table = 'queues';
    protected $primaryKey = 'id';
    protected $allowedFields = ['order_id', 'queue_date', 'queue_number', 'status'];
    protected $useTimestamps = true;

    public function nextQueueNumber(string $dateYmd): int
    {
        $row = $this->where('queue_date', $dateYmd)
            ->orderBy('queue_number', 'DESC')
            ->first();

        $mx = 0;
        if (is_array($row) && isset($row['queue_number'])) {
            $mx = (int) $row['queue_number'];
        }

        return $mx + 1;
    }
}
