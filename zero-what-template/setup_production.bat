@echo off
title Zero What Solar - Production Setup
color 0A

echo.
echo ================================
echo  Zero What Solar - Production Setup
echo ================================
echo.

echo 🔍 Checking if XAMPP is installed...
if exist "C:\xampp\php\php.exe" (
    echo ✅ XAMPP found at C:\xampp\
) else (
    echo ❌ XAMPP not found!
    echo.
    echo 📥 Please install XAMPP first:
    echo 1. Download from: https://www.apachefriends.org/download.html
    echo 2. Install to C:\xampp\
    echo 3. Run this script again
    echo.
    pause
    exit /b 1
)

echo.
echo 🔧 Starting XAMPP services...
echo Opening XAMPP Control Panel - Please start Apache and MySQL manually
start "" "C:\xampp\xampp-control.exe"

echo.
echo ⏳ Waiting for you to start Apache and MySQL...
echo Press any key once both services are running...
echo (If XAMPP gives errors, we'll use PHP built-in server instead)
pause >nul

echo.
echo 🔍 Testing if MySQL is running...
netstat -an | findstr :3306 >nul
if %errorlevel% equ 0 (
    echo ✅ MySQL is running on port 3306
) else (
    echo ⚠️  MySQL not detected - database features may not work
    echo 💡 Continuing with PHP server for frontend testing...
)

echo.
echo 🔍 Running production setup checks...
C:\xampp\php\php.exe production_setup.php

echo.
echo 📊 Setting up database (if needed)...
C:\xampp\php\php.exe setup_admin.php

echo.
echo 🌐 Getting network information...
for /f "tokens=2 delims=:" %%i in ('ipconfig ^| findstr "IPv4"') do (
    set "ip=%%i"
    setlocal enabledelayedexpansion
    set "ip=!ip: =!"
    echo.
    echo 🏠 Your Local IP: !ip!
    echo.
    echo 📱 Access URLs:
    echo    Main Site: http://!ip!/zerowhat-solar/
    echo    Admin Panel: http://!ip!/zerowhat-solar/admin/
    echo.
    echo 💡 Share these URLs with other devices on your network!
    endlocal
    goto :found_ip
)
:found_ip

echo.
echo 🔗 Creating XAMPP symlink...
if not exist "C:\xampp\htdocs\zerowhat-solar" (
    mklink /D "C:\xampp\htdocs\zerowhat-solar" "%CD%"
    echo ✅ Symlink created successfully!
) else (
    echo ✅ Symlink already exists
)

echo.
echo 🌟 Setup Complete!
echo.
echo 🎯 Next Steps:
echo 1. Open: http://localhost/zerowhat-solar/
echo 2. Test admin panel: http://localhost/zerowhat-solar/admin/
echo 3. Default admin login: admin / admin123
echo 4. Test from mobile devices using your IP address
echo.
echo 📝 For external access (internet):
echo 1. Configure router port forwarding (port 80)
echo 2. Use your public IP or dynamic DNS service
echo.

pause