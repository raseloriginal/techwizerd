<?php
/**
 * Tech Wizard — Front Controller
 * All requests go through this file
 */

// Start session
session_name('tw_session');
session_start();

// Load configuration
require_once dirname(dirname(__FILE__)) . '/config/config.php';

// Load helpers
require_once APP_ROOT . '/core/helpers.php';

// Simple autoloader
spl_autoload_register(function($className) {
    $paths = [
        APP_ROOT . '/core/' . $className . '.php',
        APP_ROOT . '/app/controllers/' . $className . '.php',
        APP_ROOT . '/app/models/' . $className . '.php',
    ];
    foreach ($paths as $path) {
        if (file_exists($path)) {
            require_once $path;
            return;
        }
    }
});

// Error handling
if (APP_DEBUG) {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
} else {
    error_reporting(0);
}

// Dispatch the request
$router = new Router();
$router->dispatch();
