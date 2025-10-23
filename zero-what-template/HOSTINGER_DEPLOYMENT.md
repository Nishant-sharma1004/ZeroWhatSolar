# Zero What Solar - Hostinger Deployment Guide

## 🚀 Complete Hostinger Deployment Instructions

### Prerequisites
- Hostinger account with PHP hosting plan
- Domain name (e.g., zerowhatsolar.in)
- FTP/SFTP access credentials from Hostinger

### Step 1: Prepare Your Files

1. **Download all project files** to your local computer
2. **Replace database configuration**:
   - Rename `config/database.production.php` to `config/database.php`
   - Update database credentials with your Hostinger details

### Step 2: Database Setup

1. **Login to Hostinger hPanel**
2. **Create MySQL Database**:
   - Go to "Databases" → "MySQL Databases"
   - Create database: `u123456789_zerowhat` (replace with your prefix)
   - Create user: `u123456789_admin`
   - Set a strong password
   - Assign user to database with ALL PRIVILEGES

3. **Import Database Schema**:
   - Go to "Databases" → "phpMyAdmin"
   - Select your database
   - Click "Import" tab
   - Upload `database/schema.sql`
   - Click "Go" to execute

### Step 3: Update Configuration

Open `config/database.php` and update:

```php
define('DB_HOST', 'localhost');
define('DB_NAME', 'u123456789_zerowhat'); // Your actual database name
define('DB_USER', 'u123456789_admin');     // Your database username
define('DB_PASS', 'YourSecurePassword');   // Your database password
define('SITE_URL', 'https://zerowhatsolar.in'); // Your domain
```

### Step 4: Upload Files via File Manager

1. **Login to Hostinger hPanel**
2. **Go to File Manager**
3. **Navigate to public_html folder**
4. **Upload all project files** (except local config files)
5. **Set proper permissions**:
   - Folders: 755
   - PHP files: 644
   - .htaccess: 644

### Step 5: SSL Certificate Setup

1. **In hPanel, go to SSL**
2. **Enable "Free SSL Certificate"**
3. **Force HTTPS redirect** (if not automatic)

### Step 6: Email Configuration

1. **Create professional email**: noreply@zerowhatsolar.in
2. **Update email settings** in database.php:
   ```php
   define('SMTP_HOST', 'smtp.hostinger.com');
   define('SMTP_USERNAME', 'noreply@zerowhatsolar.in');
   define('SMTP_PASSWORD', 'YourEmailPassword');
   ```

### Step 7: Admin Panel Setup

1. **Visit**: https://zerowhatsolar.in/setup_admin.php
2. **Create admin account**
3. **Delete setup_admin.php** after completion
4. **Login**: https://zerowhatsolar.in/admin/

### Step 8: Performance Optimization

1. **Enable Cloudflare** (free plan available):
   - Add your domain to Cloudflare
   - Update nameservers in domain registrar
   - Enable caching and minification

2. **Optimize images**:
   - Use WebP format when possible
   - Compress images before upload

### Step 9: SEO & Analytics

1. **Google Search Console**:
   - Add and verify your domain
   - Submit sitemap.xml

2. **Google Analytics**:
   - Create account and get tracking ID
   - Add tracking code to all pages

### Step 10: Testing Checklist

- [ ] Homepage loads correctly
- [ ] Contact form submissions work
- [ ] Solar calculator functions properly
- [ ] Admin panel accessible
- [ ] All images display correctly
- [ ] Mobile responsiveness works
- [ ] SSL certificate active
- [ ] Email notifications working

### Important Security Notes

1. **Change default admin credentials**
2. **Regularly update passwords**
3. **Keep PHP version updated**
4. **Monitor error logs** in hPanel
5. **Backup database weekly**

### Support Contacts

- **Hostinger Support**: Available 24/7 via live chat
- **Technical Issues**: Check error logs in hPanel → "Error Logs"

### Common Hostinger Issues & Solutions

1. **Database Connection Failed**:
   - Verify database credentials
   - Check if database user has correct permissions

2. **500 Internal Server Error**:
   - Check .htaccess file syntax
   - Review PHP error logs

3. **Email Not Sending**:
   - Verify SMTP credentials
   - Check spam folder
   - Use Hostinger's SMTP server

4. **Images Not Loading**:
   - Check file permissions (644 for files, 755 for folders)
   - Verify file paths in code

### Hostinger-Specific Advantages

✅ **Free SSL Certificate**
✅ **Free Domain (some plans)**
✅ **Free CDN with Business plans**
✅ **24/7 Support**
✅ **99.9% Uptime Guarantee**
✅ **Daily Backups**
✅ **WordPress-optimized servers**

### Monthly Maintenance Tasks

- [ ] Check website speed (GTmetrix/PageSpeed)
- [ ] Review security logs
- [ ] Update content and blog posts
- [ ] Check broken links
- [ ] Monitor lead generation forms
- [ ] Backup database

---

**Your website will be live at**: https://zerowhatsolar.in
**Admin panel**: https://zerowhatsolar.in/admin/

Good luck with your deployment! 🌟