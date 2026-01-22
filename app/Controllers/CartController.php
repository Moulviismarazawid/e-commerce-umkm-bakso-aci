<?php

namespace App\Controllers;

use App\Models\MenuModel;

class CartController extends BaseController
{
    public function index()
    {
        $cart = session()->get('cart') ?? [];
        return view('shop/cart', ['cart' => $cart]);
    }

    public function add()
    {
        $menuId = (int) $this->request->getPost('menu_id');
        $qty = (int) $this->request->getPost('qty');

        if ($menuId <= 0) {
            return redirect()->back()->with('error', 'Menu tidak valid.');
        }
        if ($qty <= 0) {
            $qty = 1;
        }

        $menu = (new \App\Models\MenuModel())->find($menuId);
        if (!$menu) {
            return redirect()->back()->with('error', 'Menu tidak ditemukan.');
        }

        $cart = session()->get('cart') ?? [];

        // KEY stabil = menu_id
        $cart[$menuId] = [
            'menu_id' => (int) $menu['id'],
            'name' => (string) $menu['name'],
            'price' => (int) $menu['price'],
            'image' => $menu['image'] ?? null,
            'qty' => $qty, // ✅ SET sesuai input user
        ];

        session()->set('cart', $cart);

        return redirect()->to(site_url('cart'))->with('success', 'Item dimasukkan ke keranjang.');
    }



    public function update()
    {
        $key = (int) $this->request->getPost('key'); // ini menu_id
        $qty = (int) $this->request->getPost('qty');

        $cart = session()->get('cart') ?? [];
        if (!isset($cart[$key])) {
            return redirect()->to(site_url('cart'))->with('error', 'Item tidak ditemukan di keranjang.');
        }

        if ($qty <= 0)
            $qty = 1;
        $cart[$key]['qty'] = $qty;

        session()->set('cart', $cart);
        return redirect()->to(site_url('cart'))->with('success', 'Qty diperbarui.');
    }

    public function remove()
    {
        $key = (int) $this->request->getPost('key'); // menu_id
        $cart = session()->get('cart') ?? [];

        if (isset($cart[$key])) {
            unset($cart[$key]);
            session()->set('cart', $cart);
        }

        return redirect()->to(site_url('cart'))->with('success', 'Item dihapus.');
    }

}
