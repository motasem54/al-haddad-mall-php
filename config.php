<?php
// Database Configuration
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'al_haddad_mall');

// Site Configuration
define('SITE_NAME', 'الحداد مول');
define('SITE_URL', 'http://localhost/al-haddad-mall');
define('CURRENCY', 'ILS');

// Database Connection
try {
    $pdo = new PDO(
        "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4",
        DB_USER,
        DB_PASS,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false
        ]
    );
} catch(PDOException $e) {
    die("خطأ في الاتصال بقاعدة البيانات: " . $e->getMessage());
}

// Session Start
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Helper Functions
function redirect($url) {
    header("Location: $url");
    exit;
}

function escape($string) {
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}

function getCartCount() {
    return isset($_SESSION['cart']) ? array_sum($_SESSION['cart']) : 0;
}
?>