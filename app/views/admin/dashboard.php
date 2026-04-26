<?php $title = 'Dashboard'; ?>

<!-- Stats Row -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="dash-card">
        <div class="flex items-start justify-between">
            <div>
                <div class="dash-card-label uppercase tracking-wider mb-1">Total Projects</div>
                <div class="dash-card-value text-orange-500"><?= number_format($totalProjects) ?></div>
            </div>
            <div class="p-3 bg-orange-50 rounded-lg text-orange-500">
                <i data-lucide="folder-kanban" class="w-6 h-6"></i>
            </div>
        </div>
        <div class="mt-4 flex items-center gap-4 text-sm">
            <span class="text-green-600 font-medium flex items-center gap-1"><i data-lucide="check-circle-2" class="w-4 h-4"></i> <?= $completedProjects ?> Completed</span>
            <span class="text-blue-600 font-medium flex items-center gap-1"><i data-lucide="loader-2" class="w-4 h-4"></i> <?= $ongoingProjects ?> Ongoing</span>
        </div>
    </div>
    
    <div class="dash-card border-l-green-500">
        <div class="flex items-start justify-between">
            <div>
                <div class="dash-card-label uppercase tracking-wider mb-1">Project Expenses (<?= date('M') ?>)</div>
                <div class="dash-card-value text-green-600"><?= format_currency($monthlyTotals['project_total']) ?></div>
            </div>
            <div class="p-3 bg-green-50 rounded-lg text-green-500">
                <i data-lucide="circle-dollar-sign" class="w-6 h-6"></i>
            </div>
        </div>
    </div>
    
    <div class="dash-card border-l-blue-500">
        <div class="flex items-start justify-between">
            <div>
                <div class="dash-card-label uppercase tracking-wider mb-1">Company Expenses (<?= date('M') ?>)</div>
                <div class="dash-card-value text-blue-600"><?= format_currency($monthlyTotals['company_total']) ?></div>
            </div>
            <div class="p-3 bg-blue-50 rounded-lg text-blue-500">
                <i data-lucide="building-2" class="w-6 h-6"></i>
            </div>
        </div>
    </div>

    <div class="dash-card border-l-red-500">
        <div class="flex items-start justify-between">
            <div>
                <div class="dash-card-label uppercase tracking-wider mb-1">Unread Messages</div>
                <div class="dash-card-value text-red-500"><?= number_format($unreadMessages) ?></div>
            </div>
            <div class="p-3 bg-red-50 rounded-lg text-red-500">
                <i data-lucide="mail-warning" class="w-6 h-6"></i>
            </div>
        </div>
        <?php if ($unreadMessages > 0): ?>
            <div class="mt-4">
                <a href="<?= base_url('admin/contacts') ?>" class="text-sm font-semibold text-red-500 hover:text-red-700 flex items-center gap-1">View Messages <i data-lucide="arrow-right" class="w-4 h-4"></i></a>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Charts Row -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
    <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <h3 class="font-bold text-gray-800 mb-6 flex items-center gap-2">
            <i data-lucide="bar-chart-3" class="w-5 h-5 text-gray-400"></i> Expense Overview (Last 6 Months)
        </h3>
        <div class="h-[300px]">
            <canvas id="expenseChart"></canvas>
        </div>
    </div>
    
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <h3 class="font-bold text-gray-800 mb-6 flex items-center gap-2">
            <i data-lucide="pie-chart" class="w-5 h-5 text-gray-400"></i> Projects by Type
        </h3>
        <div class="h-[300px] flex items-center justify-center">
            <canvas id="projectTypeChart"></canvas>
        </div>
    </div>
</div>

<!-- Recent Activity Tables -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Recent Projects -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-4 border-b border-gray-100 flex justify-between items-center bg-gray-50">
            <h3 class="font-bold text-gray-800 flex items-center gap-2">
                <i data-lucide="folder-clock" class="w-5 h-5 text-gray-400"></i> Recent Projects
            </h3>
            <a href="<?= base_url('admin/projects') ?>" class="text-sm font-semibold text-orange-500 hover:text-orange-600">View All</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-gray-600">
                <thead class="bg-gray-50 text-gray-500 uppercase text-xs border-b border-gray-100">
                    <tr>
                        <th class="px-4 py-3 font-semibold tracking-wider">Project</th>
                        <th class="px-4 py-3 font-semibold tracking-wider">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <?php if (empty($recentProjects)): ?>
                        <tr><td colspan="2" class="px-4 py-6 text-center text-gray-400">No projects found.</td></tr>
                    <?php else: ?>
                        <?php foreach ($recentProjects as $p): ?>
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3">
                                    <div class="font-semibold text-gray-800"><?= h($p['title']) ?></div>
                                    <div class="text-xs text-gray-400"><?= h($p['client_name']) ?></div>
                                </td>
                                <td class="px-4 py-3"><?= status_badge($p['status']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Recent Expenses -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-4 border-b border-gray-100 flex justify-between items-center bg-gray-50">
            <h3 class="font-bold text-gray-800 flex items-center gap-2">
                <i data-lucide="receipt" class="w-5 h-5 text-gray-400"></i> Recent Expenses
            </h3>
            <a href="<?= base_url('admin/expenses/project') ?>" class="text-sm font-semibold text-orange-500 hover:text-orange-600">View All</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-gray-600">
                <thead class="bg-gray-50 text-gray-500 uppercase text-xs border-b border-gray-100">
                    <tr>
                        <th class="px-4 py-3 font-semibold tracking-wider">Expense</th>
                        <th class="px-4 py-3 font-semibold tracking-wider text-right">Amount</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <?php if (empty($recentExpenses)): ?>
                        <tr><td colspan="2" class="px-4 py-6 text-center text-gray-400">No expenses recorded.</td></tr>
                    <?php else: ?>
                        <?php foreach ($recentExpenses as $e): ?>
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3">
                                    <div class="font-semibold text-gray-800"><?= h($e['title']) ?></div>
                                    <div class="text-xs flex items-center gap-1">
                                        <?php if ($e['expense_type'] === 'project'): ?>
                                            <span class="bg-green-100 text-green-700 px-1.5 py-0.5 rounded text-[10px] uppercase font-bold">Project</span>
                                        <?php else: ?>
                                            <span class="bg-blue-100 text-blue-700 px-1.5 py-0.5 rounded text-[10px] uppercase font-bold">Company</span>
                                        <?php endif; ?>
                                        <span class="text-gray-400 line-clamp-1 max-w-[150px]"><?= h($e['reference']) ?></span>
                                    </div>
                                </td>
                                <td class="px-4 py-3 text-right font-bold text-gray-800">
                                    <?= format_currency($e['amount']) ?>
                                    <div class="text-xs text-gray-400 font-normal"><?= format_date($e['expense_date'], 'd M, y') ?></div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php
// Prepare chart data
$months = [];
$projExpData = [];
$compExpData = [];

// Merge and align months for bar chart
$allMonths = array_unique(array_merge(
    array_column($monthlyProjectExp, 'month'),
    array_column($monthlyCompanyExp, 'month')
));
sort($allMonths);

foreach ($allMonths as $m) {
    $months[] = date('M Y', strtotime($m . '-01'));
    
    $pVal = 0;
    foreach ($monthlyProjectExp as $pe) {
        if ($pe['month'] === $m) $pVal = $pe['total'];
    }
    $projExpData[] = $pVal;

    $cVal = 0;
    foreach ($monthlyCompanyExp as $ce) {
        if ($ce['month'] === $m) $cVal = $ce['total'];
    }
    $compExpData[] = $cVal;
}

// Doughnut chart data
$ptLabels = [];
$ptData = [];
$ptColors = ['#F47920', '#2D2D2D', '#3b82f6', '#10b981', '#f59e0b', '#8b5cf6', '#ef4444', '#64748b'];

foreach ($projectsByType as $pt) {
    $ptLabels[] = ucwords(str_replace('_', ' ', $pt['project_type']));
    $ptData[] = $pt['cnt'];
}
?>

<?php ob_start(); ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Expense Bar Chart
    const expenseCtx = document.getElementById('expenseChart').getContext('2d');
    new Chart(expenseCtx, {
        type: 'bar',
        data: {
            labels: <?= json_encode($months) ?>,
            datasets: [
                {
                    label: 'Project Expenses',
                    data: <?= json_encode($projExpData) ?>,
                    backgroundColor: 'rgba(16, 185, 129, 0.8)', // Emerald
                    borderColor: 'rgb(16, 185, 129)',
                    borderWidth: 1,
                    borderRadius: 4
                },
                {
                    label: 'Company Expenses',
                    data: <?= json_encode($compExpData) ?>,
                    backgroundColor: 'rgba(59, 130, 246, 0.8)', // Blue
                    borderColor: 'rgb(59, 130, 246)',
                    borderWidth: 1,
                    borderRadius: 4
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { position: 'top' },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            let label = context.dataset.label || '';
                            if (label) label += ': ';
                            if (context.parsed.y !== null) {
                                label += new Intl.NumberFormat('en-BD', { style: 'currency', currency: 'BDT' }).format(context.parsed.y);
                            }
                            return label;
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: { color: 'rgba(0,0,0,0.05)' }
                },
                x: {
                    grid: { display: false }
                }
            }
        }
    });

    // Project Type Doughnut Chart
    const pTypeCtx = document.getElementById('projectTypeChart').getContext('2d');
    new Chart(pTypeCtx, {
        type: 'doughnut',
        data: {
            labels: <?= json_encode($ptLabels) ?>,
            datasets: [{
                data: <?= json_encode($ptData) ?>,
                backgroundColor: <?= json_encode($ptColors) ?>,
                borderWidth: 2,
                borderColor: '#ffffff'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { position: 'bottom' }
            },
            cutout: '65%'
        }
    });
});
</script>
<?php $scripts = ob_get_clean(); ?>
