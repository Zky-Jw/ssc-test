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

# Pastikan CIPHERSWEET_KEY ada di .env jika belum
grep -q "CIPHERSWEET_KEY" /home/site/wwwroot/.env || echo "CIPHERSWEET_KEY=02d327465b3aac8f18638c96ae14b416d1fc38de315c06fa86edd9c86af8d62f" >> /home/site/wwwroot/.env

# Cache config Laravel
php artisan config:cache
php artisan route:cache

# Restart nginx
service nginx restart

echo "=== startup.sh Done ==="
