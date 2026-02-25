# 🚀 eGuidance Portal - Complete Vercel Deployment Guide

This guide will walk you through deploying the eGuidance Portal on Vercel with a production-ready setup.

## 📋 Table of Contents

1. [Prerequisites](#prerequisites)
2. [Database Setup](#database-setup)
3. [Environment Configuration](#environment-configuration)
4. [Vercel Deployment](#vercel-deployment)
5. [Post-Deployment Setup](#post-deployment-setup)
6. [Troubleshooting](#troubleshooting)

## 🔧 Prerequisites

### Required Accounts:
- [GitHub Account](https://github.com) (Already have)
- [Vercel Account](https://vercel.com)
- [Database Provider Account] (Choose one below)

### Database Options (Free Tiers Only):

#### Option A: PlanetScale (Recommended) 🌟
- [Sign up](https://planetscale.com)
- **Free tier includes:**
  - 5GB storage
  - 1 billion row reads/month
  - 10 million writes/month
  - Perfect for Laravel apps
- MySQL-compatible

#### Option B: Supabase �
- [Sign up](https://supabase.com)
- **Free tier includes:**
  - 500MB database storage
  - 2GB bandwidth
  - 50k monthly active users
  - PostgreSQL database
  - **Note:** Requires minor code changes for PostgreSQL

#### Option C: Railway �
- [Sign up](https://railway.app)
- **Free tier includes:**
  - $5 credit/month (resets monthly)
  - MySQL database
  - Simple setup
  - Good for small projects

## 🗄️ Database Setup

### Using PlanetScale:

1. **Create Database:**
   ```
   - Login to PlanetScale
   - Click "New Database"
   - Name: `eguidance_portal`
   - Region: Choose closest to your users
   - Click "Create database"
   ```

2. **Get Connection Details:**
   ```
   - Go to your database dashboard
   - Click "Connect"
   - Select "@vercel/php"
   - Copy the connection strings
   ```

3. **Create Branch:**
   ```
   - Create a new branch called "main"
   - This will be your production branch
   ```

### Using Railway:

1. **Create Database:**
   ```
   - Login to Railway
   - Click "New Project"
   - Click "Provision MySQL"
   - Name: `eguidance_portal`
   - Click "Add MySQL"
   ```

2. **Get Connection Details:**
   ```
   - Click on your MySQL service
   - Go to "Connect" tab
   - Copy the connection details
   ```

## ⚙️ Environment Configuration

### 1. Generate Laravel App Key:
```bash
cd "c:\Users\ACER\Crisvin\Bulan high Project\eGuidance Portal"
php artisan key:generate --show
```
**Copy this key - you'll need it for Vercel**

### 2. Prepare Environment Variables:

Create a list of these variables with your values:

```
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-app-name.vercel.app
APP_KEY=base64:YOUR_GENERATED_KEY_HERE

DB_CONNECTION=mysql
DB_HOST=your-database-host
DB_PORT=3306
DB_DATABASE=eguidance_portal
DB_USERNAME=your-database-username
DB_PASSWORD=your-database-password

CACHE_DRIVER=array
SESSION_DRIVER=cookie
QUEUE_CONNECTION=sync
```

### 3. Database Migration Setup:

Since Vercel is serverless, you'll need to run migrations manually. Create a migration script:

```bash
# Create a temporary migration file
php artisan make:migration setup_production_database
```

Add this to the migration file:
```php
public function up()
{
    // Run all migrations
    Artisan::call('migrate', ['--force' => true]);
    
    // Seed the database
    Artisan::call('db:seed', ['--force' => true]);
}
```

## 🚀 Vercel Deployment

### Step 1: Connect Vercel to GitHub

1. **Go to [Vercel](https://vercel.com)**
2. **Sign up with GitHub**
3. **Click "Add New..." → "Project"**

### Step 2: Import Your Repository

1. **Search for `crisvin03/eGuidance`**
2. **Click "Import"**
3. **Configure Project Settings:**

```
Project Name: eguidance-portal
Framework Preset: Other
Root Directory: ./
Build Command: (leave empty)
Output Directory: public
Install Command: (leave empty)
```

### Step 3: Add Environment Variables

In the Vercel project settings, add all environment variables from Step 2:

1. **Go to "Settings" → "Environment Variables"**
2. **Add each variable:**
   - Click "Add New"
   - Enter Name and Value
   - Select "Production", "Preview", "Development"
   - Click "Save"

**Important:** Make sure `APP_KEY` is correctly set!

### Step 4: Deploy

1. **Click "Deploy"**
2. **Wait for deployment to complete**
3. **Visit your deployed URL**

### Step 5: Run Database Migrations (Free Options)

Since Vercel is serverless, you'll need to run migrations manually. Choose one of these free options:

#### Option A: PlanetScale CLI (Recommended & Free)
```bash
# Install PlanetScale CLI (Windows)
iwr https://github.com/planetscale/cli/releases/latest/download/pscale_windows_amd64.zip -o pscale.zip
Expand-Archive pscale.zip
# Add to PATH or run from extracted folder

# Connect to your database
pscale shell eguidance_portal main

# Run migrations (you'll need to copy migration SQL)
```

#### Option B: Railway CLI (Free)
```bash
# Install Railway CLI
npm install -g @railway/cli

# Login and connect
railway login
railway link

# Run migrations via Railway shell
railway shell php artisan migrate --force
railway shell php artisan db:seed --force
```

#### Option C: Local Setup (Free)
```bash
# Temporarily update your local .env with production database values
# Run migrations locally pointing to production database
php artisan migrate --force
php artisan db:seed --force
```

## 🛠️ Post-Deployment Setup

### 1. Test Your Application

Visit your deployed site and test:
- ✅ Landing page loads
- ✅ Login works with test credentials
- ✅ Student can submit concerns
- ✅ Counselor can respond to concerns
- ✅ Admin dashboard works

### 2. File Upload Configuration (Free Options)

For file uploads to work, you'll need free cloud storage:

#### Option A: Cloudinary (Free Tier - Recommended)
```bash
composer require cloudinary-labs/cloudinary-laravel
```

Add to `.env` (get from Cloudinary free account):
```
CLOUDINARY_URL=cloudinary://your_api_key:your_api_secret@your_cloud_name
```

**Free tier includes:**
- 25 credits/month (resets monthly)
- 25GB storage
- 25GB bandwidth

#### Option B: ImgBB API (Free)
- [Sign up](https://api.imgbb.com/)
- **Free tier:** No limit on uploads
- Simple API integration
- Good for profile pictures and documents

#### Option C: GitHub as Storage (Free & Simple)
- Use GitHub repository for file storage
- Limited to 100MB per file
- Good for small documents and images

### 3. Email Configuration (Free Options)

For password resets and notifications:

#### Option A: Gmail (Free)
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your_email@gmail.com
MAIL_PASSWORD=your_app_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your_email@gmail.com
MAIL_FROM_NAME="eGuidance Portal"
```

**Setup:**
1. Enable 2-factor authentication on Gmail
2. Generate App Password: https://myaccount.google.com/apppasswords
3. Use App Password (not your regular password)

#### Option B: SendGrid (Free Tier)
```env
MAIL_MAILER=sendgrid
SENDGRID_API_KEY=your_sendgrid_api_key
MAIL_FROM_ADDRESS=your_email@example.com
MAIL_FROM_NAME="eGuidance Portal"
```

**Free tier includes:**
- 100 emails/day forever
- No credit card required

#### Option C: Mailtrap (Free Testing)
```env
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_mailtrap_username
MAIL_PASSWORD=your_mailtrap_password
MAIL_ENCRYPTION=tls
```

**Free tier includes:**
- 50 emails/month
- Perfect for testing
- Emails don't actually send (sandbox mode)

### 4. Custom Domain (Optional)

1. **Go to Vercel Project Settings**
2. **Click "Domains"**
3. **Add your custom domain**
4. **Update DNS records as instructed**

### 5. SSL Certificate

Vercel automatically provides SSL certificates for all deployments.

## 🔍 Troubleshooting

### Common Issues:

#### 1. "500 Internal Server Error"
- **Check:** Environment variables are correctly set
- **Check:** `APP_KEY` is properly generated
- **Check:** Database connection details

#### 2. "Database Connection Failed"
- **Check:** Database credentials
- **Check:** Database is accessible from Vercel
- **Check:** SSL certificates for database

#### 3. "Assets Not Loading"
- **Check:** `APP_URL` is set correctly
- **Check:** Asset URLs in your code

#### 4. "Session Not Working"
- **Check:** `SESSION_DRIVER=cookie`
- **Check:** Cookie settings in Vercel

### Debug Mode:

Temporarily enable debug mode:
```env
APP_DEBUG=true
```
**Remember to set back to `false` in production!**

### Vercel Logs:

1. **Go to your Vercel project**
2. **Click "Functions" tab**
3. **View logs for debugging**

## 📊 Monitoring and Analytics (Free Options)

### Vercel Analytics (Free)
1. **Go to "Analytics" tab**
2. **Enable analytics**
3. **Free tier includes:**
   - Page views and visitors
   - Web Vitals
   - Top pages and referrers
   - Geographic data

### Error Tracking (Free Options)

#### Option A: Sentry (Free Tier)
```bash
composer require sentry/sentry-laravel
```

**Free tier includes:**
- 5,000 errors/month
- Performance monitoring
- Issue tracking
- Release tracking

#### Option B: Bugsnag (Free Tier)
```bash
composer require bugsnag/bugsnag-laravel
```

**Free tier includes:**
- 2,000 errors/month
- Real-time error monitoring
- Basic performance data

#### Option C: Rollbar (Free Tier)
```bash
composer require rollbar/rollbar-laravel
```

**Free tier includes:**
- 5,000 errors/month
- Basic error tracking
- Team collaboration

## 🔄 CI/CD Pipeline

Vercel automatically:
- **Deploys on every push to main branch**
- **Creates preview URLs for pull requests**
- **Rolls back on failures**

## 📱 Mobile Optimization

Your app is already responsive, but test on:
- ✅ Mobile browsers
- ✅ Tablet devices
- ✅ Different screen sizes

## 🔐 Security Considerations

### Production Security:
- ✅ `APP_DEBUG=false`
- ✅ HTTPS enabled
- ✅ Environment variables secured
- ✅ Database connections encrypted
- ✅ Input validation active

### Additional Security:
- Consider adding rate limiting
- Implement CSRF protection (already included)
- Use HTTPS for all API calls

## 💡 Performance Optimization

### Vercel Optimizations:
- ✅ Edge caching
- ✅ Automatic compression
- ✅ CDN distribution

### Laravel Optimizations:
```bash
# Optimize for production
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## 📞 Support

### Getting Help:
1. **Vercel Documentation:** https://vercel.com/docs
2. **Laravel Documentation:** https://laravel.com/docs
3. **Database Provider Docs:** PlanetScale/Railway support

### Common Resources:
- [Laravel on Vercel Guide](https://vercel.com/guides/deploying-laravel)
- [PlanetScale Laravel Integration](https://planetscale.com/docs/concepts/laravel-integration)
- [Vercel Community Forums](https://vercel.com/discuss)

## 🎉 You're Live!

Once deployed, your eGuidance Portal will be available at:
- **Primary URL:** `https://eguidance-portal.vercel.app`
- **Custom Domain:** (if configured)

### Next Steps:
1. **Share with users**
2. **Monitor performance**
3. **Collect feedback**
4. **Plan future enhancements**

---

## 📝 Quick Checklist

- [ ] Database created and configured
- [ ] Environment variables set in Vercel
- [ ] App key generated and added
- [ ] Database migrations run
- [ ] Application deployed to Vercel
- [ ] All features tested
- [ ] Custom domain configured (optional)
- [ ] Monitoring set up (optional)
- [ ] Documentation updated

**🎊 Congratulations! Your eGuidance Portal is now live on Vercel!**

---

*For issues or questions, refer to the troubleshooting section or create an issue in your GitHub repository.*
