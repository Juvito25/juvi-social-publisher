#!/bin/sh
set -e

echo "Installing PHP dependencies..."
composer install --no-interaction --prefer-dist --optimize-autoloader

echo "Generating application key..."
php artisan key:generate

echo "Running migrations..."
php artisan migrate --force

echo "Building assets..."
npm install
npm run build

echo "Starting PHP server..."
php artisan serve --host=0.0.0.0 --port=8000
