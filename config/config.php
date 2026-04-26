<?php
// Database Configuration
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'techwizard_db');

// Application URLs
define('BASE_URL', 'http://localhost/tech_wizerd/');
define('APP_ROOT', dirname(dirname(__FILE__)));
define('UPLOAD_PATH', APP_ROOT . '/public/uploads/');
define('UPLOAD_URL', BASE_URL . 'uploads/');
define('SITE_NAME', 'Tech Wizard');

// Environment
define('APP_ENV', 'development');
define('APP_DEBUG', true);

// Session configuration
define('SESSION_NAME', 'tw_session');
define('ADMIN_SESSION_KEY', 'tw_admin');

// File upload limits
define('MAX_UPLOAD_SIZE', 5 * 1024 * 1024); // 5MB
define('ALLOWED_IMAGE_TYPES', ['jpg', 'jpeg', 'png', 'gif', 'webp']);
define('ALLOWED_DOC_TYPES', ['pdf', 'doc', 'docx']);
