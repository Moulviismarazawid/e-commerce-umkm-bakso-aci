<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\MenuModel;

class MenuController extends BaseController
{
    public function index()
    {
        $menuModel = new MenuModel();

        // Jika tabel categories ada, join untuk tampil nama kategori (opsional)
        $db = db_connect();
        $hasCategories = $db->tableExists('categories');

        if ($hasCategories) {
            $menus = $menuModel
                ->select('menus.*, categories.name as category_name')
                ->join('categories', 'categories.id = menus.category_id', 'left')
                ->orderBy('menus.id', 'DESC')
                ->findAll();
        } else {
            $menus = $menuModel->orderBy('id', 'DESC')->findAll();
        }

        return view('admin/menus/index', [
            'title' => 'Menu',
            'menus' => $menus,
            'hasCategories' => $hasCategories,
        ]);
    }

    public function create()
    {
        $db = db_connect();
        $hasCategories = $db->tableExists('categories');

        $categories = [];
        if ($hasCategories) {
            $categories = $db->table('categories')->orderBy('name', 'ASC')->get()->getResultArray();
        }

        return view('admin/menus/create', [
            'title' => 'Tambah Menu',
            'categories' => $categories,
            'hasCategories' => $hasCategories,
        ]);
    }

    public function store()
    {
        $name = trim((string) $this->request->getPost('name'));
        $description = trim((string) $this->request->getPost('description'));
        $price = (int) $this->request->getPost('price');
        $shopeeLink = trim((string) $this->request->getPost('shopee_link'));
        $tiktokLink = trim((string) $this->request->getPost('tiktok_link'));

        $categoryId = $this->request->getPost('category_id'); // bisa kosong
        $isActive = $this->request->getPost('is_active') ? 1 : 0;

        if ($name === '' || $price <= 0) {
            return redirect()->back()->withInput()->with('error', 'Nama dan harga wajib (harga > 0).');
        }

        // upload image (opsional)
        $imagePath = null;
        $file = $this->request->getFile('image');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $ext = strtolower($file->getExtension());
            $allowed = ['jpg', 'jpeg', 'png', 'webp'];
            if (!in_array($ext, $allowed, true)) {
                return redirect()->back()->withInput()->with('error', 'Format gambar harus jpg/jpeg/png/webp.');
            }

            $newName = $file->getRandomName();
            $targetDir = FCPATH . 'uploads/menus';

            if (!is_dir($targetDir)) {
                @mkdir($targetDir, 0775, true);
            }

            $file->move($targetDir, $newName);
            $imagePath = 'uploads/menus/' . $newName;
        }

        (new MenuModel())->insert([
            'category_id' => ($categoryId !== '' ? (int) $categoryId : null),
            'name' => $name,
            'description' => ($description !== '' ? $description : null),
            'price' => $price,
            'image' => $imagePath,
            'is_active' => $isActive,

            'shopee_link' => ($shopeeLink !== '' ? $shopeeLink : null),
            'tiktok_link' => ($tiktokLink !== '' ? $tiktokLink : null),
        ]);

        return redirect()->to('/admin/menus')->with('success', 'Menu berhasil ditambahkan.');
    }

    public function edit(int $id)
    {
        $menuModel = new MenuModel();
        $menu = $menuModel->find($id);

        if (!$menu) {
            return redirect()->to('/admin/menus')->with('error', 'Menu tidak ditemukan.');
        }

        $db = db_connect();
        $hasCategories = $db->tableExists('categories');

        $categories = [];
        if ($hasCategories) {
            $categories = $db->table('categories')->orderBy('name', 'ASC')->get()->getResultArray();
        }

        return view('admin/menus/edit', [
            'title' => 'Edit Menu',
            'menu' => $menu,
            'categories' => $categories,
            'hasCategories' => $hasCategories,
        ]);
    }

    public function update(int $id)
    {
        $menuModel = new MenuModel();
        $menu = $menuModel->find($id);

        if (!$menu) {
            return redirect()->to('/admin/menus')->with('error', 'Menu tidak ditemukan.');
        }

        $name = trim((string) $this->request->getPost('name'));
        $description = trim((string) $this->request->getPost('description'));
        $price = (int) $this->request->getPost('price');
        $categoryId = $this->request->getPost('category_id');
        $isActive = $this->request->getPost('is_active') ? 1 : 0;
        $shopeeLink = trim((string) $this->request->getPost('shopee_link'));
        $tiktokLink = trim((string) $this->request->getPost('tiktok_link'));


        if ($name === '' || $price <= 0) {
            return redirect()->back()->withInput()->with('error', 'Nama dan harga wajib (harga > 0).');
        }

        $data = [
            'category_id' => ($categoryId !== '' ? (int) $categoryId : null),
            'name' => $name,
            'description' => ($description !== '' ? $description : null),
            'price' => $price,
            'is_active' => $isActive,

            'shopee_link' => ($shopeeLink !== '' ? $shopeeLink : null),
            'tiktok_link' => ($tiktokLink !== '' ? $tiktokLink : null),
        ];

        // upload image baru (opsional)
        $file = $this->request->getFile('image');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $ext = strtolower($file->getExtension());
            $allowed = ['jpg', 'jpeg', 'png', 'webp'];
            if (!in_array($ext, $allowed, true)) {
                return redirect()->back()->withInput()->with('error', 'Format gambar harus jpg/jpeg/png/webp.');
            }

            $newName = $file->getRandomName();
            $targetDir = FCPATH . 'uploads/menus';

            if (!is_dir($targetDir)) {
                @mkdir($targetDir, 0775, true);
            }

            $file->move($targetDir, $newName);
            $data['image'] = 'uploads/menus/' . $newName;

            // hapus file lama
            if (!empty($menu['image'])) {
                $old = FCPATH . $menu['image'];
                if (is_file($old))
                    @unlink($old);
            }
        }

        $menuModel->update($id, $data);

        return redirect()->to('/admin/menus')->with('success', 'Menu berhasil diupdate.');
    }

    public function delete(int $id)
    {
        $menuModel = new MenuModel();
        $menu = $menuModel->find($id);

        if (!$menu) {
            return redirect()->to('/admin/menus')->with('error', 'Menu tidak ditemukan.');
        }

        // hapus file gambar
        if (!empty($menu['image'])) {
            $path = FCPATH . $menu['image'];
            if (is_file($path))
                @unlink($path);
        }

        $menuModel->delete($id);

        return redirect()->to('/admin/menus')->with('success', 'Menu berhasil dihapus.');
    }
}
