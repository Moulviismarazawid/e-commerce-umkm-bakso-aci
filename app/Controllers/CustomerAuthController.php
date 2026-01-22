<?php

namespace App\Controllers;

use App\Models\CustomerModel;

class CustomerAuthController extends BaseController
{
    public function registerForm()
    {
        return view('auth/register', ['title' => 'Daftar']);
    }

    public function register()
    {
        $name = trim((string) $this->request->getPost('name'));
        $phone = trim((string) $this->request->getPost('phone'));
        $email = trim((string) $this->request->getPost('email'));
        $password = (string) $this->request->getPost('password');
        $address = trim((string) $this->request->getPost('address'));

        if ($name === '' || $phone === '' || $password === '') {
            return redirect()->back()->withInput()->with('error', 'Nama, WA, dan password wajib.');
        }

        $cm = new CustomerModel();
        if ($cm->where('phone', $phone)->first()) {
            return redirect()->back()->withInput()->with('error', 'Nomor WA sudah terdaftar.');
        }

        $id = $cm->insert([
            'name' => $name,
            'phone' => $phone,
            'email' => $email ?: null,
            'address' => $address ?: null,
            'password_hash' => password_hash($password, PASSWORD_DEFAULT),
        ], true);

        session()->set([
            'customer_logged_in' => true,
            'customer_id' => $id,
            'customer_name' => $name,
            'customer_phone' => $phone,
        ]);

        return redirect()->to('/')->with('success', 'Berhasil daftar & login.');
    }

    public function loginForm()
    {
        return view('auth/login', ['title' => 'Login']);
    }

    public function login()
    {
        $phone = trim((string) $this->request->getPost('phone'));
        $password = (string) $this->request->getPost('password');

        $customer = (new CustomerModel())->where('phone', $phone)->first();
        if (!$customer || !password_verify($password, $customer['password_hash'])) {
            return redirect()->back()->with('error', 'Login gagal.');
        }

        session()->set([
            'customer_logged_in' => true,
            'customer_id' => $customer['id'],
            'customer_name' => $customer['name'],
            'customer_phone' => $customer['phone'],
        ]);

        return redirect()->to('/');
    }

    public function logout()
    {
        session()->remove(['customer_logged_in', 'customer_id', 'customer_name', 'customer_phone']);
        return redirect()->to('/')->with('success', 'Logout berhasil.');
    }
}
