# DEPLOYMENT SCRIPT - Perpustakaan Daerah (Windows/PowerShell)
# Run: .\deploy.ps1

Write-Host "╔════════════════════════════════════════════════════════════╗" -ForegroundColor Cyan
Write-Host "║                                                            ║" -ForegroundColor Cyan
Write-Host "║    🚀 DEPLOYMENT SCRIPT - PERPUSTAKAAN DAERAH             ║" -ForegroundColor Cyan
Write-Host "║                                                            ║" -ForegroundColor Cyan
Write-Host "╚════════════════════════════════════════════════════════════╝" -ForegroundColor Cyan
Write-Host ""

# Step 1: Confirmation
Write-Host "⚠️  PERINGATAN: Script ini akan mengubah database!" -ForegroundColor Yellow
Write-Host "Pastikan Anda sudah BACKUP database terlebih dahulu." -ForegroundColor Yellow
Write-Host ""
$backup = Read-Host "Apakah Anda sudah backup database? (y/n)"
if ($backup -ne "y" -and $backup -ne "Y") {
    Write-Host "❌ Deployment dibatalkan. Backup database terlebih dahulu!" -ForegroundColor Red
    exit
}

Write-Host ""
Write-Host "✅ Melanjutkan deployment..." -ForegroundColor Green
Write-Host ""

# Step 2: Run Migration
Write-Host "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━" -ForegroundColor Cyan
Write-Host "📦 Step 1: Running Migrations..." -ForegroundColor White
Write-Host "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━" -ForegroundColor Cyan
php artisan migrate --force

if ($LASTEXITCODE -eq 0) {
    Write-Host "✅ Migration berhasil!" -ForegroundColor Green
} else {
    Write-Host "❌ Migration gagal! Periksa error di atas." -ForegroundColor Red
    exit
}
Write-Host ""

# Step 3: Run Seeder
Write-Host "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━" -ForegroundColor Cyan
Write-Host "📚 Step 2: Running Seeder (100 books)..." -ForegroundColor White
Write-Host "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━" -ForegroundColor Cyan
$runSeeder = Read-Host "Jalankan seeder untuk membuat 100 buku? (y/n)"
if ($runSeeder -eq "y" -or $runSeeder -eq "Y") {
    php artisan db:seed --class=BukuCategorySeeder
    if ($LASTEXITCODE -eq 0) {
        Write-Host "✅ Seeder berhasil! 100 buku telah dibuat." -ForegroundColor Green
    } else {
        Write-Host "❌ Seeder gagal!" -ForegroundColor Red
    }
} else {
    Write-Host "⏭️  Seeder dilewati." -ForegroundColor Yellow
}
Write-Host ""

# Step 4: Clear Cache
Write-Host "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━" -ForegroundColor Cyan
Write-Host "🧹 Step 3: Clearing Cache..." -ForegroundColor White
Write-Host "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━" -ForegroundColor Cyan
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear
Write-Host "✅ Cache cleared!" -ForegroundColor Green
Write-Host ""

# Step 5: Storage Link
Write-Host "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━" -ForegroundColor Cyan
Write-Host "🔗 Step 4: Creating Storage Link..." -ForegroundColor White
Write-Host "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━" -ForegroundColor Cyan
php artisan storage:link
Write-Host "✅ Storage link created!" -ForegroundColor Green
Write-Host ""

# Step 6: Composer Dump Autoload
Write-Host "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━" -ForegroundColor Cyan
Write-Host "🔄 Step 5: Dumping Composer Autoload..." -ForegroundColor White
Write-Host "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━" -ForegroundColor Cyan
composer dump-autoload
Write-Host "✅ Autoload refreshed!" -ForegroundColor Green
Write-Host ""

# Step 7: Build Assets
Write-Host "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━" -ForegroundColor Cyan
Write-Host "🎨 Step 6: Building Frontend Assets..." -ForegroundColor White
Write-Host "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━" -ForegroundColor Cyan
$buildAssets = Read-Host "Build frontend assets dengan npm? (y/n)"
if ($buildAssets -eq "y" -or $buildAssets -eq "Y") {
    npm run build
    if ($LASTEXITCODE -eq 0) {
        Write-Host "✅ Assets built successfully!" -ForegroundColor Green
    } else {
        Write-Host "❌ Build failed!" -ForegroundColor Red
    }
} else {
    Write-Host "⏭️  Build dilewati." -ForegroundColor Yellow
}
Write-Host ""

# Step 8: Run Tests
Write-Host "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━" -ForegroundColor Cyan
Write-Host "🧪 Step 7: Running Tests..." -ForegroundColor White
Write-Host "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━" -ForegroundColor Cyan
$runTests = Read-Host "Jalankan automated tests? (y/n)"
if ($runTests -eq "y" -or $runTests -eq "Y") {
    php artisan test
} else {
    Write-Host "⏭️  Tests dilewati." -ForegroundColor Yellow
}
Write-Host ""

# Final Message
Write-Host "╔════════════════════════════════════════════════════════════╗" -ForegroundColor Cyan
Write-Host "║                                                            ║" -ForegroundColor Cyan
Write-Host "║    ✅ DEPLOYMENT SELESAI!                                 ║" -ForegroundColor Cyan
Write-Host "║                                                            ║" -ForegroundColor Cyan
Write-Host "╚════════════════════════════════════════════════════════════╝" -ForegroundColor Cyan
Write-Host ""
Write-Host "🎉 Semua langkah deployment telah selesai!" -ForegroundColor Green
Write-Host ""
Write-Host "📋 TESTING CHECKLIST:" -ForegroundColor Yellow
Write-Host "  □ Coba register dengan upload dokumen" -ForegroundColor White
Write-Host "  □ Check admin panel - lihat 'Denda & Sanksi'" -ForegroundColor White
Write-Host "  □ Buat buku baru dengan Google Drive link" -ForegroundColor White
Write-Host "  □ Kunjungi /help untuk Help Center" -ForegroundColor White
Write-Host "  □ Verify 100 buku ada di database (jika run seeder)" -ForegroundColor White
Write-Host ""
Write-Host "📚 DOKUMENTASI:" -ForegroundColor Yellow
Write-Host "  → QUICK_REFERENCE.md          (Referensi cepat)" -ForegroundColor White
Write-Host "  → IMPLEMENTATION_SUMMARY.md   (Ringkasan lengkap)" -ForegroundColor White
Write-Host "  → ATURAN_PERPUSTAKAAN.md      (Aturan user)" -ForegroundColor White
Write-Host ""
Write-Host "⚠️  Jangan lupa test semua fitur sebelum production!" -ForegroundColor Yellow
Write-Host ""
Write-Host "Tekan Enter untuk keluar..."
Read-Host
