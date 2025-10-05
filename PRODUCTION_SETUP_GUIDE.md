# 🚀 Zero What Solar - Local Production Setup Guide

## 📋 Prerequisites
- Windows 10/11
- Administrator access
- Internet connection for downloading XAMPP

## 🔧 Step-by-Step Setup

### 1. Install XAMPP (Includes MySQL!)

1. **Download XAMPP** from: https://www.apachefriends.org/download.html
2. **Install to default location**: `C:\xampp`
3. **Run XAMPP Control Panel** as Administrator

### 2. Start Required Services

In XAMPP Control Panel:
- ✅ Start **Apache** (Web Server)
- ✅ Start **MySQL** (Database Server)

### 3. Copy Project to XAMPP

**Option A: Move Current Project**
```bash
# Move your current project to XAMPP directory
# From: D:\Nishant Sharma\Ascend Sphere\Clients\ZeroWhatSolar\PHP Website
# To: C:\xampp\htdocs\zerowhat-solar\
```

**Option B: Create Symlink (Recommended)**
```bash
# Run Command Prompt as Administrator
mklink /D "C:\xampp\htdocs\zerowhat-solar" "D:\Nishant Sharma\Ascend Sphere\Clients\ZeroWhatSolar\PHP Website"
```

### 4. Database Setup

1. **Open phpMyAdmin**: http://localhost/phpmyadmin
2. **Create Database**: `zerowhat_solar_cms`
3. **Import Database Schema**: Use the provided setup script

### 5. Test Local Access

- **Local URL**: http://localhost/zerowhat-solar/
- **Admin Panel**: http://localhost/zerowhat-solar/admin/

### 6. Network Access Setup

#### Configure Apache for Network Access

Edit `C:\xampp\apache\conf\httpd.conf`:
```apache
# Find this line and change from:
Listen 80

# To:
Listen 0.0.0.0:80
```

#### Get Your Local IP Address
```bash
ipconfig | findstr IPv4
```

#### Access from Other Devices
- **Local Network URL**: http://[YOUR-IP-ADDRESS]/zerowhat-solar/
- Example: http://192.168.1.100/zerowhat-solar/

### 7. Port Forwarding for External Access

If you want external internet access:

1. **Router Configuration**:
   - Forward port 80 to your computer's local IP
   - Or use a different port like 8080

2. **Dynamic DNS (Optional)**:
   - Use services like No-IP or DuckDNS for consistent external URL

### 8. Security Considerations for Production Testing

⚠️ **Important Security Notes**:
- Only use for testing purposes
- Don't expose admin panel to public internet
- Change default database passwords
- Use HTTPS in real production

## 🔄 Quick Start Commands

After XAMPP installation, you can also run with PHP built-in server:

```bash
# Navigate to project directory
cd "D:\Nishant Sharma\Ascend Sphere\Clients\ZeroWhatSolar\PHP Website"

# Start PHP server (Alternative to XAMPP)
C:\xampp\php\php.exe -S 0.0.0.0:8080
```

## 🌐 Testing URLs

- **Local**: http://localhost/zerowhat-solar/
- **Network**: http://[YOUR-IP]:80/zerowhat-solar/
- **PHP Server**: http://[YOUR-IP]:8080/

## 📱 Mobile Testing

1. Ensure your phone/tablet is on the same WiFi network
2. Use the network URL: http://[YOUR-IP]/zerowhat-solar/
3. Test all responsive features and forms

## 🛠️ Troubleshooting

### Apache Won't Start
- Check if port 80 is occupied: `netstat -ano | findstr :80`
- Change Apache port in XAMPP config if needed

### MySQL Won't Start
- Check if port 3306 is occupied: `netstat -ano | findstr :3306`
- Stop any existing MySQL services

### Network Access Issues
- Disable Windows Firewall temporarily for testing
- Check router firewall settings
- Verify IP address with `ipconfig`

## 📊 Performance Monitoring

- **Apache Logs**: `C:\xampp\apache\logs\`
- **MySQL Logs**: `C:\xampp\mysql\data\`
- **PHP Errors**: Check browser console and server logs

---

**Ready to go live? Your Zero What Solar website will be accessible from any device on your network!** 🌟