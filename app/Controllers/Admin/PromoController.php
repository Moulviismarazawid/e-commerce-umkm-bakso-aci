<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PromoCodeModel;

class PromoController extends BaseController
{
    public function index()
    {
        $promos = (new PromoCodeModel())->orderBy('id', 'DESC')->findAll(200);

        return view('admin/promo/index', [
            'title' => 'Promo',
            'promos' => $promos,
        ]);
    }

    public function create()
    {
        return view('admin/promo/create', ['title' => 'Tambah Promo']);
    }

    public function generate()
    {
        $model = new PromoCodeModel();
        // cari kode unik
        for ($i = 0; $i < 10; $i++) {
            $code = $model->generateCode(8);
            if (!$model->where('code', $code)->first()) {
                return $this->response->setJSON(['code' => $code]);
            }
        }
        return $this->response->setJSON(['code' => 'PROMO' . random_int(1000, 9999)]);
    }

    public function store()
    {
        $model = new PromoCodeModel();

        $code = strtoupper(trim((string) $this->request->getPost('code')));
        $type = trim((string) $this->request->getPost('type')) ?: 'percent';
        $value = (int) $this->request->getPost('value');
        $minSubtotal = (int) $this->request->getPost('min_subtotal');
        $maxDiscount = $this->request->getPost('max_discount');
        $maxDiscount = ($maxDiscount === '' || $maxDiscount === null) ? null : (int) $maxDiscount;

        $startDate = trim((string) $this->request->getPost('start_date')) ?: null;
        $endDate = trim((string) $this->request->getPost('end_date')) ?: null;

        $usageLimit = $this->request->getPost('usage_limit');
        $usageLimit = ($usageLimit === '' || $usageLimit === null) ? null : (int) $usageLimit;

        $isActive = $this->request->getPost('is_active') ? 1 : 0;

        if ($code === '') {
            return redirect()->back()->withInput()->with('error', 'Kode promo wajib.');
        }
        if ($model->where('code', $code)->first()) {
            return redirect()->back()->withInput()->with('error', 'Kode promo sudah dipakai.');
        }
        if (!in_array($type, ['percent', 'fixed'], true)) {
            return redirect()->back()->withInput()->with('error', 'Tipe promo tidak valid.');
        }
        if ($value < 0)
            $value = 0;
        if ($type === 'percent' && $value > 100)
            $value = 100;

        $model->insert([
            'code' => $code,
            'type' => $type,
            'value' => $value,
            'min_subtotal' => max(0, $minSubtotal),
            'max_discount' => $maxDiscount,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'usage_limit' => $usageLimit,
            'used_count' => 0,
            'is_active' => $isActive,
        ]);

        return redirect()->to('/admin/promo')->with('success', 'Promo berhasil dibuat.');
    }

    public function edit(int $id)
    {
        $promo = (new PromoCodeModel())->find($id);
        if (!$promo)
            return redirect()->to('/admin/promo')->with('error', 'Promo tidak ditemukan.');

        return view('admin/promo/edit', [
            'title' => 'Edit Promo',
            'promo' => $promo,
        ]);
    }

    public function update(int $id)
    {
        $model = new PromoCodeModel();
        $promo = $model->find($id);
        if (!$promo)
            return redirect()->to('/admin/promo')->with('error', 'Promo tidak ditemukan.');

        $type = trim((string) $this->request->getPost('type')) ?: 'percent';
        $value = (int) $this->request->getPost('value');
        $minSubtotal = (int) $this->request->getPost('min_subtotal');
        $maxDiscount = $this->request->getPost('max_discount');
        $maxDiscount = ($maxDiscount === '' || $maxDiscount === null) ? null : (int) $maxDiscount;

        $startDate = trim((string) $this->request->getPost('start_date')) ?: null;
        $endDate = trim((string) $this->request->getPost('end_date')) ?: null;

        $usageLimit = $this->request->getPost('usage_limit');
        $usageLimit = ($usageLimit === '' || $usageLimit === null) ? null : (int) $usageLimit;

        $isActive = $this->request->getPost('is_active') ? 1 : 0;

        if (!in_array($type, ['percent', 'fixed'], true)) {
            return redirect()->back()->withInput()->with('error', 'Tipe promo tidak valid.');
        }
        if ($value < 0)
            $value = 0;
        if ($type === 'percent' && $value > 100)
            $value = 100;

        $model->update($id, [
            'type' => $type,
            'value' => $value,
            'min_subtotal' => max(0, $minSubtotal),
            'max_discount' => $maxDiscount,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'usage_limit' => $usageLimit,
            'is_active' => $isActive,
        ]);

        return redirect()->to('/admin/promo')->with('success', 'Promo berhasil diupdate.');
    }

    public function delete(int $id)
    {
        (new PromoCodeModel())->delete($id);
        return redirect()->to('/admin/promo')->with('success', 'Promo berhasil dihapus.');
    }
}
