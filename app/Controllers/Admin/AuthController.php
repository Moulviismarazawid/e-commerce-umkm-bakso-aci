<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\AdminModel;

class AuthController extends BaseController
{
    /**
     * FORM LOGIN ADMIN
     */
    public function loginForm()
    {
        return view('admin/login');
    }

    /**
     * PROSES LOGIN ADMIN
     */
    public function login()
    {
        $email = trim((string) $this->request->getPost('email'));
        $password = (string) $this->request->getPost('password');

        if ($email === '' || $password === '') {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Email dan password wajib diisi.');
        }

        $admin = (new AdminModel())
            ->where('email', $email)
            ->first();

        if (!$admin) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Email tidak ditemukan.');
        }

        if (!password_verify($password, $admin['password_hash'])) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Password salah.');
        }

        // SESSION ADMIN
        session()->set([
            'admin_logged_in' => true,
            'admin_id' => $admin['id'],
            'admin_name' => $admin['name'],
            'admin_email' => $admin['email'],
        ]);

        return redirect()->to('/admin/dashboard');
    }

    /**
     * FORM REGISTER ADMIN
     */
    public function registerForm()
    {
        return view('admin/register');
    }

    /**
     * PROSES REGISTER ADMIN
     */
    public function register()
    {
        $name = trim((string) $this->request->getPost('name'));
        $email = trim((string) $this->request->getPost('email'));
        $password = (string) $this->request->getPost('password');

        if ($name === '' || $email === '' || $password === '') {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Nama, email, dan password wajib diisi.');
        }

        $adminModel = new AdminModel();

        // CEK EMAIL DUPLIKAT
        if ($adminModel->where('email', $email)->first()) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Email sudah terdaftar.');
        }

        // INSERT KE TABEL admins
        $adminModel->insert([
            'name' => $name,
            'email' => $email,
            'password_hash' => password_hash($password, PASSWORD_DEFAULT),
        ]);

        return redirect()->to('/admin/login')
            ->with('success', 'Admin berhasil dibuat. Silakan login.');
    }

    /**
     * LOGOUT ADMIN
     */
    public function logout()
    {
        session()->remove([
            'admin_logged_in',
            'admin_id',
            'admin_name',
            'admin_email',
        ]);

        return redirect()->to('/admin/login')
            ->with('success', 'Logout berhasil.');
    }
}
