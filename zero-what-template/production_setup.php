<?php
/**
 * Zero What Solar - Automated Production Setup Script
 * This script sets up the database and checks system requirements
 */

echo "🚀 Zero What Solar - Production Setup Script\n";
echo "==========================================\n\n";

// Check if we're running this from the correct directory
if (!file_exists('config/database.php')) {
    die("❌ Error: Please run this script from the project root directory!\n");
}

// Check PHP version
echo "✅ Checking PHP version... ";
if (version_compare(PHP_VERSION, '7.4.0') >= 0) {
    echo "✅ PHP " . PHP_VERSION . " (Compatible)\n";
} else {
    echo "❌ PHP " . PHP_VERSION . " (Requires PHP 7.4+)\n";
    exit(1);
}

// Check required PHP extensions
$required_extensions = ['pdo', 'pdo_mysql', 'mysqli', 'gd', 'curl', 'mbstring'];
echo "✅ Checking PHP extensions...\n";
foreach ($required_extensions as $ext) {
    if (extension_loaded($ext)) {
        echo "   ✅ $ext\n";
    } else {
        echo "   ❌ $ext (Missing - install via XAMPP)\n";
    }
}

// Test database connection
echo "\n🔍 Testing database connection...\n";
try {
    require_once 'config/database.php';
    
    // Try to connect
    $pdo = new PDO(
        "mysql:host=" . DB_HOST . ";charset=" . DB_CHARSET,
        DB_USER,
        DB_PASS,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
    
    echo "✅ MySQL connection successful!\n";
    
    // Check if database exists
    $stmt = $pdo->query("SHOW DATABASES LIKE '" . DB_NAME . "'");
    if ($stmt->rowCount() > 0) {
        echo "✅ Database '" . DB_NAME . "' exists\n";
        
        // Connect to the specific database
        $pdo->exec("USE " . DB_NAME);
        
        // Check tables
        $tables = $pdo->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN);
        if (count($tables) > 0) {
            echo "✅ Found " . count($tables) . " database tables\n";
            echo "   Tables: " . implode(', ', $tables) . "\n";
        } else {
            echo "⚠️  Database exists but is empty - run database setup\n";
        }
    } else {
        echo "⚠️  Database '" . DB_NAME . "' does not exist\n";
        echo "📝 Creating database...\n";
        
        $pdo->exec("CREATE DATABASE " . DB_NAME . " CHARACTER SET " . DB_CHARSET . " COLLATE " . DB_COLLATE);
        echo "✅ Database created successfully!\n";
        
        echo "🔧 Please run the database setup script next\n";
    }
    
} catch (PDOException $e) {
    echo "❌ Database connection failed: " . $e->getMessage() . "\n";
    echo "\n📝 Quick Fix for Common Issues:\n";
    echo "1. Make sure XAMPP is running (Apache + MySQL)\n";
    echo "2. Check MySQL is running on port 3306\n";
    echo "3. Verify username (root) and password (empty) in config/database.php\n";
    echo "4. Access phpMyAdmin: http://localhost/phpmyadmin\n";
}

// Check file permissions
echo "\n📁 Checking file permissions...\n";
$writable_dirs = ['assets/images', 'admin', 'config'];
foreach ($writable_dirs as $dir) {
    if (is_writable($dir)) {
        echo "✅ $dir (writable)\n";
    } else {
        echo "⚠️  $dir (not writable - may cause issues)\n";
    }
}

// Get system information for network access
echo "\n🌐 Network Information:\n";
$local_ip = gethostbyname(gethostname());
echo "🏠 Local IP: $local_ip\n";
echo "🌍 Local URLs:\n";
echo "   - Main Site: http://localhost/zerowhat-solar/\n";
echo "   - Admin Panel: http://localhost/zerowhat-solar/admin/\n";
echo "   - phpMyAdmin: http://localhost/phpmyadmin/\n";
echo "\n📱 Network URLs (for other devices):\n";
echo "   - Main Site: http://$local_ip/zerowhat-solar/\n";
echo "   - Admin Panel: http://$local_ip/zerowhat-solar/admin/\n";

// Check if running on built-in PHP server
if (php_sapi_name() === 'cli-server') {
    echo "\n🔧 Running on PHP built-in server\n";
    echo "Network URL: http://$local_ip:8080/\n";
}

echo "\n🎯 Next Steps:\n";
echo "1. If database is empty, run: php setup_admin.php\n";
echo "2. Access admin panel with default credentials\n";
echo "3. Configure your content and settings\n";
echo "4. Test from different devices on your network\n";

echo "\n✨ Setup Complete! Your Zero What Solar website is ready for production testing!\n";
?>