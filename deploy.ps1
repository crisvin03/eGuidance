# eGuidance Portal - Quick Deployment Script (PowerShell)
Write-Host "🚀 eGuidance Portal - Quick Deployment Setup" -ForegroundColor Green
Write-Host "==========================================" -ForegroundColor Green

# Check if we're in the right directory
if (-not (Test-Path "artisan")) {
    Write-Host "❌ Error: Please run this script from the Laravel project root" -ForegroundColor Red
    exit 1
}

Write-Host "✅ Found Laravel project" -ForegroundColor Green

# Generate app key
Write-Host "🔑 Generating Laravel app key..." -ForegroundColor Yellow
$AppKey = php artisan key:generate --show
Write-Host "✅ App key generated: $AppKey" -ForegroundColor Green

# Show database setup instructions
Write-Host ""
Write-Host "📊 Free Database Options:" -ForegroundColor Cyan
Write-Host "========================" -ForegroundColor Cyan
Write-Host "Choose ONE of these FREE options:" -ForegroundColor White
Write-Host ""
Write-Host "1. PlanetScale (Recommended):" -ForegroundColor Green
Write-Host "   - 5GB storage, 1B reads/month, 10M writes/month" -ForegroundColor Gray
Write-Host "   - https://planetscale.com" -ForegroundColor Gray
Write-Host ""
Write-Host "2. Supabase:" -ForegroundColor Green
Write-Host "   - 500MB storage, 2GB bandwidth, 50k users/month" -ForegroundColor Gray
Write-Host "   - https://supabase.com" -ForegroundColor Gray
Write-Host "   - Note: Requires PostgreSQL changes" -ForegroundColor Yellow
Write-Host ""
Write-Host "3. Railway:" -ForegroundColor Green
Write-Host "   - $5 credit/month (resets)" -ForegroundColor Gray
Write-Host "   - https://railway.app" -ForegroundColor Gray
Write-Host ""
Write-Host "Create database named 'eguidance_portal' and get connection details" -ForegroundColor White
Write-Host ""

# Show Vercel setup instructions
Write-Host "🌐 Vercel Setup Instructions:" -ForegroundColor Cyan
Write-Host "==============================" -ForegroundColor Cyan
Write-Host "1. Go to https://vercel.com" -ForegroundColor White
Write-Host "2. Import your GitHub repository: crisvin03/eGuidance" -ForegroundColor White
Write-Host "3. Add these environment variables:" -ForegroundColor White
Write-Host ""
Write-Host "   APP_ENV=production" -ForegroundColor Yellow
Write-Host "   APP_DEBUG=false" -ForegroundColor Yellow
Write-Host "   APP_URL=https://your-app-name.vercel.app" -ForegroundColor Yellow
Write-Host "   APP_KEY=$AppKey" -ForegroundColor Yellow
Write-Host "   DB_CONNECTION=mysql" -ForegroundColor Yellow
Write-Host "   DB_HOST=your-database-host" -ForegroundColor Yellow
Write-Host "   DB_PORT=3306" -ForegroundColor Yellow
Write-Host "   DB_DATABASE=eguidance_portal" -ForegroundColor Yellow
Write-Host "   DB_USERNAME=your-database-username" -ForegroundColor Yellow
Write-Host "   DB_PASSWORD=your-database-password" -ForegroundColor Yellow
Write-Host "   CACHE_DRIVER=array" -ForegroundColor Yellow
Write-Host "   SESSION_DRIVER=cookie" -ForegroundColor Yellow
Write-Host "   QUEUE_CONNECTION=sync" -ForegroundColor Yellow
Write-Host ""

# Show post-deployment steps
Write-Host "🛠️ Post-Deployment Steps:" -ForegroundColor Cyan
Write-Host "==========================" -ForegroundColor Cyan
Write-Host "1. Deploy to Vercel" -ForegroundColor White
Write-Host "2. Run database migrations" -ForegroundColor White
Write-Host "3. Test all features" -ForegroundColor White
Write-Host "4. Set up custom domain (optional)" -ForegroundColor White
Write-Host ""

Write-Host "📚 For detailed instructions, see: DEPLOYMENT_GUIDE.md" -ForegroundColor Magenta
Write-Host ""
Write-Host "🎉 Ready to deploy! Good luck!" -ForegroundColor Green

# Keep window open
Read-Host "Press Enter to exit"
