<?php
// Database Configuration
define('DB_HOST', 'localhost');
define('DB_USER', 'nuroxtec_tw');
define('DB_PASS', 'IrH^BwV#lg2O');
define('DB_NAME', 'nuroxtec_tw');

// Application URLs
// Application URLs
if (isset($_SERVER['HTTP_HOST']) && ($_SERVER['HTTP_HOST'] === 'localhost' || str_contains($_SERVER['HTTP_HOST'], '127.0.0.1'))) {
    define('BASE_URL', 'http://localhost/tech_wizerd/');
} else {
    define('BASE_URL', 'https://techwizerd.nuroxtech.site/');
}

define('APP_ROOT', dirname(dirname(__FILE__)));
define('UPLOAD_PATH', APP_ROOT . '/public/uploads/');
define('UPLOAD_URL', BASE_URL . 'uploads/');
define('SITE_NAME', 'Tech Wizard');

// Environment
define('APP_ENV', 'production');
define('APP_DEBUG', false);

// Session configuration
define('SESSION_NAME', 'tw_session');
define('ADMIN_SESSION_KEY', 'tw_admin');

// File upload limits
define('MAX_UPLOAD_SIZE', 5 * 1024 * 1024); // 5MB
define('ALLOWED_IMAGE_TYPES', ['jpg', 'jpeg', 'png', 'gif', 'webp']);
define('ALLOWED_DOC_TYPES', ['pdf', 'doc', 'docx']);
