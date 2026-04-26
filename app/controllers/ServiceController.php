<?php
class ServiceController extends Controller
{
    public function index(): void
    {
        $this->requireLogin();
        $serviceModel = new Service();
        $services     = $serviceModel->getAll();
        $flash        = flash();
        $this->view('admin/services/index', compact('services', 'flash'), 'admin');
    }

    public function create(): void
    {
        $this->requireLogin();
        $flash = flash();
        $this->view('admin/services/create', compact('flash'), 'admin');
    }

    public function store(): void
    {
        $this->requireLogin();
        if (!$this->csrfCheck()) {
            set_flash('error', 'Invalid CSRF token.');
            $this->redirect(BASE_URL . 'admin/services/create');
            return;
        }

        $title = $this->sanitize($_POST['title'] ?? '');
        $data  = [
            'title'       => $title,
            'slug'        => slug($title),
            'description' => $this->sanitize($_POST['description'] ?? ''),
            'icon'        => $this->sanitize($_POST['icon'] ?? ''),
            'sort_order'  => (int)($_POST['sort_order'] ?? 0),
            'is_active'   => isset($_POST['is_active']) ? 1 : 0,
        ];

        $serviceModel = new Service();
        $serviceModel->insert('services', $data);
        set_flash('success', 'Service added!');
        $this->redirect(BASE_URL . 'admin/services');
    }

    public function edit(string $id): void
    {
        $this->requireLogin();
        $serviceModel = new Service();
        $service      = $serviceModel->findById('services', (int)$id);

        if (!$service) {
            set_flash('error', 'Service not found.');
            $this->redirect(BASE_URL . 'admin/services');
            return;
        }

        $flash = flash();
        $this->view('admin/services/edit', compact('service', 'flash'), 'admin');
    }

    public function update(string $id): void
    {
        $this->requireLogin();
        if (!$this->csrfCheck()) {
            set_flash('error', 'Invalid CSRF token.');
            $this->redirect(BASE_URL . 'admin/services/edit/' . $id);
            return;
        }

        $title = $this->sanitize($_POST['title'] ?? '');
        $data  = [
            'title'       => $title,
            'slug'        => slug($title),
            'description' => $this->sanitize($_POST['description'] ?? ''),
            'icon'        => $this->sanitize($_POST['icon'] ?? ''),
            'sort_order'  => (int)($_POST['sort_order'] ?? 0),
            'is_active'   => isset($_POST['is_active']) ? 1 : 0,
        ];

        $serviceModel = new Service();
        $serviceModel->update('services', $data, ['id' => (int)$id]);
        set_flash('success', 'Service updated!');
        $this->redirect(BASE_URL . 'admin/services');
    }

    public function delete(string $id): void
    {
        $this->requireLogin();
        $serviceModel = new Service();
        $serviceModel->delete('services', ['id' => (int)$id]);
        set_flash('success', 'Service deleted.');
        $this->redirect(BASE_URL . 'admin/services');
    }
}
