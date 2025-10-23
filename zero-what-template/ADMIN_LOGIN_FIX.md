# 🔧 Fix Admin Login - Quick Guide

## Issue: Demo credentials not working

The admin login credentials were not working because the database and admin user needed to be properly set up.

## 🚀 Quick Fix Steps:

### Step 1: Run the Fix Script
1. Open your web browser
2. Navigate to: `http://localhost/fix_admin_login.php`
   (Replace with your actual server path)
3. The script will automatically:
   - Create the database if it doesn't exist
   - Create the admin_users table
   - Set up the admin user with correct credentials
   - Verify everything is working

### Step 2: Login to Admin Panel
After running the fix script, use these credentials:

**Admin Login URL:** `http://localhost/admin/login.php`

**Credentials:**
- **Username:** `admin`
- **Password:** `admin123`

## 🔍 What the Fix Script Does:

1. ✅ Creates database `zerowhat_solar_cms` if it doesn't exist
2. ✅ Creates `admin_users` table with proper structure
3. ✅ Creates admin user with username `admin` and password `admin123`
4. ✅ Sets up essential database tables
5. ✅ Verifies password hashing is working correctly
6. ✅ Tests the login credentials

## 🛠️ Troubleshooting:

If you still can't login after running the fix script:

1. **Check XAMPP/WAMP is running:**
   - Make sure Apache and MySQL services are started
   - MySQL should be running on port 3306

2. **Check database connection:**
   - Open phpMyAdmin: `http://localhost/phpmyadmin`
   - Verify database `zerowhat_solar_cms` exists
   - Check if `admin_users` table has data

3. **Clear browser cache:**
   - Sometimes old login attempts are cached
   - Try incognito/private browsing mode

4. **Check PHP errors:**
   - Look for any error messages on the login page
   - Check browser console for JavaScript errors

## 🎯 Expected Result:
After running the fix script, you should see a success message with green checkmarks (✅) for each step. Then you can login to the admin panel using the credentials above.

## 📞 Need Help?
If the issue persists, please share:
1. What error message you see on the login page
2. Whether the fix script ran successfully
3. Any error messages from the fix script