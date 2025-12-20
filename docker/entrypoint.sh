#!/bin/bash
set -e

# Copy .env if not exists
if [ ! -f .env ]; then
    echo "Creating .env file..."
    cp .env.example .env
fi

# Ensure SQLite is set in .env
# This simple replacement works if keys exist. ideally we use a specialized tool or check.
# But for this user, we can force it or just ensure it's correct manually or assume .env.example allows it.
# Let's try to sed/replace to ensure sqlite usage if it's the default Docker setup.
if grep -q "DB_CONNECTION=mysql" .env; then
    sed -i 's/DB_CONNECTION=mysql/DB_CONNECTION=sqlite/g' .env
    # Comment out other DB vars to avoid confusion, or set them to empty
    sed -i 's/DB_HOST=127.0.0.1/# DB_HOST=127.0.0.1/g' .env
    sed -i 's/DB_PORT=3306/# DB_PORT=3306/g' .env
    sed -i 's/DB_DATABASE=laravel/# DB_DATABASE=laravel/g' .env
    sed -i 's/DB_USERNAME=root/# DB_USERNAME=root/g' .env
    sed -i 's/DB_PASSWORD=/# DB_PASSWORD=/g' .env
fi

# Create SQLite database file if it doesn't exist
if [ ! -f database/database.sqlite ]; then
    echo "Creating SQLite database..."
    touch database/database.sqlite
fi

# Install PHP dependencies
if [ ! -d vendor ]; then
    echo "Installing Composer dependencies..."
    composer install
fi

# Install Node dependencies
if [ ! -d node_modules ]; then
    echo "Installing Node dependencies..."
    npm install
fi

# Generate key
php artisan key:generate

# Run migrations
echo "Running migrations..."
php artisan migrate --force

# Start the server
echo "Starting Laravel server..."
exec php artisan serve --host=0.0.0.0 --port=8000
