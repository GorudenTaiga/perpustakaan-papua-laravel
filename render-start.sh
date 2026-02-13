#!/usr/bin/env bash
# Render.com Start Script for Laravel

set -o errexit

echo "Starting Laravel application..."

# Start PHP built-in server
php artisan serve --host=0.0.0.0 --port=${PORT:-8080}
