#!/bin/bash
# DEPLOYMENT SCRIPT - Perpustakaan Daerah
# Jalankan script ini untuk deploy semua perubahan

echo "╔════════════════════════════════════════════════════════════╗"
echo "║                                                            ║"
echo "║    🚀 DEPLOYMENT SCRIPT - PERPUSTAKAAN DAERAH             ║"
echo "║                                                            ║"
echo "╚════════════════════════════════════════════════════════════╝"
echo ""

# Color codes
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

# Step 1: Confirmation
echo -e "${YELLOW}⚠️  PERINGATAN: Script ini akan mengubah database!${NC}"
echo -e "${YELLOW}Pastikan Anda sudah BACKUP database terlebih dahulu.${NC}"
echo ""
read -p "Apakah Anda sudah backup database? (y/n): " -n 1 -r
echo ""
if [[ ! $REPLY =~ ^[Yy]$ ]]
then
    echo -e "${RED}❌ Deployment dibatalkan. Backup database terlebih dahulu!${NC}"
    exit 1
fi

echo ""
echo -e "${GREEN}✅ Melanjutkan deployment...${NC}"
echo ""

# Step 2: Run Migration
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
echo "📦 Step 1: Running Migrations..."
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
php artisan migrate --force

if [ $? -eq 0 ]; then
    echo -e "${GREEN}✅ Migration berhasil!${NC}"
else
    echo -e "${RED}❌ Migration gagal! Periksa error di atas.${NC}"
    exit 1
fi
echo ""

# Step 3: Run Seeder
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
echo "📚 Step 2: Running Seeder (100 books)..."
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
read -p "Jalankan seeder untuk membuat 100 buku? (y/n): " -n 1 -r
echo ""
if [[ $REPLY =~ ^[Yy]$ ]]
then
    php artisan db:seed --class=BukuCategorySeeder
    if [ $? -eq 0 ]; then
        echo -e "${GREEN}✅ Seeder berhasil! 100 buku telah dibuat.${NC}"
    else
        echo -e "${RED}❌ Seeder gagal!${NC}"
    fi
else
    echo -e "${YELLOW}⏭️  Seeder dilewati.${NC}"
fi
echo ""

# Step 4: Clear Cache
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
echo "🧹 Step 3: Clearing Cache..."
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear
echo -e "${GREEN}✅ Cache cleared!${NC}"
echo ""

# Step 5: Storage Link
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
echo "🔗 Step 4: Creating Storage Link..."
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
php artisan storage:link
echo -e "${GREEN}✅ Storage link created!${NC}"
echo ""

# Step 6: Composer Dump Autoload
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
echo "🔄 Step 5: Dumping Composer Autoload..."
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
composer dump-autoload
echo -e "${GREEN}✅ Autoload refreshed!${NC}"
echo ""

# Step 7: Build Assets
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
echo "🎨 Step 6: Building Frontend Assets..."
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
read -p "Build frontend assets dengan npm? (y/n): " -n 1 -r
echo ""
if [[ $REPLY =~ ^[Yy]$ ]]
then
    npm run build
    if [ $? -eq 0 ]; then
        echo -e "${GREEN}✅ Assets built successfully!${NC}"
    else
        echo -e "${RED}❌ Build failed!${NC}"
    fi
else
    echo -e "${YELLOW}⏭️  Build dilewati.${NC}"
fi
echo ""

# Step 8: Run Tests
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
echo "🧪 Step 7: Running Tests..."
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
read -p "Jalankan automated tests? (y/n): " -n 1 -r
echo ""
if [[ $REPLY =~ ^[Yy]$ ]]
then
    php artisan test
else
    echo -e "${YELLOW}⏭️  Tests dilewati.${NC}"
fi
echo ""

# Final Message
echo "╔════════════════════════════════════════════════════════════╗"
echo "║                                                            ║"
echo "║    ✅ DEPLOYMENT SELESAI!                                 ║"
echo "║                                                            ║"
echo "╚════════════════════════════════════════════════════════════╝"
echo ""
echo -e "${GREEN}🎉 Semua langkah deployment telah selesai!${NC}"
echo ""
echo "📋 TESTING CHECKLIST:"
echo "  □ Coba register dengan upload dokumen"
echo "  □ Check admin panel - lihat 'Denda & Sanksi'"
echo "  □ Buat buku baru dengan Google Drive link"
echo "  □ Kunjungi /help untuk Help Center"
echo "  □ Verify 100 buku ada di database (jika run seeder)"
echo ""
echo "📚 DOKUMENTASI:"
echo "  → QUICK_REFERENCE.md          (Referensi cepat)"
echo "  → IMPLEMENTATION_SUMMARY.md   (Ringkasan lengkap)"
echo "  → ATURAN_PERPUSTAKAAN.md      (Aturan user)"
echo ""
echo -e "${YELLOW}⚠️  Jangan lupa test semua fitur sebelum production!${NC}"
echo ""
