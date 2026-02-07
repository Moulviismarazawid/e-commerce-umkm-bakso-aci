<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\SettingModel;

class SettingsController extends BaseController
{
    public function kontak()
    {
        $m = new SettingModel();
        $settings = $m->getMany([
            'contact_whatsapp',
            'contact_address',
            'contact_shopee',
            'contact_tiktok',
        ]);

        return view('admin/settings/kontak', [
            'title' => 'Pengaturan Kontak',
            'settings' => $settings,
        ]);
    }

    public function kontakSave()
    {
        $m = new SettingModel();

        $wa = preg_replace('/\D+/', '', trim((string) $this->request->getPost('contact_whatsapp')));
        $addr = trim((string) $this->request->getPost('contact_address'));
        $shopee = trim((string) $this->request->getPost('contact_shopee'));
        $tiktok = trim((string) $this->request->getPost('contact_tiktok'));

        $m->setValue('contact_whatsapp', $wa !== '' ? $wa : null);
        $m->setValue('contact_address', $addr !== '' ? $addr : null);
        $m->setValue('contact_shopee', $shopee !== '' ? $shopee : null);
        $m->setValue('contact_tiktok', $tiktok !== '' ? $tiktok : null);

        return redirect()->back()->with('success', 'Kontak berhasil disimpan.');
    }
}
