<?php

namespace App\Controllers;

use App\Models\MenuModel;
use App\Models\BannerModel;

class ShopController extends BaseController
{
    public function index()
    {
        $menus = (new MenuModel())
            ->where('is_active', 1)
            ->orderBy('id', 'DESC')
            ->findAll();

        $banners = [];
        if (class_exists(\App\Models\BannerModel::class)) {
            $db = db_connect();
            if ($db->tableExists('banners')) {
                $banners = (new BannerModel())
                    ->where('is_active', 1)
                    ->orderBy('sort_order', 'ASC')
                    ->orderBy('id', 'DESC')
                    ->findAll();
            }
        }

        return view('shop/index', [
            'menus' => $menus,
            'banners' => $banners,
            'title' => 'Bakso Aci'
        ]);
    }


    public function detail(int $id)
    {
        $menu = (new MenuModel())->find($id);
        if (!$menu)
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        return view('shop/detail', ['menu' => $menu]);
    }

    public function promo()
    {
        $promos = db_connect()
            ->table('promo_codes')
            ->where('is_active', 1)
            ->get()
            ->getResultArray();

        return view('shop/promo', [
            'title' => 'Promo Bakso Aci',
            'promos' => $promos
        ]);
    }

}
