#!/bin/bash

echo "🔍 eGuidance Portal Troubleshooting"
echo "==================================="

# Check PHP version
echo ""
echo "📌 PHP Version:"
php -v | head -n 1

# Check Laravel version
echo ""
echo "📌 Laravel Version:"
php artisan --version

# Check database connection
echo ""
echo "📌 Database Connection:"
php artisan migrate:status

# Check permissions
echo ""
echo "📌 Storage Permissions:"
ls -la storage/

# Check last 20 lines of log
echo ""
echo "📌 Recent Errors (last 20 lines):"
tail -n 20 storage/logs/laravel.log 2>/dev/null || echo "No log file found"

# Check if tables exist
echo ""
echo "📌 Checking if new tables exist:"
php artisan tinker --execute="echo DB::table('resources')->count() . ' resources';"
php artisan tinker --execute="echo DB::table('student_submissions')->count() . ' submissions';"

echo ""
echo "✅ Troubleshooting complete!"
