# 🔐 Default Admin Credentials

Setelah deployment berhasil, gunakan kredensial ini untuk login ke Filament Admin Panel:

## Admin Login

**URL:** `https://[nama-service].onrender.com/admin`

**Email:** `admin@example.com`

**Password:** `password`

---

## ⚠️ PENTING: Keamanan

Setelah login pertama kali:

1. **Ubah password segera** via Filament profile settings
2. **Ubah email** jika perlu
3. Atau buat user admin baru dengan kredensial kuat

---

## 🔄 Reset Password (Jika Lupa)

Karena Shell berbayar di Render, jika lupa password:

1. Update `DatabaseSeeder.php` dengan password baru
2. Commit & push ke GitHub
3. Render akan auto-redeploy
4. Database akan di-reset dengan user baru

---

## 📊 Fitur yang Tersedia

Setelah login, kamu bisa:
- ✅ Kelola data buku
- ✅ Kelola member perpustakaan
- ✅ Kelola peminjaman
- ✅ Lihat laporan
- ✅ Generate barcode
- ✅ Export PDF

---

## 💡 Tips

- Simpan kredensial ini dengan aman
- Jangan share ke publik
- Update segera setelah deployment live
