#!/usr/bin/env bash
# Render.com Build Script for Laravel

set -o errexit

echo "Installing Composer dependencies..."
composer install --no-dev --optimize-autoloader --no-interaction --prefer-dist

echo "Installing NPM dependencies..."
npm ci

echo "Building frontend assets..."
npm run build

echo "Creating SQLite database..."
mkdir -p database
touch database/database.sqlite

echo "Running migrations..."
php artisan migrate --force --no-interaction

echo "Optimizing Laravel..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "Build completed successfully!"
