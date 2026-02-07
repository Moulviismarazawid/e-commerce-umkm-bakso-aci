<?php

namespace App\Controllers;

use App\Models\MenuModel;
use App\Models\BannerModel;
use App\Models\SettingModel;

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

        $settings = [];
        if (class_exists(\App\Models\SettingModel::class)) {
            $db = db_connect();
            if ($db->tableExists('settings')) {
                $settings = (new SettingModel())->getMany([
                    'contact_shopee',
                    'contact_tiktok',
                ]);
            }
        }

        return view('shop/index', [
            'menus' => $menus,
            'banners' => $banners,
            'settings' => $settings,
            'title' => 'Bakso Mukbang Kemiling'
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
            'title' => 'Promo Bakso Mukbang Kemiling',
            'promos' => $promos
        ]);
    }

    public function kontak()
    {
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

        $settings = [];
        if (class_exists(\App\Models\SettingModel::class)) {
            $db = db_connect();
            if ($db->tableExists('settings')) {
                $settings = (new SettingModel())->getMany([
                    'contact_shopee',
                    'contact_tiktok',
                ]);
            }
        }

        return view('shop/kontak', [
            'title' => 'Kontak | Bakso Mukbang Kemiling',
            'banners' => $banners,
            'settings' => $settings, // ✅
        ]);
    }


}
