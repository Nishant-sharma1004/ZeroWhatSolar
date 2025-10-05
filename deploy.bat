@echo off
title Zero What Solar - Quick Deployment Setup
color 0A

echo.
echo ================================================
echo      Zero What Solar - Deployment Setup
echo ================================================
echo.

:: Check if running from correct directory
if not exist "index.php" (
    echo [ERROR] Please run this script from the website root directory
    echo Current directory: %CD%
    pause
    exit /b 1
)

echo [INFO] Checking deployment readiness...
echo.

:: Check PHP installation
php --version >nul 2>&1
if errorlevel 1 (
    echo [WARNING] PHP not found in system PATH
    echo You can still deploy to Hostinger or Vercel
    echo.
) else (
    echo [OK] PHP installation detected
    php --version | findstr "PHP"
    echo.
)

:: Check required files
echo [INFO] Checking required files...
if exist "config\database.php" (
    echo [OK] Database configuration found
) else (
    echo [WARNING] Database config missing - will be created during deployment
)

if exist "database\schema.sql" (
    echo [OK] Database schema found
) else (
    echo [ERROR] Database schema missing
)

if exist ".htaccess" (
    echo [OK] Apache configuration found
) else (
    echo [WARNING] .htaccess file missing - may affect URL rewriting
)

if exist "admin\index.php" (
    echo [OK] Admin panel found
) else (
    echo [ERROR] Admin panel missing
)

echo.
echo ================================================
echo           Deployment Options
echo ================================================
echo.
echo 1. Hostinger Deployment (RECOMMENDED)
echo    - Full PHP support
echo    - MySQL included
echo    - Easy setup
echo    - Cost: $2-10/month
echo.
echo 2. Vercel Deployment (ADVANCED)
echo    - Serverless functions
echo    - External database required
echo    - Modern architecture
echo    - Cost: $0-20/month + database
echo.
echo 3. Run Deployment Checker (Web Interface)
echo.
echo 4. View All Deployment Guides
echo.

set /p choice="Enter your choice (1-4): "

if "%choice%"=="1" (
    echo.
    echo Opening Hostinger deployment guide...
    if exist "HOSTINGER_DEPLOYMENT.md" (
        start "" "HOSTINGER_DEPLOYMENT.md"
    ) else (
        echo [ERROR] Hostinger deployment guide not found
    )
    goto :menu
)

if "%choice%"=="2" (
    echo.
    echo Opening Vercel deployment guide...
    if exist "VERCEL_DEPLOYMENT.md" (
        start "" "VERCEL_DEPLOYMENT.md"
    ) else (
        echo [ERROR] Vercel deployment guide not found
    )
    goto :menu
)

if "%choice%"=="3" (
    echo.
    echo Starting deployment checker...
    php --version >nul 2>&1
    if errorlevel 1 (
        echo [ERROR] PHP required to run deployment checker
        echo Please install PHP or check deployment guides manually
        pause
        goto :menu
    ) else (
        echo [INFO] Starting PHP server for deployment checker...
        echo [INFO] Opening http://localhost:8080/deployment-checker.php
        echo [INFO] Press Ctrl+C to stop the server
        echo.
        start "" "http://localhost:8080/deployment-checker.php"
        php -S localhost:8080
    )
    goto :end
)

if "%choice%"=="4" (
    echo.
    echo Opening deployment comparison guide...
    if exist "DEPLOYMENT_GUIDE.md" (
        start "" "DEPLOYMENT_GUIDE.md"
    ) else (
        echo [ERROR] Deployment guide not found
    )
    if exist "HOSTINGER_DEPLOYMENT.md" (
        start "" "HOSTINGER_DEPLOYMENT.md"
    )
    if exist "VERCEL_DEPLOYMENT.md" (
        start "" "VERCEL_DEPLOYMENT.md"
    )
    goto :menu
)

echo [ERROR] Invalid choice. Please select 1-4.
goto :menu

:menu
echo.
set /p continue="Would you like to see the menu again? (y/n): "
if /i "%continue%"=="y" goto :start
if /i "%continue%"=="yes" goto :start

:end
echo.
echo ================================================
echo      Thank you for using Zero What Solar!
echo ================================================
echo.
echo Next Steps:
echo 1. Choose your deployment platform
echo 2. Follow the step-by-step guides
echo 3. Upload your files and database
echo 4. Configure your domain and SSL
echo.
echo Good luck with your deployment! 🚀
echo.
pause