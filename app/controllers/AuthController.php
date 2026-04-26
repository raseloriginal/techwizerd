<?php
class AuthController extends Controller
{
    public function showLogin(): void
    {
        if ($this->isLoggedIn()) {
            $this->redirect(BASE_URL . 'admin/dashboard');
        }
        $error = $_SESSION['login_error'] ?? null;
        unset($_SESSION['login_error']);
        $this->view('auth/login', ['error' => $error], '');
    }

    public function login(): void
    {
        if (!$this->csrfCheck()) {
            $_SESSION['login_error'] = 'Invalid request. Please try again.';
            $this->redirect(BASE_URL . 'admin/login');
            return;
        }

        $email    = filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL);
        $password = $_POST['password'] ?? '';

        if (empty($email) || empty($password)) {
            $_SESSION['login_error'] = 'Email and password are required.';
            $this->redirect(BASE_URL . 'admin/login');
            return;
        }

        $db   = Database::getInstance();
        $pdo  = $db->getConnection();
        $stmt = $pdo->prepare("SELECT * FROM admin_users WHERE email = ? LIMIT 1");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION[ADMIN_SESSION_KEY] = [
                'id'    => $user['id'],
                'name'  => $user['name'],
                'email' => $user['email'],
                'role'  => $user['role'],
            ];
            // Regenerate session ID on login
            session_regenerate_id(true);
            $this->redirect(BASE_URL . 'admin/dashboard');
        } else {
            $_SESSION['login_error'] = 'Invalid email or password.';
            $this->redirect(BASE_URL . 'admin/login');
        }
    }

    public function logout(): void
    {
        session_destroy();
        session_start();
        $this->redirect(BASE_URL . 'admin/login');
    }
}
