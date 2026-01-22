<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\WaTemplateModel;

class WaTemplateController extends BaseController
{
    public function index()
    {
        $model = new WaTemplateModel();

        // Pastikan template default ada
        $existing = $model->where('key', 'payment_confirm')->first();
        if (!$existing) {
            $model->insert([
                'key' => 'payment_confirm',
                'title' => 'Konfirmasi Pembayaran',
                'message' =>
                    "Hallo Admin Bakso Aci,
Saya ingin konfirmasi pembayaran.

Invoice: {invoice}
Nama: {customer_name}
WA: {customer_phone}
Total: Rp{total}

Pesanan:
{items}

Terima kasih.",
                'is_active' => 1,
            ]);
        }

        $templates = $model->orderBy('id', 'ASC')->findAll();

        return view('admin/wa_templates/index', [
            'title' => 'Template WhatsApp',
            'templates' => $templates,
        ]);
    }

    public function save()
    {
        $model = new WaTemplateModel();

        $id = (int) $this->request->getPost('id');
        $title = trim((string) $this->request->getPost('title'));
        $message = trim((string) $this->request->getPost('message'));
        $isActive = $this->request->getPost('is_active') ? 1 : 0;

        if ($id <= 0) {
            return redirect()->back()->with('error', 'Template tidak valid.');
        }
        if ($message === '') {
            return redirect()->back()->with('error', 'Pesan template tidak boleh kosong.');
        }

        $model->update($id, [
            'title' => $title ?: null,
            'message' => $message,
            'is_active' => $isActive,
        ]);

        return redirect()->to('/admin/wa-templates')->with('success', 'Template WhatsApp berhasil disimpan.');
    }
}
