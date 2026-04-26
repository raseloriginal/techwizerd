<?php
/**
 * Base Controller
 */
class Controller
{
    public function view(string $view, array $data = [], string $layout = 'main'): void
    {
        // Extract data to variables
        extract($data);

        // Capture view content
        ob_start();
        $viewPath = APP_ROOT . '/app/views/' . $view . '.php';
        if (!file_exists($viewPath)) {
            die("View not found: {$view}");
        }
        include $viewPath;
        $content = ob_get_clean();

        // Render layout
        $layoutPath = APP_ROOT . '/app/views/layouts/' . $layout . '.php';
        if ($layout && file_exists($layoutPath)) {
            include $layoutPath;
        } else {
            echo $content;
        }
    }

    public function model(string $model): object
    {
        require_once APP_ROOT . '/app/models/' . $model . '.php';
        return new $model();
    }

    public function redirect(string $url): void
    {
        header('Location: ' . $url);
        exit;
    }

    public function json(array $data, int $status = 200): void
    {
        http_response_code($status);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }

    public function isLoggedIn(): bool
    {
        return isset($_SESSION[ADMIN_SESSION_KEY]);
    }

    public function requireLogin(): void
    {
        if (!$this->isLoggedIn()) {
            $this->redirect(BASE_URL . 'admin/login');
        }
    }

    public function setFlash(string $type, string $message): void
    {
        $_SESSION['flash'] = ['type' => $type, 'message' => $message];
    }

    public function getFlash(): ?array
    {
        if (isset($_SESSION['flash'])) {
            $flash = $_SESSION['flash'];
            unset($_SESSION['flash']);
            return $flash;
        }
        return null;
    }

    protected function csrfCheck(): bool
    {
        if (!isset($_POST['csrf_token']) || !isset($_SESSION['csrf_token'])) {
            return false;
        }
        return hash_equals($_SESSION['csrf_token'], $_POST['csrf_token']);
    }

    protected function sanitize(string $input): string
    {
        return htmlspecialchars(strip_tags(trim($input)), ENT_QUOTES, 'UTF-8');
    }
}
