# ⚡ QUICK REFERENCE - Perpustakaan Daerah

## 🎯 TL;DR - Apa yang Berubah?

```
1. ❌ HAPUS: Rating bintang dari buku
2. ➕ TAMBAH: Upload dokumen saat registrasi member
3. ➕ TAMBAH: Link Google Drive untuk buku digital
4. 🔄 UBAH: "Payments" → "Denda & Sanksi"
5. 🔄 UBAH: No. Telepon → Help Center link
6. 🔄 UBAH: Nama app → "Perpustakaan Daerah"
7. ➕ TAMBAH: 100 buku (10 kategori × 10 buku)
8. 📝 TAMBAH: Dokumentasi lengkap aturan perpustakaan
```

---

## 🚀 Deploy Commands (Copy-Paste)

```bash
# 1. Backup database DULU!
# mysqldump -u username -p database_name > backup.sql

# 2. Run migration
php artisan migrate

# 3. Run seeder (optional tapi recommended)
php artisan db:seed --class=BukuCategorySeeder

# 4. Clear cache
php artisan config:clear && php artisan cache:clear && php artisan view:clear

# 5. Build assets
npm run build

# 6. Storage link (jika belum)
php artisan storage:link

# 7. Test
php artisan test
```

---

## 📊 Database Changes

### Tabel `buku`:
```sql
+ gdrive_link VARCHAR(255) NULLABLE
- rating DOUBLE
```

### Tabel `member`:
```sql
+ document_path VARCHAR(255) NULLABLE
```

---

## 📁 New Files Created

```
📄 ATURAN_PERPUSTAKAAN.md            (Dokumentasi aturan)
📄 CHANGELOG_UPDATES.md              (Detail perubahan)
📄 IMPLEMENTATION_SUMMARY.md         (Ringkasan lengkap)
📄 QUICK_REFERENCE.md                (File ini)
📄 database/seeders/BukuCategorySeeder.php
📄 database/migrations/2026_01_19_*.php
📄 resources/views/help.blade.php
```

---

## 🧪 Testing Checklist

### Frontend:
```
□ Register page shows document upload
□ Dashboard shows "Help Center" not phone
□ Title shows "Perpustakaan Daerah"
□ /help page accessible
```

### Admin Panel:
```
□ Navigation shows "Denda & Sanksi" not "Payments"
□ Buku form has Google Drive link field
□ Member form has document upload field
□ No rating field in Buku form
□ Labels in Bahasa Indonesia
```

### Database:
```
□ Migration runs without error
□ Seeder creates 100 books
□ 10 categories exist
□ Document uploads save correctly
```

---

## 🐛 Troubleshooting

### Error: "Access denied for user"
```bash
# Check .env database credentials
# Pastikan MySQL server running
# Test connection: php artisan migrate:status
```

### Error: "Class BukuCategorySeeder not found"
```bash
composer dump-autoload
php artisan db:seed --class=BukuCategorySeeder
```

### Error: File upload fails
```bash
# Check storage permissions
chmod -R 775 storage
php artisan storage:link
```

### Migration fails
```bash
# Rollback last migration
php artisan migrate:rollback --step=1

# Check database manually
php artisan db
```

---

## 📞 Quick Links

- **Help Page**: `/help`
- **Admin Panel**: `/admin`
- **Register**: `/register`
- **Login**: `/login`

---

## 💡 Pro Tips

1. **Seeder realistis**: Gunakan BukuCategorySeeder untuk demo yang menarik
2. **Document validation**: Max 2MB, PDF/JPG/PNG only
3. **Google Drive**: Pastikan link set to "Anyone with the link can view"
4. **Denda**: Bisa dikustomisasi per buku (field `denda_per_hari`)
5. **Backup**: SELALU backup database sebelum migrate production!

---

## 📝 Rollback Plan

Jika terjadi masalah:

```bash
# 1. Restore database
mysql -u username -p database_name < backup.sql

# 2. Rollback migration
php artisan migrate:rollback --step=1

# 3. Revert code (if using git)
git reset --hard HEAD~1
```

---

## ✅ Definition of Done

Project ini dianggap selesai ketika:

- [x] Semua migration berjalan tanpa error
- [x] Seeder menghasilkan 100 buku
- [x] Form registrasi ada upload dokumen
- [x] Admin panel menampilkan "Denda & Sanksi"
- [x] Dashboard menampilkan Help Center link
- [x] Help page accessible dan informatif
- [x] No rating field in Buku
- [x] Google Drive link field in Buku
- [x] All labels in Indonesian
- [x] Documentation complete

---

## 🎉 Success Criteria

User acceptance:
- Member bisa register dengan upload dokumen ✅
- Admin bisa input link Google Drive untuk buku ✅
- Sistem tidak lagi menyebutkan "rating" ✅
- Nama aplikasi "Perpustakaan Daerah" di mana-mana ✅
- Help Center accessible dan jelas ✅
- Ada 100 buku untuk demo ✅

---

**Version:** 1.0.0  
**Last Update:** 19 Jan 2026  
**Status:** ✅ COMPLETE & READY
