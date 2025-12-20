#!/bin/bash
set -e

# Create SQLite database file if it doesn't exist
if [ ! -f database/database.sqlite ]; then
    echo "Creating SQLite database..."
    touch database/database.sqlite
fi

# Install PHP dependencies
if [ ! -d vendor ]; then
    echo "Installing Composer dependencies..."
    composer install --no-dev --optimize-autoloader
fi

# Install Node dependencies
if [ ! -d node_modules ]; then
    echo "Installing Node dependencies..."
    npm install
fi

# Build frontend assets
echo "Building frontend assets..."
npm run build

# Run migrations
echo "Running migrations..."
php artisan migrate --force

# Optimize Laravel
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Start the server
echo "Starting Laravel server..."
exec php artisan serve --host=0.0.0.0 --port=8000
