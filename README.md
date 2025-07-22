# 🎓 Sistem Manajemen Data Beasiswa Mahasiswa

## 📌 Deskripsi
Proyek ini adalah aplikasi berbasis web untuk pengelolaan data beasiswa di Universitas Esa Unggul. Sistem ini membantu mahasiswa dalam mengajukan beasiswa, mengunggah dokumen persyaratan, dan memantau status pengajuan. Admin dapat memverifikasi data dan mengelola daftar penerima beasiswa.

## 🚀 Fitur Utama
### ✅ Mahasiswa
- Registrasi dan login
- Ajukan beasiswa
- Upload dokumen (KTP, KK, Slip Gaji, Transkrip Nilai)
- Lihat status pengajuan

### ✅ Admin
- Verifikasi berkas pendaftaran
- Kelola data pendaftar
- Cetak laporan penerima beasiswa

## 🛠 Teknologi yang Digunakan
- **Framework**: Laravel 12
- **UI**: Filament v3
- **Database**: MySQL
- **Server**: PHP 8.x, Composer
- **Keamanan**: CSRF Protection, HTTPS (via Ngrok), Cookie HttpOnly & Secure Flag

## 🔒 Keamanan
Pengujian dilakukan menggunakan **OWASP ZAP**:
- **High**: 0
- **Medium**: 0
- **Low**: 0
- **Info**: 1 (Cookie HttpOnly Flag Not Set) ✅ Sudah diperbaiki.

Solusi:
```php
// config/session.php
'http_only' => true,
'secure' => env('SESSION_SECURE_COOKIE', true),
'same_site' => 'lax',
