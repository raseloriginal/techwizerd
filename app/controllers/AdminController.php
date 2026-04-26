<?php
class AdminController extends Controller
{
    public function dashboard(): void
    {
        $this->requireLogin();

        $projectModel = new Project();
        $expenseModel = new Expense();
        $contactModel = new Contact();

        // Stats
        $totalProjects  = $projectModel->count('projects', ['is_active' => 1]);
        $ongoingProjects = $projectModel->count('projects', ['status' => 'ongoing', 'is_active' => 1]);
        $completedProjects = $projectModel->count('projects', ['status' => 'completed', 'is_active' => 1]);
        $unreadMessages = $contactModel->countUnread();
        $monthlyTotals  = $expenseModel->getThisMonthTotals();

        // Chart data
        $monthlyProjectExp = $expenseModel->getMonthlyProjectExpenses(6);
        $monthlyCompanyExp = $expenseModel->getMonthlyCompanyExpenses(6);
        $projectsByType    = $projectModel->getStatsByType();

        // Recent records
        $recentProjects = $projectModel->getAdminList([], 5, 0);
        $recentExpenses = $expenseModel->getRecentExpenses(5);
        $recentMessages = $contactModel->getRecent(5);

        $admin = $_SESSION[ADMIN_SESSION_KEY];
        $flash = flash();

        $this->view('admin/dashboard', compact(
            'totalProjects', 'ongoingProjects', 'completedProjects',
            'unreadMessages', 'monthlyTotals',
            'monthlyProjectExp', 'monthlyCompanyExp', 'projectsByType',
            'recentProjects', 'recentExpenses', 'recentMessages',
            'admin', 'flash'
        ), 'admin');
    }
}
