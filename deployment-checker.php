<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zero What Solar - Deployment Checker</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f5f5f5;
        }
        .container {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }
        .header {
            text-align: center;
            border-bottom: 3px solid #2c5f41;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .check-item {
            padding: 15px;
            margin: 10px 0;
            border-left: 4px solid #ddd;
            background: #f9f9f9;
            border-radius: 5px;
        }
        .check-pass {
            border-left-color: #4CAF50;
            background: #e8f5e8;
        }
        .check-fail {
            border-left-color: #f44336;
            background: #ffe8e8;
        }
        .check-warning {
            border-left-color: #ff9800;
            background: #fff3cd;
        }
        .status {
            font-weight: bold;
            display: inline-block;
            padding: 3px 8px;
            border-radius: 3px;
            font-size: 12px;
        }
        .status-pass { background: #4CAF50; color: white; }
        .status-fail { background: #f44336; color: white; }
        .status-warning { background: #ff9800; color: white; }
        .deployment-links {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-top: 30px;
        }
        .deployment-card {
            padding: 20px;
            border: 2px solid #ddd;
            border-radius: 10px;
            text-align: center;
            transition: all 0.3s ease;
        }
        .deployment-card:hover {
            border-color: #2c5f41;
            transform: translateY(-2px);
        }
        .deployment-card.recommended {
            border-color: #4CAF50;
            background: linear-gradient(135deg, #e8f5e8, #f0f8f0);
        }
        .recommended-badge {
            background: #4CAF50;
            color: white;
            padding: 5px 10px;
            border-radius: 15px;
            font-size: 12px;
            margin-bottom: 10px;
            display: inline-block;
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            background: #2c5f41;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 10px;
            transition: background 0.3s ease;
        }
        .btn:hover {
            background: #1e3e2a;
        }
        .system-info {
            background: #e3f2fd;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🚀 Zero What Solar</h1>
            <h2>Deployment Readiness Checker</h2>
        </div>

        <?php
        // System Information
        $phpVersion = phpversion();
        $extensions = get_loaded_extensions();
        $requiredExtensions = ['pdo', 'pdo_mysql', 'mbstring', 'json', 'curl'];
        $currentDir = __DIR__;
        $dbConfigPath = $currentDir . '/config/database.php';
        
        echo "<div class='system-info'>";
        echo "<h3>📋 System Information</h3>";
        echo "<p><strong>PHP Version:</strong> $phpVersion</p>";
        echo "<p><strong>Current Directory:</strong> $currentDir</p>";
        echo "<p><strong>Operating System:</strong> " . PHP_OS . "</p>";
        echo "<p><strong>Server:</strong> " . ($_SERVER['SERVER_SOFTWARE'] ?? 'Unknown') . "</p>";
        echo "</div>";

        // Check PHP Version
        echo "<div class='check-item " . (version_compare($phpVersion, '7.4.0', '>=') ? 'check-pass' : 'check-fail') . "'>";
        echo "<span class='status " . (version_compare($phpVersion, '7.4.0', '>=') ? 'status-pass' : 'status-fail') . "'>" . 
             (version_compare($phpVersion, '7.4.0', '>=') ? 'PASS' : 'FAIL') . "</span>";
        echo "<strong> PHP Version Check</strong><br>";
        echo "Current: PHP $phpVersion<br>";
        echo "Required: PHP 7.4 or higher<br>";
        if (version_compare($phpVersion, '8.0.0', '>=')) {
            echo "<em>✅ Excellent! PHP 8+ provides better performance</em>";
        }
        echo "</div>";

        // Check Required Extensions
        foreach ($requiredExtensions as $ext) {
            $loaded = extension_loaded($ext);
            echo "<div class='check-item " . ($loaded ? 'check-pass' : 'check-fail') . "'>";
            echo "<span class='status " . ($loaded ? 'status-pass' : 'status-fail') . "'>" . 
                 ($loaded ? 'PASS' : 'FAIL') . "</span>";
            echo "<strong> PHP Extension: $ext</strong><br>";
            if ($loaded) {
                echo "✅ Extension is loaded and available";
            } else {
                echo "❌ Extension is missing - required for deployment";
            }
            echo "</div>";
        }

        // Check Database Configuration
        $dbConfigExists = file_exists($dbConfigPath);
        echo "<div class='check-item " . ($dbConfigExists ? 'check-pass' : 'check-warning') . "'>";
        echo "<span class='status " . ($dbConfigExists ? 'status-pass' : 'status-warning') . "'>" . 
             ($dbConfigExists ? 'PASS' : 'WARNING') . "</span>";
        echo "<strong> Database Configuration</strong><br>";
        if ($dbConfigExists) {
            echo "✅ Database config file found<br>";
            
            // Try to check database connection
            try {
                require_once $dbConfigPath;
                if (defined('DB_HOST')) {
                    echo "<em>Host: " . DB_HOST . ", Database: " . DB_NAME . "</em>";
                }
            } catch (Exception $e) {
                echo "<em>⚠️ Config file exists but may need updates for production</em>";
            }
        } else {
            echo "⚠️ Database config not found - will need to be created during deployment";
        }
        echo "</div>";

        // Check Required Files
        $requiredFiles = [
            'index.php' => 'Homepage',
            'admin/index.php' => 'Admin Panel',
            'process-form.php' => 'Form Processing',
            'database/schema.sql' => 'Database Schema',
            '.htaccess' => 'URL Rewriting'
        ];

        foreach ($requiredFiles as $file => $description) {
            $exists = file_exists($currentDir . '/' . $file);
            echo "<div class='check-item " . ($exists ? 'check-pass' : 'check-fail') . "'>";
            echo "<span class='status " . ($exists ? 'status-pass' : 'status-fail') . "'>" . 
                 ($exists ? 'PASS' : 'FAIL') . "</span>";
            echo "<strong> File Check: $description</strong><br>";
            echo "Path: $file<br>";
            if ($exists) {
                echo "✅ File exists and ready for deployment";
            } else {
                echo "❌ File missing - required for proper functionality";
            }
            echo "</div>";
        }

        // Check Assets Directory
        $assetsPath = $currentDir . '/assets';
        $assetsExists = is_dir($assetsPath);
        echo "<div class='check-item " . ($assetsExists ? 'check-pass' : 'check-warning') . "'>";
        echo "<span class='status " . ($assetsExists ? 'status-pass' : 'status-warning') . "'>" . 
             ($assetsExists ? 'PASS' : 'WARNING') . "</span>";
        echo "<strong> Assets Directory</strong><br>";
        if ($assetsExists) {
            $cssExists = file_exists($assetsPath . '/css/style.css');
            $jsExists = file_exists($assetsPath . '/js/main.js');
            $imagesDir = is_dir($assetsPath . '/images');
            
            echo "✅ Assets directory found<br>";
            echo "CSS Files: " . ($cssExists ? '✅' : '❌') . "<br>";
            echo "JS Files: " . ($jsExists ? '✅' : '❌') . "<br>";
            echo "Images Directory: " . ($imagesDir ? '✅' : '❌');
        } else {
            echo "⚠️ Assets directory not found - may need to be created";
        }
        echo "</div>";

        // Deployment Readiness Summary
        $allChecks = version_compare($phpVersion, '7.4.0', '>=') && 
                    in_array('pdo', $extensions) && 
                    in_array('pdo_mysql', $extensions) && 
                    file_exists($currentDir . '/index.php') && 
                    file_exists($currentDir . '/database/schema.sql');

        echo "<div class='check-item " . ($allChecks ? 'check-pass' : 'check-warning') . "'>";
        echo "<span class='status " . ($allChecks ? 'status-pass' : 'status-warning') . "'>" . 
             ($allChecks ? 'READY' : 'NEEDS WORK') . "</span>";
        echo "<strong> Overall Deployment Readiness</strong><br>";
        if ($allChecks) {
            echo "🎉 Your Zero What Solar website is ready for deployment!<br>";
            echo "All critical requirements are met. You can proceed with either Hostinger or Vercel deployment.";
        } else {
            echo "⚠️ Some issues need to be addressed before deployment.<br>";
            echo "Please fix the failed checks above and run this checker again.";
        }
        echo "</div>";
        ?>

        <div class="deployment-links">
            <div class="deployment-card recommended">
                <div class="recommended-badge">RECOMMENDED</div>
                <h3>🏆 Hostinger Deployment</h3>
                <p><strong>Best for PHP CMS</strong></p>
                <ul style="text-align: left; display: inline-block;">
                    <li>Full PHP support</li>
                    <li>MySQL included</li>
                    <li>File uploads</li>
                    <li>Easy setup</li>
                    <li>24/7 support</li>
                </ul>
                <p><strong>Cost:</strong> $2-10/month</p>
                <a href="HOSTINGER_DEPLOYMENT.md" class="btn">📖 View Guide</a>
            </div>

            <div class="deployment-card">
                <h3>⚡ Vercel Deployment</h3>
                <p><strong>Modern Serverless</strong></p>
                <ul style="text-align: left; display: inline-block;">
                    <li>Serverless functions</li>
                    <li>Global CDN</li>
                    <li>Git integration</li>
                    <li>External database</li>
                    <li>Advanced setup</li>
                </ul>
                <p><strong>Cost:</strong> $0-20/month + DB</p>
                <a href="VERCEL_DEPLOYMENT.md" class="btn">📖 View Guide</a>
            </div>
        </div>

        <div style="margin-top: 30px; text-align: center; padding: 20px; background: #f0f8f0; border-radius: 10px;">
            <h3>📚 Additional Resources</h3>
            <p>
                <a href="DEPLOYMENT_GUIDE.md" class="btn">📋 Complete Comparison Guide</a>
                <a href="database/schema.sql" class="btn" style="margin-left: 10px;">🗃️ Database Schema</a>
            </p>
            <p style="margin-top: 15px; font-size: 14px; color: #666;">
                Need help? Check the deployment guides for step-by-step instructions!
            </p>
        </div>
    </div>
</body>
</html>