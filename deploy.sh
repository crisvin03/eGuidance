#!/bin/bash

# eGuidance Portal - Quick Deployment Script
echo "🚀 eGuidance Portal - Quick Deployment Setup"
echo "=========================================="

# Check if we're in the right directory
if [ ! -f "artisan" ]; then
    echo "❌ Error: Please run this script from the Laravel project root"
    exit 1
fi

echo "✅ Found Laravel project"

# Generate app key
echo "🔑 Generating Laravel app key..."
APP_KEY=$(php artisan key:generate --show)
echo "✅ App key generated: $APP_KEY"

# Show database setup instructions
echo ""
echo "📊 Database Setup Instructions:"
echo "=============================="
echo "1. Choose a database provider:"
echo "   - PlanetScale (Recommended): https://planetscale.com"
echo "   - Railway: https://railway.app"
echo "   - Supabase: https://supabase.com"
echo ""
echo "2. Create a database named 'eguidance_portal'"
echo "3. Get your connection details"
echo ""

# Show Vercel setup instructions
echo "🌐 Vercel Setup Instructions:"
echo "=============================="
echo "1. Go to https://vercel.com"
echo "2. Import your GitHub repository: crisvin03/eGuidance"
echo "3. Add these environment variables:"
echo ""
echo "   APP_ENV=production"
echo "   APP_DEBUG=false"
echo "   APP_URL=https://your-app-name.vercel.app"
echo "   APP_KEY=$APP_KEY"
echo "   DB_CONNECTION=mysql"
echo "   DB_HOST=your-database-host"
echo "   DB_PORT=3306"
echo "   DB_DATABASE=eguidance_portal"
echo "   DB_USERNAME=your-database-username"
echo "   DB_PASSWORD=your-database-password"
echo "   CACHE_DRIVER=array"
echo "   SESSION_DRIVER=cookie"
echo "   QUEUE_CONNECTION=sync"
echo ""

# Show post-deployment steps
echo "🛠️ Post-Deployment Steps:"
echo "=========================="
echo "1. Deploy to Vercel"
echo "2. Run database migrations"
echo "3. Test all features"
echo "4. Set up custom domain (optional)"
echo ""

echo "📚 For detailed instructions, see: DEPLOYMENT_GUIDE.md"
echo ""
echo "🎉 Ready to deploy! Good luck!"
