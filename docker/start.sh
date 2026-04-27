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

# Ensure storage directories exist
mkdir -p storage/app/public/products storage/app/public/brands

# Ensure APP_URL is set correctly for Railway
if [ -n "$RAILWAY_PUBLIC_DOMAIN" ] && [[ "$APP_URL" == *"localhost"* || -z "$APP_URL" ]]; then
    export APP_URL="https://$RAILWAY_PUBLIC_DOMAIN"
    echo "Auto-set APP_URL to $APP_URL"
fi

# Run migrations with retry
echo "Running migrations..."
for i in {1..5}; do
    php artisan migrate --force && break || {
        echo "Migration failed, retrying in 5s... ($i/5)"
        sleep 5
    }
done

# Run seeders (idempotent)
echo "Running seeders..."
php artisan db:seed --force

# Force recreate storage symlink to ensure it's correct for Linux
echo "Rebuilding storage symlink..."
rm -rf public/storage
php artisan storage:link --force

# Set permissions
echo "Setting permissions..."
chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache
chmod -R 775 /var/www/storage /var/www/bootstrap/cache

# Start PHP-FPM in background
echo "Starting PHP-FPM..."
php-fpm -D

# Start Nginx in foreground
echo "Starting Nginx..."
nginx -g "daemon off;"
