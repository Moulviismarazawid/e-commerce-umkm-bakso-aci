<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\BannerModel;

class BannerController extends BaseController
{
    public function index()
    {
        $banners = (new BannerModel())
            ->orderBy('sort_order', 'ASC')
            ->orderBy('id', 'DESC')
            ->findAll();

        return view('admin/banners/index', [
            'title' => 'Banners',
            'banners' => $banners,
        ]);
    }

    public function create()
    {
        return view('admin/banners/create', ['title' => 'Tambah Banner']);
    }

    public function store()
    {
        $title = trim((string) $this->request->getPost('title'));
        $subtitle = trim((string) $this->request->getPost('subtitle'));
        $storeAddress = trim((string) $this->request->getPost('store_address'));
        $ctaLabel = trim((string) $this->request->getPost('cta_label'));
        $ctaUrl = trim((string) $this->request->getPost('cta_url'));
        $sortOrder = (int) $this->request->getPost('sort_order');
        $isActive = $this->request->getPost('is_active') ? 1 : 0;

        // upload image (opsional, tapi banner bagusnya ada)
        $imagePath = null;
        $file = $this->request->getFile('image');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $ext = strtolower($file->getExtension());
            $allowed = ['jpg', 'jpeg', 'png', 'webp'];
            if (!in_array($ext, $allowed, true)) {
                return redirect()->back()->withInput()->with('error', 'Format gambar harus jpg/jpeg/png/webp.');
            }

            $newName = $file->getRandomName();
            $targetDir = FCPATH . 'uploads/banners';
            if (!is_dir($targetDir))
                @mkdir($targetDir, 0775, true);

            $file->move($targetDir, $newName);
            $imagePath = 'uploads/banners/' . $newName;
        }

        (new BannerModel())->insert([
            'title' => $title ?: null,
            'subtitle' => $subtitle ?: null,
            'store_address' => $storeAddress ?: null,
            'image' => $imagePath,
            'cta_label' => $ctaLabel ?: null,
            'cta_url' => $ctaUrl ?: null,
            'sort_order' => $sortOrder,
            'is_active' => $isActive,
        ]);

        return redirect()->to('/admin/banners')->with('success', 'Banner berhasil ditambahkan.');
    }

    public function edit(int $id)
    {
        $banner = (new BannerModel())->find($id);
        if (!$banner)
            return redirect()->to('/admin/banners')->with('error', 'Banner tidak ditemukan.');

        return view('admin/banners/edit', [
            'title' => 'Edit Banner',
            'banner' => $banner,
        ]);
    }

    public function update(int $id)
    {
        $model = new BannerModel();
        $banner = $model->find($id);
        if (!$banner)
            return redirect()->to('/admin/banners')->with('error', 'Banner tidak ditemukan.');

        $title = trim((string) $this->request->getPost('title'));
        $subtitle = trim((string) $this->request->getPost('subtitle'));
        $storeAddress = trim((string) $this->request->getPost('store_address'));
        $ctaLabel = trim((string) $this->request->getPost('cta_label'));
        $ctaUrl = trim((string) $this->request->getPost('cta_url'));
        $sortOrder = (int) $this->request->getPost('sort_order');
        $isActive = $this->request->getPost('is_active') ? 1 : 0;

        $data = [
            'title' => $title ?: null,
            'subtitle' => $subtitle ?: null,
            'store_address' => $storeAddress ?: null,
            'cta_label' => $ctaLabel ?: null,
            'cta_url' => $ctaUrl ?: null,
            'sort_order' => $sortOrder,
            'is_active' => $isActive,
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
            $targetDir = FCPATH . 'uploads/banners';
            if (!is_dir($targetDir))
                @mkdir($targetDir, 0775, true);

            $file->move($targetDir, $newName);
            $data['image'] = 'uploads/banners/' . $newName;

            if (!empty($banner['image'])) {
                $old = FCPATH . $banner['image'];
                if (is_file($old))
                    @unlink($old);
            }
        }

        $model->update($id, $data);

        return redirect()->to('/admin/banners')->with('success', 'Banner berhasil diupdate.');
    }

    public function delete(int $id)
    {
        $model = new BannerModel();
        $banner = $model->find($id);
        if (!$banner)
            return redirect()->to('/admin/banners')->with('error', 'Banner tidak ditemukan.');

        if (!empty($banner['image'])) {
            $path = FCPATH . $banner['image'];
            if (is_file($path))
                @unlink($path);
        }

        $model->delete($id);
        return redirect()->to('/admin/banners')->with('success', 'Banner berhasil dihapus.');
    }
}
