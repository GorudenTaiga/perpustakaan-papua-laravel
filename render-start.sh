#!/usr/bin/env bash
# Render.com Start Script for Laravel

set -o errexit

echo "Starting Laravel application..."

# Warm up caches before handling traffic
echo "Warming up caches..."
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize

# Start PHP built-in server
php artisan serve --host=0.0.0.0 --port=${PORT:-8080}
