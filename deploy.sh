#!/bin/bash

echo "🚀 Starting deployment..."

# Pull latest changes
echo "� Pulling latest changes from GitHub..."
git pull origin master

# Install/Update dependencies
echo "📦 Installing Composer dependencies..."
composer install --no-dev --optimize-autoloader

# Clear all caches
echo "🧹 Clearing caches..."
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Run migrations
echo "🗄️ Running database migrations..."
php artisan migrate --force

# Create storage link if not exists
echo "🔗 Creating storage link..."
php artisan storage:link

# Optimize for production
echo "⚡ Optimizing application..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Fix permissions
echo "� Setting permissions..."
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache

echo "✅ Deployment completed successfully!"
