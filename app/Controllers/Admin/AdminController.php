<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\AdminModel;

class AuthController extends BaseController
{
    public function loginForm()
    {
        return view('admin/login');
    }

    public function login()
    {
        $email = trim((string) $this->request->getPost('email'));
        $password = (string) $this->request->getPost('password');

        $admin = (new AdminModel())->where('email', $email)->first();
        if (!$admin || !password_verify($password, $admin['password_hash'])) {
            return redirect()->back()->with('error', 'Login gagal.');
        }

        session()->set([
            'admin_logged_in' => true,
            'admin_id' => $admin['id'],
            'admin_name' => $admin['name'],
        ]);

        return redirect()->to('/admin/dashboard');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/admin/login');
    }
}
