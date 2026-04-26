<?php
/**
 * Router — Maps URL segments to Controller@Method
 */
class Router
{
    private array $routes = [];

    public function dispatch(): void
    {
        $url = $_GET['url'] ?? '';
        $url = rtrim($url, '/');
        $url = filter_var($url, FILTER_SANITIZE_URL);
        $urlParts = $url ? explode('/', $url) : [];

        $controllerName = 'HomeController';
        $methodName     = 'index';
        $params         = [];

        // Admin routes
        if (!empty($urlParts[0]) && $urlParts[0] === 'admin') {
            $this->dispatchAdmin(array_slice($urlParts, 1));
            return;
        }

        // Public routes
        if (!empty($urlParts[0])) {
            $segment0 = $urlParts[0];
            switch ($segment0) {
                case 'about':
                    $controllerName = 'HomeController';
                    $methodName     = 'about';
                    break;
                case 'services':
                    $controllerName = 'HomeController';
                    $methodName     = 'services';
                    break;
                case 'projects':
                    $controllerName = 'ProjectController';
                    $methodName     = !empty($urlParts[1]) ? 'show' : 'index';
                    $params         = !empty($urlParts[1]) ? [$urlParts[1]] : [];
                    break;
                case 'team':
                    $controllerName = 'HomeController';
                    $methodName     = 'team';
                    break;
                case 'contact':
                    $controllerName = 'HomeController';
                    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                        $methodName = 'submitContact';
                    } else {
                        $methodName = 'contact';
                    }
                    break;
                default:
                    $this->notFound();
                    return;
            }
        }

        $this->callController($controllerName, $methodName, $params);
    }

    private function dispatchAdmin(array $parts): void
    {
        $segment0 = $parts[0] ?? '';
        $segment1 = $parts[1] ?? '';
        $segment2 = $parts[2] ?? '';
        $segment3 = $parts[3] ?? '';

        // Login / logout (no auth required)
        if ($segment0 === 'login') {
            $method = $_SERVER['REQUEST_METHOD'] === 'POST' ? 'login' : 'showLogin';
            $this->callController('AuthController', $method, []);
            return;
        }
        if ($segment0 === 'logout') {
            $this->callController('AuthController', 'logout', []);
            return;
        }

        // Check auth for all other admin routes
        if (!isset($_SESSION[ADMIN_SESSION_KEY])) {
            header('Location: ' . BASE_URL . 'admin/login');
            exit;
        }

        // Route dispatching
        switch ($segment0) {
            case '':
            case 'dashboard':
                $this->callController('AdminController', 'dashboard', []);
                break;

            case 'projects':
                $this->dispatchProjects($segment1, $segment2, $segment3);
                break;

            case 'expenses':
                $this->dispatchExpenses($segment1, $segment2, $segment3);
                break;

            case 'clients':
                $this->dispatchClients($segment1, $segment2);
                break;

            case 'team':
                $this->dispatchTeam($segment1, $segment2);
                break;

            case 'services':
                $this->dispatchServices($segment1, $segment2);
                break;

            case 'contacts':
                $method = $segment1 === 'delete' ? 'delete' : ($segment1 === 'read' ? 'markRead' : 'index');
                $params = $segment2 ? [$segment2] : [];
                $this->callController('ContactController', $method, $params);
                break;

            case 'settings':
                $method = $_SERVER['REQUEST_METHOD'] === 'POST' ? 'update' : 'index';
                $this->callController('SettingController', $method, []);
                break;

            default:
                $this->notFound();
        }
    }

    private function dispatchProjects(string $s1, string $s2, string $s3): void
    {
        $isPost = $_SERVER['REQUEST_METHOD'] === 'POST';
        switch ($s1) {
            case '':
                $this->callController('ProjectController', 'adminIndex', []);
                break;
            case 'create':
                $this->callController('ProjectController', $isPost ? 'store' : 'create', []);
                break;
            case 'edit':
                $this->callController('ProjectController', $isPost ? 'update' : 'edit', [$s2]);
                break;
            case 'show':
                $this->callController('ProjectController', 'adminShow', [$s2]);
                break;
            case 'delete':
                $this->callController('ProjectController', 'delete', [$s2]);
                break;
            case 'upload-image':
                $this->callController('ProjectController', 'uploadImage', [$s2]);
                break;
            case 'delete-image':
                $this->callController('ProjectController', 'deleteImage', [$s2]);
                break;
            default:
                $this->notFound();
        }
    }

    private function dispatchExpenses(string $s1, string $s2, string $s3): void
    {
        $isPost = $_SERVER['REQUEST_METHOD'] === 'POST';
        switch ($s1) {
            case 'project':
                switch ($s2) {
                    case '':
                        $this->callController('ExpenseController', 'projectIndex', []);
                        break;
                    case 'create':
                        $this->callController('ExpenseController', $isPost ? 'projectStore' : 'projectCreate', []);
                        break;
                    case 'edit':
                        $this->callController('ExpenseController', $isPost ? 'projectUpdate' : 'projectEdit', [$s3]);
                        break;
                    case 'delete':
                        $this->callController('ExpenseController', 'projectDelete', [$s3]);
                        break;
                    case 'summary':
                        $this->callController('ExpenseController', 'projectSummary', []);
                        break;
                    case 'export':
                        $this->callController('ExpenseController', 'exportCsv', ['project']);
                        break;
                    default:
                        $this->notFound();
                }
                break;
            case 'company':
                switch ($s2) {
                    case '':
                        $this->callController('ExpenseController', 'companyIndex', []);
                        break;
                    case 'create':
                        $this->callController('ExpenseController', $isPost ? 'companyStore' : 'companyCreate', []);
                        break;
                    case 'edit':
                        $this->callController('ExpenseController', $isPost ? 'companyUpdate' : 'companyEdit', [$s3]);
                        break;
                    case 'delete':
                        $this->callController('ExpenseController', 'companyDelete', [$s3]);
                        break;
                    case 'summary':
                        $this->callController('ExpenseController', 'companySummary', []);
                        break;
                    case 'export':
                        $this->callController('ExpenseController', 'exportCsv', ['company']);
                        break;
                    default:
                        $this->notFound();
                }
                break;
            default:
                $this->notFound();
        }
    }

    private function dispatchClients(string $s1, string $s2): void
    {
        $isPost = $_SERVER['REQUEST_METHOD'] === 'POST';
        switch ($s1) {
            case '':
                $this->callController('ClientController', 'index', []);
                break;
            case 'create':
                $this->callController('ClientController', $isPost ? 'store' : 'create', []);
                break;
            case 'edit':
                $this->callController('ClientController', $isPost ? 'update' : 'edit', [$s2]);
                break;
            case 'delete':
                $this->callController('ClientController', 'delete', [$s2]);
                break;
            default:
                $this->notFound();
        }
    }

    private function dispatchTeam(string $s1, string $s2): void
    {
        $isPost = $_SERVER['REQUEST_METHOD'] === 'POST';
        switch ($s1) {
            case '':
                $this->callController('TeamController', 'index', []);
                break;
            case 'create':
                $this->callController('TeamController', $isPost ? 'store' : 'create', []);
                break;
            case 'edit':
                $this->callController('TeamController', $isPost ? 'update' : 'edit', [$s2]);
                break;
            case 'delete':
                $this->callController('TeamController', 'delete', [$s2]);
                break;
            default:
                $this->notFound();
        }
    }

    private function dispatchServices(string $s1, string $s2): void
    {
        $isPost = $_SERVER['REQUEST_METHOD'] === 'POST';
        switch ($s1) {
            case '':
                $this->callController('ServiceController', 'index', []);
                break;
            case 'create':
                $this->callController('ServiceController', $isPost ? 'store' : 'create', []);
                break;
            case 'edit':
                $this->callController('ServiceController', $isPost ? 'update' : 'edit', [$s2]);
                break;
            case 'delete':
                $this->callController('ServiceController', 'delete', [$s2]);
                break;
            default:
                $this->notFound();
        }
    }

    private function callController(string $controllerName, string $methodName, array $params): void
    {
        if (!class_exists($controllerName)) {
            $this->notFound();
            return;
        }
        $controller = new $controllerName();
        if (!method_exists($controller, $methodName)) {
            $this->notFound();
            return;
        }
        call_user_func_array([$controller, $methodName], $params);
    }

    private function notFound(): void
    {
        http_response_code(404);
        echo '<h1>404 — Page Not Found</h1>';
    }
}
