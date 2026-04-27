<?php
class ProjectController extends Controller
{
    // ==================== PUBLIC ====================

    public function index(): void
    {
        $projectModel = new Project();

        $filters = [
            'type'   => $_GET['type'] ?? '',
            'status' => $_GET['status'] ?? '',
            'search' => $_GET['search'] ?? '',
        ];

        $projects = $projectModel->getAllWithClient($filters);
        $this->view('projects/index', compact('projects', 'filters'));
    }

    public function show(string $slug): void
    {
        $projectModel = new Project();
        $project      = $projectModel->getBySlug($slug);

        if (!$project) {
            http_response_code(404);
            echo '<h1>Project not found</h1>';
            return;
        }

        $images  = $projectModel->getImages($project['id']);
        $related = $projectModel->getRelated($project['id'], $project['project_type'], 3);
        $expSummary = $projectModel->getExpenseSummary($project['id']);

        $this->view('projects/show', compact('project', 'images', 'related', 'expSummary'));
    }

    // ==================== ADMIN ====================

    public function adminIndex(): void
    {
        $this->requireLogin();
        $projectModel = new Project();

        $filters = [
            'type'   => $_GET['type'] ?? '',
            'status' => $_GET['status'] ?? '',
            'search' => $_GET['search'] ?? '',
        ];

        $page    = max(1, (int)($_GET['page'] ?? 1));
        $perPage = 15;
        $total   = $projectModel->countFiltered($filters);
        $pager   = paginate($total, $perPage, $page);
        $projects = $projectModel->getAdminList($filters, $perPage, $pager['offset']);

        $flash = flash();
        $this->view('admin/projects/index', compact('projects', 'filters', 'pager', 'flash'), 'admin');
    }

    public function create(): void
    {
        $this->requireLogin();
        $clientModel = new Client();
        $clients     = $clientModel->getDropdown();
        $flash       = flash();
        $this->view('admin/projects/create', compact('clients', 'flash'), 'admin');
    }

    public function store(): void
    {
        $this->requireLogin();
        if (!$this->csrfCheck()) {
            set_flash('error', 'Invalid CSRF token.');
            $this->redirect(BASE_URL . 'admin/projects/create');
            return;
        }

        $data = $this->extractProjectData($_POST);

        // Handle featured image upload
        if (!empty($_FILES['featured_image']['name'])) {
            $uploaded = upload_file($_FILES['featured_image'], 'projects');
            if ($uploaded) {
                $data['featured_image'] = $uploaded;
            }
        }

        $projectModel = new Project();
        $id = $projectModel->insert('projects', $data);

        if ($id) {
            set_flash('success', 'Project created successfully!');
            $this->redirect(BASE_URL . 'admin/projects/show/' . $id);
        } else {
            set_flash('error', 'Failed to create project.');
            $this->redirect(BASE_URL . 'admin/projects/create');
        }
    }

    public function edit(string $id): void
    {
        $this->requireLogin();
        $projectModel = new Project();
        $project      = $projectModel->findById('projects', (int)$id);

        if (!$project) {
            set_flash('error', 'Project not found.');
            $this->redirect(BASE_URL . 'admin/projects');
            return;
        }

        $clientModel = new Client();
        $clients     = $clientModel->getDropdown();
        $images      = $projectModel->getImages((int)$id);
        $expSummary  = $projectModel->getExpenseSummary((int)$id);
        $flash       = flash();

        $this->view('admin/projects/edit', compact('project', 'clients', 'images', 'expSummary', 'flash'), 'admin');
    }

    public function update(string $id): void
    {
        $this->requireLogin();
        if (!$this->csrfCheck()) {
            set_flash('error', 'Invalid CSRF token.');
            $this->redirect(BASE_URL . 'admin/projects/edit/' . $id);
            return;
        }

        $projectModel = new Project();
        $project      = $projectModel->findById('projects', (int)$id);
        if (!$project) {
            set_flash('error', 'Project not found.');
            $this->redirect(BASE_URL . 'admin/projects');
            return;
        }

        $data = $this->extractProjectData($_POST);

        // Handle featured image upload
        if (!empty($_FILES['featured_image']['name'])) {
            $uploaded = upload_file($_FILES['featured_image'], 'projects');
            if ($uploaded) {
                if ($project['featured_image']) {
                    delete_file($project['featured_image']);
                }
                $data['featured_image'] = $uploaded;
            }
        }

        $projectModel->update('projects', $data, ['id' => (int)$id]);
        set_flash('success', 'Project updated successfully!');
        $this->redirect(BASE_URL . 'admin/projects/edit/' . $id);
    }

    public function adminShow(string $id): void
    {
        $this->requireLogin();
        $projectModel  = new Project();
        $expenseModel  = new Expense();
        $project       = $projectModel->findById('projects', (int)$id);

        if (!$project) {
            set_flash('error', 'Project not found.');
            $this->redirect(BASE_URL . 'admin/projects');
            return;
        }

        $images      = $projectModel->getImages((int)$id);
        $expSummary  = $projectModel->getExpenseSummary((int)$id);
        $expenses    = $expenseModel->getProjectExpenses(['project_id' => (int)$id], 50, 0);
        $flash       = flash();

        $this->view('admin/projects/show', compact('project', 'images', 'expSummary', 'expenses', 'flash'), 'admin');
    }

    public function delete(string $id): void
    {
        $this->requireLogin();
        $projectModel = new Project();
        $projectModel->update('projects', ['is_deleted' => 1], ['id' => (int)$id]);
        set_flash('success', 'Project deleted successfully!');
        $this->redirect(BASE_URL . 'admin/projects');
    }

    public function uploadImage(string $id): void
    {
        $this->requireLogin();
        if (empty($_FILES['image']['name'])) {
            set_flash('error', 'No image selected.');
            $this->redirect(BASE_URL . 'admin/projects/edit/' . $id);
            return;
        }

        $uploaded = upload_file($_FILES['image'], 'projects');
        if (!$uploaded) {
            set_flash('error', 'Image upload failed. Check file type and size (max 5MB).');
            $this->redirect(BASE_URL . 'admin/projects/edit/' . $id);
            return;
        }

        $caption = $this->sanitize($_POST['caption'] ?? '');
        $projectModel = new Project();
        $projectModel->addImage((int)$id, $uploaded, $caption);

        set_flash('success', 'Image uploaded successfully!');
        $this->redirect(BASE_URL . 'admin/projects/edit/' . $id);
    }

    public function deleteImage(string $imageId): void
    {
        $this->requireLogin();
        $projectModel = new Project();
        $imagePath    = $projectModel->deleteImage((int)$imageId);
        if ($imagePath) {
            delete_file($imagePath);
            set_flash('success', 'Image deleted.');
        }
        $referer = $_SERVER['HTTP_REFERER'] ?? BASE_URL . 'admin/projects';
        $this->redirect($referer);
    }

    private function extractProjectData(array $post): array
    {
        $title = $this->sanitize($post['title'] ?? '');
        return [
            'title'          => $title,
            'slug'           => slug($title) . '-' . time(),
            'client_id'      => !empty($post['client_id']) ? (int)$post['client_id'] : null,
            'description'    => $this->sanitize($post['description'] ?? ''),
            'scope'          => $this->sanitize($post['scope'] ?? ''),
            'location'       => $this->sanitize($post['location'] ?? ''),
            'project_type'   => $this->sanitize($post['project_type'] ?? 'other'),
            'status'         => $this->sanitize($post['status'] ?? 'pending'),
            'start_date'     => !empty($post['start_date']) ? $post['start_date'] : null,
            'end_date'       => !empty($post['end_date']) ? $post['end_date'] : null,
            'contract_value' => !empty($post['contract_value']) ? (float)$post['contract_value'] : 0,
            'is_featured'    => isset($post['is_featured']) ? 1 : 0,
            'is_active'      => isset($post['is_active']) ? 1 : 1,
        ];
    }
}
