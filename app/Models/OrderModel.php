<?php

namespace App\Models;

use CodeIgniter\Model;

class OrderModel extends Model
{
    protected $table = 'orders';
    protected $allowedFields = [
        'invoice',
        'customer_name',
        'customer_phone',
        'customer_address',
        'notes',
        'subtotal',
        'discount',
        'total',
        'promo_code',
        'status'
    ];
    protected $useTimestamps = true;

    public function generateInvoice(): string
    {
        // ACI-YYYYMMDD-XXXX
        $date = date('Ymd');
        $prefix = "ACI-{$date}-";

        $last = $this->select('invoice')
            ->like('invoice', $prefix, 'after')
            ->orderBy('id', 'DESC')
            ->first();

        $nextNumber = 1;
        if ($last && isset($last['invoice'])) {
            $parts = explode('-', $last['invoice']);
            $seq = (int) end($parts);
            $nextNumber = $seq + 1;
        }
        return $prefix . str_pad((string) $nextNumber, 4, '0', STR_PAD_LEFT);
    }
}
