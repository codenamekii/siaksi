# ✨ Sistem Informasi Dokumen Akreditasi (SIAKSI)

SIAKSI adalah aplikasi web berbasis Laravel yang dirancang untuk membantu pengelolaan dokumen akreditasi di lingkungan
fakultas dan program studi. Sistem ini mendukung peran multi-user dan dilengkapi fitur-fitur yang relevan untuk proses
akreditasi.

## 🔐 Role Akses
1. **Gugus Jaminan Mutu (GJM)** — Super Admin level Fakultas
2. **Unit Jaminan Mutu (UJM)** — Admin level Prodi
3. **Asesor** — Akses terbatas (Guest)

## ⚙️ Fitur Utama
- Dashboard informatif dengan widget real-time
- Upload dokumen:
- SPMI (Sistem Penjaminan Mutu Internal)
- Renstra (Rencana Strategis)
- AMI (Audit Mutu Internal)
- Manajemen berita dan pengumuman
- Tampilan struktur organisasi (Fakultas & Prodi)
- Sistem notifikasi
- Hak akses sesuai role

## 🛠️ Tech Stack
- **Laravel 11**
- **Tailwind CSS**
- **Alpine.js**
- **Livewire**
- **Filament PHP**

## 📥 Cara Clone dan Jalankan Project

Pastikan kamu sudah menginstal Git, PHP 8.2 ke atas, Composer, dan Node.js.

```bash
git clone https://github.com/codenamekii/siaksi.git
cd siaksi
composer install
npm install && npm run build
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan serve
```

Setelah langkah di atas, aplikasi akan berjalan di `http://localhost:8000`.

## 🤝 Cara Berkontribusi

1. Fork repository ini ke akun GitHub kamu.
2. Buat branch baru dari `main`:

```bash
git checkout -b nama-fitur-atau-fix
```

3. Lakukan perubahan dan commit:

```bash
git commit -m "Deskripsi perubahan"
```

4. Push branch ke repo fork kamu:

```bash
git push origin nama-fitur-atau-fix
```

5. Buka Pull Request ke repository ini dan jelaskan perubahan yang kamu buat.

---

Project ini masih dalam pengembangan aktif. Kontribusi, feedback, dan issue sangat terbuka.
