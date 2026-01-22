<?php

namespace App\Models;

use CodeIgniter\Model;

class BannerModel extends Model
{
    protected $table = 'banners';
    protected $allowedFields = [
        'title',
        'subtitle',
        'store_address',
        'image',
        'cta_label',
        'cta_url',
        'sort_order',
        'is_active'
    ];
    protected $useTimestamps = true;
}
