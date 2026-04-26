<?php
class ClientController extends Controller
{
    public function index(): void
    {
        $this->requireLogin();
        $clientModel = new Client();
        $clients     = $clientModel->getAll();
        $flash       = flash();
        $this->view('admin/clients/index', compact('clients', 'flash'), 'admin');
    }

    public function create(): void
    {
        $this->requireLogin();
        $flash = flash();
        $this->view('admin/clients/create', compact('flash'), 'admin');
    }

    public function store(): void
    {
        $this->requireLogin();
        if (!$this->csrfCheck()) {
            set_flash('error', 'Invalid CSRF token.');
            $this->redirect(BASE_URL . 'admin/clients/create');
            return;
        }

        $data = [
            'name'           => $this->sanitize($_POST['name'] ?? ''),
            'website'        => $this->sanitize($_POST['website'] ?? ''),
            'contact_person' => $this->sanitize($_POST['contact_person'] ?? ''),
            'contact_email'  => filter_var($_POST['contact_email'] ?? '', FILTER_SANITIZE_EMAIL),
            'contact_phone'  => $this->sanitize($_POST['contact_phone'] ?? ''),
            'sort_order'     => (int)($_POST['sort_order'] ?? 0),
            'is_active'      => isset($_POST['is_active']) ? 1 : 0,
            'logo'           => '',
        ];

        if (!empty($_FILES['logo']['name'])) {
            $uploaded = upload_file($_FILES['logo'], 'clients');
            if ($uploaded) $data['logo'] = $uploaded;
        }

        $clientModel = new Client();
        $clientModel->insert('clients', $data);
        set_flash('success', 'Client added successfully!');
        $this->redirect(BASE_URL . 'admin/clients');
    }

    public function edit(string $id): void
    {
        $this->requireLogin();
        $clientModel = new Client();
        $client      = $clientModel->findById('clients', (int)$id);

        if (!$client) {
            set_flash('error', 'Client not found.');
            $this->redirect(BASE_URL . 'admin/clients');
            return;
        }

        $flash = flash();
        $this->view('admin/clients/edit', compact('client', 'flash'), 'admin');
    }

    public function update(string $id): void
    {
        $this->requireLogin();
        if (!$this->csrfCheck()) {
            set_flash('error', 'Invalid CSRF token.');
            $this->redirect(BASE_URL . 'admin/clients/edit/' . $id);
            return;
        }

        $clientModel = new Client();
        $client      = $clientModel->findById('clients', (int)$id);

        $data = [
            'name'           => $this->sanitize($_POST['name'] ?? ''),
            'website'        => $this->sanitize($_POST['website'] ?? ''),
            'contact_person' => $this->sanitize($_POST['contact_person'] ?? ''),
            'contact_email'  => filter_var($_POST['contact_email'] ?? '', FILTER_SANITIZE_EMAIL),
            'contact_phone'  => $this->sanitize($_POST['contact_phone'] ?? ''),
            'sort_order'     => (int)($_POST['sort_order'] ?? 0),
            'is_active'      => isset($_POST['is_active']) ? 1 : 0,
        ];

        if (!empty($_FILES['logo']['name'])) {
            $uploaded = upload_file($_FILES['logo'], 'clients');
            if ($uploaded) {
                if ($client && $client['logo']) delete_file($client['logo']);
                $data['logo'] = $uploaded;
            }
        }

        $clientModel->update('clients', $data, ['id' => (int)$id]);
        set_flash('success', 'Client updated successfully!');
        $this->redirect(BASE_URL . 'admin/clients');
    }

    public function delete(string $id): void
    {
        $this->requireLogin();
        $clientModel = new Client();
        $clientModel->delete('clients', ['id' => (int)$id]);
        set_flash('success', 'Client deleted.');
        $this->redirect(BASE_URL . 'admin/clients');
    }
}
