# SETUP CODEIGNITER 4 (CI4) – XAMPP WINDOWS

Dokumen ini **siap copas** untuk menjalankan CodeIgniter 4 menggunakan **XAMPP (Apache + PHP + MySQL)**.

---

## 1. SYARAT WAJIB (CEK DULU)

### 1.1 XAMPP

* PHP **8.1 atau lebih baru**
* Apache aktif
* MySQL/MariaDB aktif (jika pakai database)

Cek versi PHP:

```bash
php -v
```

### 1.2 Aktifkan PHP Extension

Buka file:

```
C:\xampp\php\php.ini
```

Pastikan **TIDAK ADA tanda ;** di depan baris ini:

```ini
extension=intl
extension=mbstring
extension=curl
extension=mysqli
```

Simpan → **Restart Apache**.

---

## 2. INSTALL CI4 (APP STARTER)

Buka **CMD / PowerShell**, lalu copas:

```bash
cd C:\xampp\htdocs
composer create-project codeigniter4/appstarter ci4-app
cd ci4-app
```

---

## 3. SETUP FILE .ENV

### 3.1 Copy env → .env

CMD:

```bat
copy env .env
```

PowerShell:

```powershell
Copy-Item env .env
```

### 3.2 ISI FILE .env (COPAS FULL)

Buka file `.env`, **replace semua isinya** dengan ini:

```ini
CI_ENVIRONMENT = development

app.baseURL = 'http://localhost/ci4/'
app.indexPage = ''

# ==============================
# DATABASE (MySQL)
# ==============================
database.default.hostname = localhost
database.default.database = ci4_db
database.default.username = root
database.default.password =
database.default.DBDriver = MySQLi
database.default.port = 3306

# ==============================
# SECURITY
# ==============================
encryption.key = 12345678901234567890123456789012
```

> Buat database di phpMyAdmin dengan nama **ci4_db** (atau ganti sesuai kebutuhan).

---

## 4. SETUP APACHE (WAJIB KE FOLDER PUBLIC)

CI4 **HARUS** diakses lewat folder `public`.

### 4.1 Edit Apache Config

Buka file:

```
C:\xampp\apache\conf\extra\httpd.conf
```

Tambahkan **di bagian paling bawah**:

```apache
Alias /ci4 "C:/xampp/htdocs/ci4-app/public"

<Directory "C:/xampp/htdocs/ci4-app/public">
    AllowOverride All
    Require all granted
</Directory>
```

### 4.2 Aktifkan mod_rewrite

Pastikan baris ini **TIDAK DIKOMENTARI**:

```apache
LoadModule rewrite_module modules/mod_rewrite.so
```

Restart **Apache**.

---

## 5. AKSES APLIKASI

Buka browser:

```
http://localhost/ci4
```

Jika benar, akan muncul **Welcome to CodeIgniter 4** 🎉

---

## 6. JALANKAN VIA TERMINAL (OPSIONAL)

Kalau mau tanpa Apache:

```bash
php spark serve
```

Akses:

```
http://localhost:8080
```

---

## 7. ERROR YANG SERING TERJADI

### ❌ 404 / Blank Page

* Salah `baseURL`
* Apache belum restart
* Tidak akses folder `public`

### ❌ Class / Controller tidak kebaca

```bash
php spark app:update
composer dump-autoload
```

### ❌ Database error

* DB belum dibuat
* Username/password salah

---

## 8. STRUKTUR PENTING CI4

```
ci4-app/
├── app/
├── public/   <-- WAJIB (index.php di sini)
├── writable/
├── vendor/
├── .env
```

---

## SELESAI ✅

CI4 siap dipakai untuk CRUD, API, Auth, dll.

Kalau mau lanjut:

* Setup login
* CRUD MySQL
* Struktur MVC CI4
* Base URL helper

Tinggal bilang 👍
