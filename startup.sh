#!/bin/bash

echo "=== Starting startup.sh ==="

# Copy nginx config ke lokasi yang dibaca Azure
cp /home/site/wwwroot/nginx.conf /etc/nginx/sites-available/default

# Pastikan storage & cache Laravel bisa ditulis
cd /home/site/wwwroot
mkdir -p storage/framework/sessions
mkdir -p storage/framework/views
mkdir -p storage/framework/cache
chmod -R 775 storage bootstrap/cache

# Generate app key jika belum ada (opsional tapi aman)
php artisan config:cache
php artisan route:cache

# Restart nginx
service nginx restart

echo "=== startup.sh Done ==="
