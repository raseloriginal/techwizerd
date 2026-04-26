<?php
class ExpenseController extends Controller
{
    // ==================== PROJECT EXPENSES ====================

    public function projectIndex(): void
    {
        $this->requireLogin();
        $expenseModel = new Expense();
        $projectModel = new Project();

        $filters = [
            'project_id'  => $_GET['project_id'] ?? '',
            'category_id' => $_GET['category_id'] ?? '',
            'status'      => $_GET['status'] ?? '',
            'date_from'   => $_GET['date_from'] ?? '',
            'date_to'     => $_GET['date_to'] ?? '',
            'search'      => $_GET['search'] ?? '',
        ];

        $page    = max(1, (int)($_GET['page'] ?? 1));
        $perPage = 20;
        $total   = $expenseModel->countProjectExpenses($filters);
        $pager   = paginate($total, $perPage, $page);
        $expenses   = $expenseModel->getProjectExpenses($filters, $perPage, $pager['offset']);
        $grandTotal = $expenseModel->totalProjectExpenses($filters);
        $projects   = $projectModel->getAllWithClient([], 100, 0);
        $categories = $expenseModel->getCategories('project');
        $flash = flash();

        $this->view('admin/expenses/project-list', compact(
            'expenses', 'filters', 'pager', 'grandTotal', 'projects', 'categories', 'flash'
        ), 'admin');
    }

    public function projectCreate(): void
    {
        $this->requireLogin();
        $expenseModel = new Expense();
        $projectModel = new Project();
        $projects     = $projectModel->getAllWithClient([], 200, 0);
        $categories   = $expenseModel->getCategories('project');
        $flash        = flash();
        $this->view('admin/expenses/project-create', compact('projects', 'categories', 'flash'), 'admin');
    }

    public function projectStore(): void
    {
        $this->requireLogin();
        if (!$this->csrfCheck()) {
            set_flash('error', 'Invalid CSRF token.');
            $this->redirect(BASE_URL . 'admin/expenses/project/create');
            return;
        }

        $data = [
            'project_id'     => (int)($_POST['project_id'] ?? 0),
            'category_id'    => !empty($_POST['category_id']) ? (int)$_POST['category_id'] : null,
            'title'          => $this->sanitize($_POST['title'] ?? ''),
            'description'    => $this->sanitize($_POST['description'] ?? ''),
            'amount'         => (float)($_POST['amount'] ?? 0),
            'expense_date'   => $_POST['expense_date'] ?? date('Y-m-d'),
            'payment_method' => $this->sanitize($_POST['payment_method'] ?? 'cash'),
            'paid_to'        => $this->sanitize($_POST['paid_to'] ?? ''),
            'approved_by'    => $this->sanitize($_POST['approved_by'] ?? ''),
            'status'         => $this->sanitize($_POST['status'] ?? 'pending'),
            'notes'          => $this->sanitize($_POST['notes'] ?? ''),
            'created_by'     => $_SESSION[ADMIN_SESSION_KEY]['id'] ?? null,
        ];

        $receiptFile = $_FILES['receipt'] ?? $_FILES['receipt_image'] ?? null;
        if ($receiptFile && !empty($receiptFile['name'])) {
            $uploaded = upload_file($receiptFile, 'receipts', ['jpg', 'jpeg', 'png', 'pdf']);
            if ($uploaded) $data['receipt_image'] = $uploaded;
        }

        $expenseModel = new Expense();
        $id = $expenseModel->insert('project_expenses', $data);

        if ($id) {
            set_flash('success', 'Project expense added successfully!');
            $this->redirect(BASE_URL . 'admin/expenses/project');
        } else {
            set_flash('error', 'Failed to add expense.');
            $this->redirect(BASE_URL . 'admin/expenses/project/create');
        }
    }

    public function projectEdit(string $id): void
    {
        $this->requireLogin();
        $expenseModel = new Expense();
        $expense      = $expenseModel->getProjectExpenseById((int)$id);

        if (!$expense) {
            set_flash('error', 'Expense not found.');
            $this->redirect(BASE_URL . 'admin/expenses/project');
            return;
        }

        $projectModel = new Project();
        $projects     = $projectModel->getAllWithClient([], 200, 0);
        $categories   = $expenseModel->getCategories('project');
        $flash        = flash();
        $this->view('admin/expenses/project-edit', compact('expense', 'projects', 'categories', 'flash'), 'admin');
    }

    public function projectUpdate(string $id): void
    {
        $this->requireLogin();
        if (!$this->csrfCheck()) {
            set_flash('error', 'Invalid CSRF token.');
            $this->redirect(BASE_URL . 'admin/expenses/project/edit/' . $id);
            return;
        }

        $data = [
            'project_id'     => (int)($_POST['project_id'] ?? 0),
            'category_id'    => !empty($_POST['category_id']) ? (int)$_POST['category_id'] : null,
            'title'          => $this->sanitize($_POST['title'] ?? ''),
            'description'    => $this->sanitize($_POST['description'] ?? ''),
            'amount'         => (float)($_POST['amount'] ?? 0),
            'expense_date'   => $_POST['expense_date'] ?? date('Y-m-d'),
            'payment_method' => $this->sanitize($_POST['payment_method'] ?? 'cash'),
            'paid_to'        => $this->sanitize($_POST['paid_to'] ?? ''),
            'approved_by'    => $this->sanitize($_POST['approved_by'] ?? ''),
            'status'         => $this->sanitize($_POST['status'] ?? 'pending'),
            'notes'          => $this->sanitize($_POST['notes'] ?? ''),
        ];

        $expenseModel = new Expense();
        $expense = $expenseModel->getProjectExpenseById((int)$id);

        // Handle receipt deletion
        if (!empty($_POST['delete_receipt']) && $expense['receipt_image']) {
            delete_file($expense['receipt_image']);
            $data['receipt_image'] = null;
        }

        // Handle new receipt upload
        $receiptFile = $_FILES['receipt'] ?? $_FILES['receipt_image'] ?? null;
        if ($receiptFile && !empty($receiptFile['name'])) {
            // Delete old file if exists
            if ($expense['receipt_image']) {
                delete_file($expense['receipt_image']);
            }
            $uploaded = upload_file($receiptFile, 'receipts', ['jpg', 'jpeg', 'png', 'pdf']);
            if ($uploaded) $data['receipt_image'] = $uploaded;
        }

        $expenseModel->update('project_expenses', $data, ['id' => (int)$id]);
        set_flash('success', 'Expense updated successfully!');
        $this->redirect(BASE_URL . 'admin/expenses/project');
    }

    public function projectDelete(string $id): void
    {
        $this->requireLogin();
        $expenseModel = new Expense();
        $expenseModel->delete('project_expenses', ['id' => (int)$id]);
        set_flash('success', 'Expense deleted.');
        $this->redirect(BASE_URL . 'admin/expenses/project');
    }

    public function projectSummary(): void
    {
        $this->requireLogin();
        $expenseModel = new Expense();
        $summary      = $expenseModel->getProjectExpenseSummary();
        $flash        = flash();
        $this->view('admin/expenses/project-summary', compact('summary', 'flash'), 'admin');
    }

    // ==================== COMPANY EXPENSES ====================

    public function companyIndex(): void
    {
        $this->requireLogin();
        $expenseModel = new Expense();

        $filters = [
            'category_id' => $_GET['category_id'] ?? '',
            'status'      => $_GET['status'] ?? '',
            'fiscal_year' => $_GET['fiscal_year'] ?? '',
            'month'       => $_GET['month'] ?? '',
            'year'        => $_GET['year'] ?? '',
        ];

        $page    = max(1, (int)($_GET['page'] ?? 1));
        $perPage = 20;
        $total   = $expenseModel->countCompanyExpenses($filters);
        $pager   = paginate($total, $perPage, $page);
        $expenses   = $expenseModel->getCompanyExpenses($filters, $perPage, $pager['offset']);
        $grandTotal = $expenseModel->totalCompanyExpenses($filters);
        $categories = $expenseModel->getCategories('company');
        $flash      = flash();

        $this->view('admin/expenses/company-list', compact(
            'expenses', 'filters', 'pager', 'grandTotal', 'categories', 'flash'
        ), 'admin');
    }

    public function companyCreate(): void
    {
        $this->requireLogin();
        $expenseModel = new Expense();
        $categories   = $expenseModel->getCategories('company');
        $flash        = flash();
        $this->view('admin/expenses/company-create', compact('categories', 'flash'), 'admin');
    }

    public function companyStore(): void
    {
        $this->requireLogin();
        if (!$this->csrfCheck()) {
            set_flash('error', 'Invalid CSRF token.');
            $this->redirect(BASE_URL . 'admin/expenses/company/create');
            return;
        }

        $expDate = $_POST['expense_date'] ?? date('Y-m-d');
        $data = [
            'category_id'    => !empty($_POST['category_id']) ? (int)$_POST['category_id'] : null,
            'title'          => $this->sanitize($_POST['title'] ?? ''),
            'description'    => $this->sanitize($_POST['description'] ?? ''),
            'amount'         => (float)($_POST['amount'] ?? 0),
            'expense_date'   => $expDate,
            'payment_method' => $this->sanitize($_POST['payment_method'] ?? 'cash'),
            'paid_to'        => $this->sanitize($_POST['paid_to'] ?? ''),
            'approved_by'    => $this->sanitize($_POST['approved_by'] ?? ''),
            'fiscal_year'    => $this->sanitize($_POST['fiscal_year'] ?? ''),
            'month'          => (int)date('m', strtotime($expDate)),
            'status'         => $this->sanitize($_POST['status'] ?? 'pending'),
            'notes'          => $this->sanitize($_POST['notes'] ?? ''),
            'created_by'     => $_SESSION[ADMIN_SESSION_KEY]['id'] ?? null,
        ];

        if (!empty($_FILES['receipt_image']['name'])) {
            $uploaded = upload_file($_FILES['receipt_image'], 'receipts', ['jpg', 'jpeg', 'png', 'pdf']);
            if ($uploaded) $data['receipt_image'] = $uploaded;
        }

        $expenseModel = new Expense();
        $id = $expenseModel->insert('company_expenses', $data);

        if ($id) {
            set_flash('success', 'Company expense added successfully!');
            $this->redirect(BASE_URL . 'admin/expenses/company');
        } else {
            set_flash('error', 'Failed to add expense.');
            $this->redirect(BASE_URL . 'admin/expenses/company/create');
        }
    }

    public function companyEdit(string $id): void
    {
        $this->requireLogin();
        $expenseModel = new Expense();
        $expense      = $expenseModel->getCompanyExpenseById((int)$id);

        if (!$expense) {
            set_flash('error', 'Expense not found.');
            $this->redirect(BASE_URL . 'admin/expenses/company');
            return;
        }

        $categories = $expenseModel->getCategories('company');
        $flash      = flash();
        $this->view('admin/expenses/company-edit', compact('expense', 'categories', 'flash'), 'admin');
    }

    public function companyUpdate(string $id): void
    {
        $this->requireLogin();
        if (!$this->csrfCheck()) {
            set_flash('error', 'Invalid CSRF token.');
            $this->redirect(BASE_URL . 'admin/expenses/company/edit/' . $id);
            return;
        }

        $expDate = $_POST['expense_date'] ?? date('Y-m-d');
        $data = [
            'category_id'    => !empty($_POST['category_id']) ? (int)$_POST['category_id'] : null,
            'title'          => $this->sanitize($_POST['title'] ?? ''),
            'description'    => $this->sanitize($_POST['description'] ?? ''),
            'amount'         => (float)($_POST['amount'] ?? 0),
            'expense_date'   => $expDate,
            'payment_method' => $this->sanitize($_POST['payment_method'] ?? 'cash'),
            'paid_to'        => $this->sanitize($_POST['paid_to'] ?? ''),
            'approved_by'    => $this->sanitize($_POST['approved_by'] ?? ''),
            'fiscal_year'    => $this->sanitize($_POST['fiscal_year'] ?? ''),
            'month'          => (int)date('m', strtotime($expDate)),
            'status'         => $this->sanitize($_POST['status'] ?? 'pending'),
            'notes'          => $this->sanitize($_POST['notes'] ?? ''),
        ];

        $expenseModel = new Expense();
        $expense = $expenseModel->getCompanyExpenseById((int)$id);

        // Handle receipt deletion
        if (!empty($_POST['delete_receipt']) && $expense['receipt_image']) {
            delete_file($expense['receipt_image']);
            $data['receipt_image'] = null;
        }

        // Handle new receipt upload
        $receiptFile = $_FILES['receipt'] ?? $_FILES['receipt_image'] ?? null;
        if ($receiptFile && !empty($receiptFile['name'])) {
            // Delete old file if exists
            if ($expense['receipt_image']) {
                delete_file($expense['receipt_image']);
            }
            $uploaded = upload_file($receiptFile, 'receipts', ['jpg', 'jpeg', 'png', 'pdf']);
            if ($uploaded) $data['receipt_image'] = $uploaded;
        }

        $expenseModel->update('company_expenses', $data, ['id' => (int)$id]);
        set_flash('success', 'Expense updated successfully!');
        $this->redirect(BASE_URL . 'admin/expenses/company');
    }

    public function companyDelete(string $id): void
    {
        $this->requireLogin();
        $expenseModel = new Expense();
        $expenseModel->delete('company_expenses', ['id' => (int)$id]);
        set_flash('success', 'Expense deleted.');
        $this->redirect(BASE_URL . 'admin/expenses/company');
    }

    public function companySummary(): void
    {
        $this->requireLogin();
        $expenseModel = new Expense();
        $year  = (int)($_GET['year'] ?? date('Y'));
        $month = (int)($_GET['month'] ?? date('m'));
        $byCategory = $expenseModel->getCompanyExpenseByCategoryForMonth($year, $month);
        $monthly    = $expenseModel->getMonthlyCompanyExpenses(12);
        $flash      = flash();
        $this->view('admin/expenses/company-summary', compact('byCategory', 'monthly', 'year', 'month', 'flash'), 'admin');
    }

    public function exportCsv(string $type): void
    {
        $this->requireLogin();
        $expenseModel = new Expense();

        if ($type === 'project') {
            $filters  = [
                'project_id'  => $_GET['project_id'] ?? '',
                'category_id' => $_GET['category_id'] ?? '',
                'status'      => $_GET['status'] ?? '',
            ];
            $expenses = $expenseModel->getProjectExpenses($filters, 0, 0);
            $headers  = ['ID', 'Project', 'Category', 'Title', 'Amount (BDT)', 'Date', 'Payment Method', 'Paid To', 'Status'];
            $rows     = array_map(fn($e) => [
                $e['id'], $e['project_title'], $e['category_name'],
                $e['title'], $e['amount'], $e['expense_date'],
                $e['payment_method'], $e['paid_to'], $e['status']
            ], $expenses);
            $filename = 'project-expenses-' . date('Y-m-d') . '.csv';
        } else {
            $filters  = [
                'category_id' => $_GET['category_id'] ?? '',
                'fiscal_year' => $_GET['fiscal_year'] ?? '',
                'month'       => $_GET['month'] ?? '',
            ];
            $expenses = $expenseModel->getCompanyExpenses($filters, 0, 0);
            $headers  = ['ID', 'Category', 'Title', 'Amount (BDT)', 'Date', 'Fiscal Year', 'Payment Method', 'Paid To', 'Status'];
            $rows     = array_map(fn($e) => [
                $e['id'], $e['category_name'], $e['title'],
                $e['amount'], $e['expense_date'], $e['fiscal_year'],
                $e['payment_method'], $e['paid_to'], $e['status']
            ], $expenses);
            $filename = 'company-expenses-' . date('Y-m-d') . '.csv';
        }

        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Pragma: no-cache');

        $output = fopen('php://output', 'w');
        fputcsv($output, $headers);
        foreach ($rows as $row) {
            fputcsv($output, $row);
        }
        fclose($output);
        exit;
    }
}
