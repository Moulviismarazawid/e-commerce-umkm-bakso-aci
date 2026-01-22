<?php

namespace App\Models;

use CodeIgniter\Model;

class PromoCodeModel extends Model
{
    protected $table = 'promo_codes';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'code',
        'type',
        'value',
        'min_subtotal',
        'max_discount',
        'start_date',
        'end_date',
        'usage_limit',
        'used_count',
        'is_active'
    ];
    protected $useTimestamps = true;

    public function generateCode(int $len = 8): string
    {
        $chars = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789';
        $code = '';
        for ($i = 0; $i < $len; $i++) {
            $code .= $chars[random_int(0, strlen($chars) - 1)];
        }
        return $code;
    }

    // dipakai di CheckoutController kamu
    public function validatePromo(string $code, int $subtotal): array
    {
        $promo = $this->where('code', strtoupper($code))->first();
        if (!$promo)
            return ['valid' => false, 'message' => 'Kode promo tidak ditemukan.', 'discount' => 0];
        if ((int) $promo['is_active'] !== 1)
            return ['valid' => false, 'message' => 'Kode promo tidak aktif.', 'discount' => 0];
        if ($subtotal < (int) $promo['min_subtotal'])
            return ['valid' => false, 'message' => 'Minimal belanja belum terpenuhi.', 'discount' => 0];

        $today = date('Y-m-d');
        if (!empty($promo['start_date']) && $today < $promo['start_date'])
            return ['valid' => false, 'message' => 'Promo belum berlaku.', 'discount' => 0];
        if (!empty($promo['end_date']) && $today > $promo['end_date'])
            return ['valid' => false, 'message' => 'Promo sudah berakhir.', 'discount' => 0];

        if (!empty($promo['usage_limit']) && (int) $promo['used_count'] >= (int) $promo['usage_limit']) {
            return ['valid' => false, 'message' => 'Kuota promo sudah habis.', 'discount' => 0];
        }

        $discount = 0;
        if (($promo['type'] ?? 'percent') === 'percent') {
            $discount = (int) floor($subtotal * ((int) $promo['value'] / 100));
            if (!empty($promo['max_discount'])) {
                $discount = min($discount, (int) $promo['max_discount']);
            }
        } else {
            $discount = (int) $promo['value'];
        }

        $discount = max(0, min($discount, $subtotal));
        return ['valid' => true, 'message' => 'OK', 'discount' => $discount];
    }

    public function incrementUsed(string $code): void
    {
        $promo = $this->where('code', strtoupper($code))->first();
        if (!$promo)
            return;
        $this->update((int) $promo['id'], ['used_count' => (int) $promo['used_count'] + 1]);
    }
}
