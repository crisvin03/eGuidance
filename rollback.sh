#!/bin/bash

echo "⏪ Rolling back migrations..."

# Rollback last batch of migrations
php artisan migrate:rollback

echo ""
echo "📋 Current migration status:"
php artisan migrate:status

echo ""
echo "⚠️ To re-run migrations, use: php artisan migrate"
