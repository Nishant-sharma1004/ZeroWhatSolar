# Zero What Solar - Vercel Deployment Guide

## 🚀 Complete Vercel Deployment Instructions

### Important Note
Vercel is primarily designed for static sites and serverless functions. For a PHP-based CMS like Zero What Solar, **Hostinger is the recommended choice**. However, this guide provides an alternative approach using Vercel + external database.

### Prerequisites
- Vercel account (free tier available)
- GitHub repository for your code
- External MySQL database (PlanetScale, Railway, or similar)
- Domain name (optional)

## Option 1: Hybrid Deployment (Recommended for Vercel)

### Step 1: Database Setup (External)

**Option A: PlanetScale (Recommended)**
1. Create account at [planetscale.com](https://planetscale.com)
2. Create new database: `zerowhat-solar`
3. Import schema from `database/schema.sql`
4. Get connection string

**Option B: Railway**
1. Create account at [railway.app](https://railway.app)
2. Deploy MySQL database
3. Import schema
4. Get connection credentials

### Step 2: Prepare Repository

1. **Push to GitHub**:
   ```bash
   git init
   git add .
   git commit -m "Initial commit"
   git remote add origin https://github.com/yourusername/zerowhat-solar
   git push -u origin main
   ```

2. **Update database config** in `config/database.php`:
   ```php
   define('DB_HOST', getenv('DB_HOST') ?: 'localhost');
   define('DB_NAME', getenv('DB_NAME') ?: 'zerowhat_solar_cms');
   define('DB_USER', getenv('DB_USER') ?: 'root');
   define('DB_PASS', getenv('DB_PASS') ?: '');
   ```

### Step 3: Vercel Deployment

1. **Connect to Vercel**:
   - Visit [vercel.com](https://vercel.com)
   - Import your GitHub repository
   - Select "Other" framework

2. **Configure Environment Variables**:
   ```
   DB_HOST=your-database-host
   DB_NAME=zerowhat_solar_cms
   DB_USER=your-username
   DB_PASS=your-password
   SITE_URL=https://zerowhatsolar.vercel.app
   ```

3. **Deploy**: Click "Deploy" button

### Step 4: Custom Domain (Optional)

1. **Add domain** in Vercel dashboard
2. **Configure DNS**:
   - Type: CNAME
   - Name: @ (or www)
   - Value: cname.vercel-dns.com

## Option 2: Static + API Approach

If you want to go fully serverless, convert the site to static HTML + JavaScript with API endpoints:

### Step 1: Convert to Static Frontend

1. **Create `public/index.html`**:
   ```html
   <!DOCTYPE html>
   <html lang="en">
   <head>
       <meta charset="UTF-8">
       <title>Zero What Solar - Best Solar Panel Installation in Jaipur</title>
       <!-- Add your CSS and meta tags -->
   </head>
   <body>
       <!-- Convert PHP templates to static HTML -->
       <!-- Use JavaScript for dynamic content -->
   </body>
   </html>
   ```

2. **API Endpoints**: Use the provided `/api/` files
3. **JavaScript Integration**: Replace PHP includes with fetch calls

### Step 5: Vercel Configuration

Your `vercel.json` is already configured for PHP serverless functions.

### Step 6: Testing

1. **Local testing**:
   ```bash
   npm install -g vercel
   vercel dev
   ```

2. **Production testing**:
   - Check all forms work
   - Verify database connections
   - Test contact submissions

## Limitations of Vercel for PHP CMS

❌ **No persistent file storage**
❌ **Limited PHP extensions**
❌ **10-second function timeout**
❌ **No server-side sessions**
❌ **Complex admin panel hosting**

## Why Hostinger is Better for This Project

✅ **Full PHP support with extensions**
✅ **Persistent MySQL database**
✅ **File upload and storage**
✅ **Server-side sessions**
✅ **Traditional hosting model**
✅ **Better for CMS functionality**
✅ **More cost-effective for dynamic sites**

## Alternative Vercel-Friendly Approach

If you're set on using Vercel, consider:

1. **Frontend**: Static HTML/CSS/JS on Vercel
2. **Backend**: API routes on Vercel serverless functions
3. **Database**: External (PlanetScale, Supabase)
4. **Admin**: Separate admin dashboard on different platform
5. **File Storage**: Cloudinary or AWS S3

## Recommended Migration Strategy

```
Current PHP Site
       ↓
   Static HTML + JavaScript (Frontend)
       ↓
   Vercel Serverless Functions (API)
       ↓
   External Database (PlanetScale)
       ↓
   CDN for Assets (Vercel)
```

## Cost Comparison

| Platform | Cost | Best For |
|----------|------|----------|
| **Hostinger** | $2-10/month | Full PHP CMS |
| **Vercel** | $0-20/month | Static + API |
| **Traditional VPS** | $5-50/month | Full control |

## Final Recommendation

🎯 **For Zero What Solar: Use Hostinger**

Reasons:
- Mature PHP CMS with admin panel
- File uploads and image management
- Traditional hosting is more suitable
- Better performance for dynamic content
- Lower complexity and maintenance

---

## Quick Vercel Setup (If you proceed)

1. Push code to GitHub
2. Import to Vercel
3. Add environment variables
4. Configure external database
5. Test API endpoints

**Live URLs**:
- Main site: `https://zerowhatsolar.vercel.app`
- API: `https://zerowhatsolar.vercel.app/api/contact`

---

**Need help choosing?** Contact me for personalized deployment assistance! 🚀