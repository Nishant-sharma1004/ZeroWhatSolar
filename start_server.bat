@echo off
title Zero What Solar - PHP Server
color 0B

echo.
echo ================================
echo  Zero What Solar - PHP Development Server
echo ================================
echo.

echo 🔍 Checking PHP installation...
if exist "C:\xampp\php\php.exe" (
    echo ✅ PHP found in XAMPP
    set PHP_PATH=C:\xampp\php\php.exe
) else (
    echo ❌ XAMPP not found!
    echo Please install XAMPP first or use setup_production.bat
    pause
    exit /b 1
)

echo.
echo 🌐 Getting your network IP...
for /f "tokens=2 delims=:" %%i in ('ipconfig ^| findstr "IPv4"') do (
    set "ip=%%i"
    setlocal enabledelayedexpansion
    set "ip=!ip: =!"
    echo 🏠 Your Local IP: !ip!
    
    echo.
    echo 🚀 Starting PHP Development Server...
    echo.
    echo 📱 Access URLs:
    echo    Local: http://localhost:8080/
    echo    Network: http://!ip!:8080/
    echo    Admin: http://!ip!:8080/admin/
    echo.
    echo 💡 Share the network URL with other devices!
    echo.
    echo 🛑 Press Ctrl+C to stop the server
    echo.
    
    "%PHP_PATH%" -S 0.0.0.0:8080
    endlocal
    goto :done
)

:done
echo.
echo Server stopped.
pause