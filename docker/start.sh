#!/bin/bash
set -e

# Generate app key if not set
php artisan key:generate --no-interaction --force 2>/dev/null || true

# Clear and cache config for production
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Run migrations (with a retry in case DB is slow to start)
echo "Running migrations..."
php artisan migrate --force

# Create storage symlink
php artisan storage:link 2>/dev/null || true

# Fix permissions
chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache
chmod -R 775 /var/www/storage /var/www/bootstrap/cache

# Start PHP-FPM in background
php-fpm -D

# Start Nginx in foreground
nginx -g "daemon off;"
