#!/bin/bash
set -e

# Replace PORT in nginx config
echo "Configuring Nginx to listen on port ${PORT:-80}..."
envsubst '$PORT' < /etc/nginx/sites-available/default > /tmp/nginx.conf
cp /tmp/nginx.conf /etc/nginx/sites-available/default

# Generate app key if not set
if [ -z "$APP_KEY" ]; then
    echo "Generating app key..."
    php artisan key:generate --no-interaction --force
fi

# Clear and cache config for production
echo "Caching configuration..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Run migrations (with a retry in case DB is slow to start)
echo "Running migrations..."
php artisan migrate --force || (echo "Migration failed, retrying in 5s..." && sleep 5 && php artisan migrate --force)

# Run seeders
echo "Running seeders..."
php artisan db:seed --force || echo "Seeding failed or already seeded."

# Create storage symlink
php artisan storage:link --force 2>/dev/null || true

# Fix permissions
chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache
chmod -R 775 /var/www/storage /var/www/bootstrap/cache

# Start PHP-FPM in background
echo "Starting PHP-FPM..."
php-fpm -D

# Start Nginx in foreground
echo "Starting Nginx..."
nginx -g "daemon off;"
