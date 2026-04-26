<?php
/**
 * Helper Functions
 */

function base_url(string $path = ''): string
{
    return BASE_URL . ltrim($path, '/');
}

function asset(string $path): string
{
    return BASE_URL . 'assets/' . ltrim($path, '/');
}

function upload_url(string $path): string
{
    return BASE_URL . 'uploads/' . ltrim($path, '/');
}

function slug(string $text): string
{
    $text = strtolower(trim($text));
    $text = preg_replace('/[^a-z0-9\s-]/', '', $text);
    $text = preg_replace('/[\s-]+/', '-', $text);
    return trim($text, '-');
}

function format_currency(float $amount, string $currency = 'BDT'): string
{
    return number_format($amount, 2) . ' ' . $currency;
}

function format_date(?string $date, string $format = 'd M Y'): string
{
    if (!$date) return '—';
    return date($format, strtotime($date));
}

function csrf_token(): string
{
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function csrf_field(): string
{
    return '<input type="hidden" name="csrf_token" value="' . csrf_token() . '">';
}

function old(string $key, string $default = ''): string
{
    return htmlspecialchars($_SESSION['old'][$key] ?? $default, ENT_QUOTES, 'UTF-8');
}

function flash(?string $key = null): ?array
{
    if (isset($_SESSION['flash'])) {
        $flash = $_SESSION['flash'];
        unset($_SESSION['flash']);
        return $flash;
    }
    return null;
}

function set_flash(string $type, string $message): void
{
    $_SESSION['flash'] = ['type' => $type, 'message' => $message];
}

function truncate(string $text, int $length = 100): string
{
    if (strlen($text) <= $length) return $text;
    return substr($text, 0, $length) . '…';
}

function upload_file(array $file, string $folder, array $allowed = ['jpg', 'jpeg', 'png', 'gif', 'pdf', 'webp']): string|false
{
    if ($file['error'] !== UPLOAD_ERR_OK) return false;
    if ($file['size'] > MAX_UPLOAD_SIZE) return false;

    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    if (!in_array($ext, $allowed)) return false;

    // MIME type check
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mime  = finfo_file($finfo, $file['tmp_name']);
    finfo_close($finfo);

    $allowedMimes = [
        'jpg' => 'image/jpeg', 'jpeg' => 'image/jpeg',
        'png' => 'image/png',  'gif' => 'image/gif',
        'webp' => 'image/webp','pdf' => 'application/pdf',
    ];
    if (!isset($allowedMimes[$ext]) || $allowedMimes[$ext] !== $mime) return false;

    $uploadDir = UPLOAD_PATH . $folder . '/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    $filename = uniqid('tw_', true) . '.' . $ext;
    $dest     = $uploadDir . $filename;

    if (!move_uploaded_file($file['tmp_name'], $dest)) return false;

    return $folder . '/' . $filename;
}

function delete_file(string $relativePath): bool
{
    if (empty($relativePath)) return false;
    $fullPath = UPLOAD_PATH . $relativePath;
    if (file_exists($fullPath)) {
        return unlink($fullPath);
    }
    return false;
}

function active(string $route): string
{
    $currentUrl = $_GET['url'] ?? '';
    $currentUrl = trim($currentUrl, '/');
    $route = trim($route, '/');

    if ($route === '' && $currentUrl === '') return 'active';
    if ($route !== '' && (str_starts_with($currentUrl, $route))) return 'active';
    return '';
}

function is_admin_active(string $route): string
{
    $currentUrl = trim($_GET['url'] ?? '', '/');
    $checkRoute = trim('admin/' . $route, '/');
    if ($route === 'dashboard' && ($currentUrl === 'admin' || $currentUrl === 'admin/dashboard')) return 'active';
    if ($route !== '' && str_starts_with($currentUrl, $checkRoute)) return 'active';
    return '';
}

function h(string $str): string
{
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}

function status_badge(string $status): string
{
    $classes = [
        'pending'   => 'badge badge-pending',
        'ongoing'   => 'badge badge-ongoing',
        'completed' => 'badge badge-completed',
        'on_hold'   => 'badge badge-warning',
        'cancelled' => 'badge badge-cancelled',
        'approved'  => 'badge badge-completed',
        'rejected'  => 'badge badge-cancelled',
    ];
    $class = $classes[$status] ?? 'badge';
    $label = ucwords(str_replace('_', ' ', $status));
    return '<span class="' . $class . '">' . $label . '</span>';
}

function paginate(int $total, int $perPage, int $currentPage): array
{
    $totalPages = (int)ceil($total / $perPage);
    $offset     = ($currentPage - 1) * $perPage;
    return [
        'total'       => $total,
        'per_page'    => $perPage,
        'current'     => $currentPage,
        'total_pages' => $totalPages,
        'offset'      => $offset,
        'has_prev'    => $currentPage > 1,
        'has_next'    => $currentPage < $totalPages,
    ];
}
