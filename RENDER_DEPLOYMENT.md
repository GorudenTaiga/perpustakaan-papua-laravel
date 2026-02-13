# 🚀 Panduan Deploy Laravel ke Render.com

Panduan lengkap untuk deploy project **Perpustakaan Laravel** ke Render.com secara GRATIS.

---

## 📋 PERSIAPAN

### 1. Push Project ke GitHub
Pastikan semua file sudah di-push ke GitHub repository, termasuk:
- ✅ `render.yaml`
- ✅ `render-build.sh`
- ✅ `render-start.sh`

```bash
git add .
git commit -m "Add Render.com deployment config"
git push origin main
```

---

## 🎯 LANGKAH DEPLOYMENT

### **Step 1: Buat Akun Render.com**
1. Buka [render.com](https://render.com)
2. Klik **"Get Started for Free"**
3. Sign up dengan **GitHub account** (recommended)
4. Authorize Render untuk akses GitHub repos

---

### **Step 2: Buat Web Service Baru**
1. Di Render Dashboard, klik **"New +"** → **"Web Service"**
2. Pilih **"Build and deploy from a Git repository"**
3. Klik **"Connect"** di samping repository `perpustakaan-laravel`
4. Jika repo tidak muncul, klik **"Configure account"** untuk tambah akses

---

### **Step 3: Konfigurasi Service**

#### **Basic Settings:**
- **Name:** `perpustakaan-laravel` (atau nama lain)
- **Region:** Singapore (atau terdekat)
- **Branch:** `main` (atau branch aktif)
- **Root Directory:** (kosongkan)
- **Environment:** `Docker`

#### **Docker Settings:**
Render akan otomatis detect `Dockerfile` di root project.
- Tidak perlu isi Build Command atau Start Command
- Semua sudah dikonfigurasi di Dockerfile

#### **Plan:**
- Pilih: **Free** (0$/month)
- ⚠️ Catatan: Will spin down after 15 minutes of inactivity

---

### **Step 4: Environment Variables**

Klik **"Advanced"** → **"Add Environment Variable"**

Tambahkan variabel berikut:

| Key | Value |
|-----|-------|
| `APP_NAME` | `Perpustakaan Daerah` |
| `APP_ENV` | `production` |
| `APP_KEY` | (Generate nanti - Step 5) |
| `APP_DEBUG` | `false` |
| `APP_URL` | `https://perpustakaan-laravel.onrender.com` (sesuaikan nama) |
| `DB_CONNECTION` | `sqlite` |
| `SESSION_DRIVER` | `database` |
| `QUEUE_CONNECTION` | `database` |
| `CACHE_STORE` | `database` |
| `LOG_CHANNEL` | `stack` |
| `LOG_LEVEL` | `error` |

---

### **Step 5: Generate APP_KEY**

Setelah deploy pertama kali:

1. Buka **Shell** di Render Dashboard (tab "Shell" di service)
2. Jalankan command:
```bash
php artisan key:generate --show
```
3. Copy output (contoh: `base64:xxxxxxxxxxxxx`)
4. Paste ke Environment Variable `APP_KEY`
5. Klik **"Save Changes"** → Service akan auto-redeploy

---

### **Step 6: Deploy!**

1. Klik **"Create Web Service"**
2. Render akan otomatis:
   - Clone repository
   - Install dependencies (Composer + NPM)
   - Build assets (Vite)
   - Setup database (SQLite)
   - Run migrations
   - Start aplikasi

3. Monitor di tab **"Logs"** untuk melihat progress

4. Tunggu hingga muncul:
```
✓ Build successful!
✓ Deploy live at https://perpustakaan-laravel.onrender.com
```

---

## ✅ VERIFIKASI

### Cek Aplikasi:
- Buka URL: `https://[nama-service].onrender.com`
- Pastikan homepage muncul
- Test login ke Filament admin: `/admin`
- Test fitur pencarian buku

### Troubleshooting:
Jika ada error, cek di tab **"Logs"**:
```bash
# View application logs
php artisan log:tail

# Clear cache
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

---

## 🔄 AUTO-DEPLOY

Setiap kali push ke GitHub (branch main):
- Render otomatis detect changes
- Auto-rebuild & redeploy
- Zero-downtime deployment

---

## ⚙️ OPTIONAL: Custom Domain

1. Di Render Dashboard → **Settings** → **Custom Domains**
2. Klik **"Add Custom Domain"**
3. Masukkan domain (contoh: `perpustakaan.example.com`)
4. Update DNS records di domain provider:
   - Type: `CNAME`
   - Name: `perpustakaan` (subdomain)
   - Value: `[nama-service].onrender.com`
5. Wait 5-10 minutes untuk SSL auto-provisioning

---

## 📊 FREE TIER LIMITS

| Resource | Limit |
|----------|-------|
| **Uptime** | 750 jam/bulan (cukup untuk 1 app 24/7) |
| **RAM** | 512 MB |
| **CPU** | Shared |
| **Storage** | 1 GB (persistent disk) |
| **Bandwidth** | 100 GB/bulan |
| **Auto-sleep** | Setelah 15 menit idle |
| **Spin-up time** | ~30 detik saat diakses |

---

## 🛠️ MAINTENANCE

### Update Aplikasi:
```bash
git add .
git commit -m "Update feature"
git push origin main
# Render auto-deploy
```

### Lihat Logs:
- Dashboard → Logs tab
- Atau via Shell: `php artisan log:tail`

### Backup Database:
```bash
# Download database.sqlite via Shell
cat database/database.sqlite > backup.sql
```

---

## 💡 TIPS & TRICKS

1. **Prevent Sleep:**
   - Gunakan cron job / uptime robot untuk ping setiap 10 menit
   - Gratis: [uptimerobot.com](https://uptimerobot.com)

2. **Speed Up:**
   - Enable OPcache (auto di production)
   - Use CDN untuk static assets

3. **Monitor:**
   - Render Dashboard → Metrics
   - Track response time & errors

---

## 📞 SUPPORT

**Render.com Issues:**
- Docs: [render.com/docs](https://render.com/docs)
- Community: [community.render.com](https://community.render.com)

**Project Issues:**
- Check logs di Render Dashboard
- Debug via Shell tab

---

## ✨ SELESAI!

Aplikasi perpustakaan sekarang live di internet! 🎉

URL: `https://[nama-service].onrender.com`
Admin: `https://[nama-service].onrender.com/admin`
