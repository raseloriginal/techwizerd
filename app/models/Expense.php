<?php
class Expense extends Model
{
    // ==================== PROJECT EXPENSES ====================

    public function getProjectExpenses(array $filters = [], int $limit = 20, int $offset = 0): array
    {
        $params = [];
        $where = ['1=1'];

        if (!empty($filters['project_id'])) {
            $where[] = 'pe.project_id = ?';
            $params[] = $filters['project_id'];
        }
        if (!empty($filters['category_id'])) {
            $where[] = 'pe.category_id = ?';
            $params[] = $filters['category_id'];
        }
        if (!empty($filters['status'])) {
            $where[] = 'pe.status = ?';
            $params[] = $filters['status'];
        }
        if (!empty($filters['date_from'])) {
            $where[] = 'pe.expense_date >= ?';
            $params[] = $filters['date_from'];
        }
        if (!empty($filters['date_to'])) {
            $where[] = 'pe.expense_date <= ?';
            $params[] = $filters['date_to'];
        }
        if (!empty($filters['search'])) {
            $where[] = '(pe.title LIKE ? OR pe.paid_to LIKE ?)';
            $params[] = '%' . $filters['search'] . '%';
            $params[] = '%' . $filters['search'] . '%';
        }

        $whereSQL = implode(' AND ', $where);
        $limitSQL = $limit > 0 ? "LIMIT {$limit} OFFSET {$offset}" : '';

        $sql = "SELECT pe.*, p.title AS project_title, ec.name AS category_name 
                FROM project_expenses pe 
                LEFT JOIN projects p ON pe.project_id = p.id 
                LEFT JOIN expense_categories ec ON pe.category_id = ec.id 
                WHERE {$whereSQL} 
                ORDER BY pe.expense_date DESC, pe.created_at DESC
                {$limitSQL}";
        return $this->rawFetchAll($sql, $params);
    }

    public function countProjectExpenses(array $filters = []): int
    {
        $params = [];
        $where = ['1=1'];

        if (!empty($filters['project_id'])) {
            $where[] = 'project_id = ?';
            $params[] = $filters['project_id'];
        }
        if (!empty($filters['category_id'])) {
            $where[] = 'category_id = ?';
            $params[] = $filters['category_id'];
        }
        if (!empty($filters['status'])) {
            $where[] = 'status = ?';
            $params[] = $filters['status'];
        }

        $sql = "SELECT COUNT(*) FROM project_expenses WHERE " . implode(' AND ', $where);
        return $this->rawCount($sql, $params);
    }

    public function totalProjectExpenses(array $filters = []): float
    {
        $params = [];
        $where = ['1=1'];

        if (!empty($filters['project_id'])) {
            $where[] = 'project_id = ?';
            $params[] = $filters['project_id'];
        }

        $sql = "SELECT COALESCE(SUM(amount), 0) FROM project_expenses WHERE " . implode(' AND ', $where);
        $stmt = $this->query($sql, $params);
        return $stmt ? (float)$stmt->fetchColumn() : 0.0;
    }

    public function getProjectExpenseSummary(): array
    {
        $sql = "SELECT 
                    p.id, p.title, p.contract_value,
                    COALESCE(SUM(pe.amount), 0) AS total_expenses,
                    COUNT(pe.id) AS expense_count
                FROM projects p
                LEFT JOIN project_expenses pe ON p.id = pe.project_id
                WHERE p.is_active = 1
                GROUP BY p.id, p.title, p.contract_value
                ORDER BY total_expenses DESC";
        return $this->rawFetchAll($sql);
    }

    public function getMonthlyProjectExpenses(int $months = 6): array
    {
        $sql = "SELECT 
                    DATE_FORMAT(expense_date, '%Y-%m') AS month,
                    COALESCE(SUM(amount), 0) AS total
                FROM project_expenses 
                WHERE expense_date >= DATE_SUB(CURDATE(), INTERVAL ? MONTH)
                GROUP BY month
                ORDER BY month ASC";
        return $this->rawFetchAll($sql, [$months]);
    }

    public function getProjectExpenseById(int $id): ?array
    {
        $sql = "SELECT pe.*, p.title AS project_title, ec.name AS category_name 
                FROM project_expenses pe 
                LEFT JOIN projects p ON pe.project_id = p.id 
                LEFT JOIN expense_categories ec ON pe.category_id = ec.id 
                WHERE pe.id = ? LIMIT 1";
        return $this->rawFetchOne($sql, [$id]);
    }

    // ==================== COMPANY EXPENSES ====================

    public function getCompanyExpenses(array $filters = [], int $limit = 20, int $offset = 0): array
    {
        $params = [];
        $where = ['1=1'];

        if (!empty($filters['category_id'])) {
            $where[] = 'ce.category_id = ?';
            $params[] = $filters['category_id'];
        }
        if (!empty($filters['status'])) {
            $where[] = 'ce.status = ?';
            $params[] = $filters['status'];
        }
        if (!empty($filters['fiscal_year'])) {
            $where[] = 'ce.fiscal_year = ?';
            $params[] = $filters['fiscal_year'];
        }
        if (!empty($filters['month'])) {
            $where[] = 'ce.month = ?';
            $params[] = $filters['month'];
        }
        if (!empty($filters['year'])) {
            $where[] = 'YEAR(ce.expense_date) = ?';
            $params[] = $filters['year'];
        }

        $whereSQL = implode(' AND ', $where);
        $limitSQL = $limit > 0 ? "LIMIT {$limit} OFFSET {$offset}" : '';

        $sql = "SELECT ce.*, ec.name AS category_name 
                FROM company_expenses ce 
                LEFT JOIN expense_categories ec ON ce.category_id = ec.id 
                WHERE {$whereSQL} 
                ORDER BY ce.expense_date DESC, ce.created_at DESC
                {$limitSQL}";
        return $this->rawFetchAll($sql, $params);
    }

    public function countCompanyExpenses(array $filters = []): int
    {
        $params = [];
        $where = ['1=1'];

        if (!empty($filters['category_id'])) {
            $where[] = 'category_id = ?';
            $params[] = $filters['category_id'];
        }
        if (!empty($filters['status'])) {
            $where[] = 'status = ?';
            $params[] = $filters['status'];
        }

        $sql = "SELECT COUNT(*) FROM company_expenses WHERE " . implode(' AND ', $where);
        return $this->rawCount($sql, $params);
    }

    public function totalCompanyExpenses(array $filters = []): float
    {
        $params = [];
        $where = ['1=1'];

        if (!empty($filters['month'])) {
            $where[] = 'month = ?';
            $params[] = $filters['month'];
        }
        if (!empty($filters['year'])) {
            $where[] = 'YEAR(expense_date) = ?';
            $params[] = $filters['year'];
        }

        $sql = "SELECT COALESCE(SUM(amount), 0) FROM company_expenses WHERE " . implode(' AND ', $where);
        $stmt = $this->query($sql, $params);
        return $stmt ? (float)$stmt->fetchColumn() : 0.0;
    }

    public function getCompanyExpenseById(int $id): ?array
    {
        $sql = "SELECT ce.*, ec.name AS category_name 
                FROM company_expenses ce 
                LEFT JOIN expense_categories ec ON ce.category_id = ec.id 
                WHERE ce.id = ? LIMIT 1";
        return $this->rawFetchOne($sql, [$id]);
    }

    public function getMonthlyCompanyExpenses(int $months = 12): array
    {
        $sql = "SELECT 
                    DATE_FORMAT(expense_date, '%Y-%m') AS month,
                    COALESCE(SUM(amount), 0) AS total
                FROM company_expenses 
                WHERE expense_date >= DATE_SUB(CURDATE(), INTERVAL ? MONTH)
                GROUP BY month
                ORDER BY month ASC";
        return $this->rawFetchAll($sql, [$months]);
    }

    public function getCompanyExpenseByCategoryForMonth(int $year, int $month): array
    {
        $sql = "SELECT ec.name AS category_name, COALESCE(SUM(ce.amount), 0) AS total
                FROM company_expenses ce
                LEFT JOIN expense_categories ec ON ce.category_id = ec.id
                WHERE YEAR(ce.expense_date) = ? AND MONTH(ce.expense_date) = ?
                GROUP BY ec.name
                ORDER BY total DESC";
        return $this->rawFetchAll($sql, [$year, $month]);
    }

    // ==================== CATEGORIES ====================

    public function getCategories(string $type = ''): array
    {
        if ($type) {
            return $this->findAll('expense_categories', ['type' => $type], 'name ASC');
        }
        return $this->findAll('expense_categories', [], 'type ASC, name ASC');
    }

    // ==================== DASHBOARD ====================

    public function getThisMonthTotals(): array
    {
        $projSQL = "SELECT COALESCE(SUM(amount), 0) FROM project_expenses WHERE MONTH(expense_date) = MONTH(CURDATE()) AND YEAR(expense_date) = YEAR(CURDATE())";
        $compSQL = "SELECT COALESCE(SUM(amount), 0) FROM company_expenses WHERE MONTH(expense_date) = MONTH(CURDATE()) AND YEAR(expense_date) = YEAR(CURDATE())";

        $projStmt = $this->query($projSQL);
        $compStmt = $this->query($compSQL);

        return [
            'project_total' => $projStmt ? (float)$projStmt->fetchColumn() : 0.0,
            'company_total' => $compStmt ? (float)$compStmt->fetchColumn() : 0.0,
        ];
    }

    public function getRecentExpenses(int $limit = 5): array
    {
        $sql = "SELECT 'project' AS expense_type, pe.title, pe.amount, pe.expense_date, p.title AS reference
                FROM project_expenses pe
                LEFT JOIN projects p ON pe.project_id = p.id
                UNION ALL
                SELECT 'company' AS expense_type, ce.title, ce.amount, ce.expense_date, ec.name AS reference
                FROM company_expenses ce
                LEFT JOIN expense_categories ec ON ce.category_id = ec.id
                ORDER BY expense_date DESC
                LIMIT ?";
        return $this->rawFetchAll($sql, [$limit]);
    }
}
