<?php
class TeamController extends Controller
{
    public function index(): void
    {
        $this->requireLogin();
        $teamModel = new Team();
        $members   = $teamModel->getAll();
        $flash     = flash();
        $this->view('admin/team/index', compact('members', 'flash'), 'admin');
    }

    public function create(): void
    {
        $this->requireLogin();
        $flash = flash();
        $this->view('admin/team/create', compact('flash'), 'admin');
    }

    public function store(): void
    {
        $this->requireLogin();
        if (!$this->csrfCheck()) {
            set_flash('error', 'Invalid CSRF token.');
            $this->redirect(BASE_URL . 'admin/team/create');
            return;
        }

        $data = [
            'name'        => $this->sanitize($_POST['name'] ?? ''),
            'designation' => $this->sanitize($_POST['designation'] ?? ''),
            'department'  => $this->sanitize($_POST['department'] ?? ''),
            'qualification'=> $this->sanitize($_POST['qualification'] ?? ''),
            'phone'       => $this->sanitize($_POST['phone'] ?? ''),
            'email'       => filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL),
            'sort_order'  => (int)($_POST['sort_order'] ?? 0),
            'is_active'   => isset($_POST['is_active']) ? 1 : 0,
            'photo'       => '',
        ];

        if (!empty($_FILES['photo']['name'])) {
            $uploaded = upload_file($_FILES['photo'], 'team');
            if ($uploaded) $data['photo'] = $uploaded;
        }

        $teamModel = new Team();
        $teamModel->insert('team_members', $data);
        set_flash('success', 'Team member added!');
        $this->redirect(BASE_URL . 'admin/team');
    }

    public function edit(string $id): void
    {
        $this->requireLogin();
        $teamModel = new Team();
        $member    = $teamModel->findById('team_members', (int)$id);

        if (!$member) {
            set_flash('error', 'Member not found.');
            $this->redirect(BASE_URL . 'admin/team');
            return;
        }

        $flash = flash();
        $this->view('admin/team/edit', compact('member', 'flash'), 'admin');
    }

    public function update(string $id): void
    {
        $this->requireLogin();
        if (!$this->csrfCheck()) {
            set_flash('error', 'Invalid CSRF token.');
            $this->redirect(BASE_URL . 'admin/team/edit/' . $id);
            return;
        }

        $teamModel = new Team();
        $member    = $teamModel->findById('team_members', (int)$id);

        $data = [
            'name'        => $this->sanitize($_POST['name'] ?? ''),
            'designation' => $this->sanitize($_POST['designation'] ?? ''),
            'department'  => $this->sanitize($_POST['department'] ?? ''),
            'qualification'=> $this->sanitize($_POST['qualification'] ?? ''),
            'phone'       => $this->sanitize($_POST['phone'] ?? ''),
            'email'       => filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL),
            'sort_order'  => (int)($_POST['sort_order'] ?? 0),
            'is_active'   => isset($_POST['is_active']) ? 1 : 0,
        ];

        if (!empty($_FILES['photo']['name'])) {
            $uploaded = upload_file($_FILES['photo'], 'team');
            if ($uploaded) {
                if ($member && $member['photo']) delete_file($member['photo']);
                $data['photo'] = $uploaded;
            }
        }

        $teamModel->update('team_members', $data, ['id' => (int)$id]);
        set_flash('success', 'Team member updated!');
        $this->redirect(BASE_URL . 'admin/team');
    }

    public function delete(string $id): void
    {
        $this->requireLogin();
        $teamModel = new Team();
        $teamModel->delete('team_members', ['id' => (int)$id]);
        set_flash('success', 'Team member removed.');
        $this->redirect(BASE_URL . 'admin/team');
    }
}
