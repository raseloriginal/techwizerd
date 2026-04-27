<?php $title = 'Project Detail: ' . h($project['title']); ?>

<div class="flex justify-between items-center mb-6">
    <div class="flex items-center gap-2">
        <a href="<?= base_url('admin/projects') ?>" class="text-gray-500 hover:text-orange-500"><i data-lucide="arrow-left" class="w-5 h-5"></i></a>
        <h2 class="text-2xl font-bold text-gray-800 m-0 line-clamp-1 flex-1"><?= h($project['title']) ?></h2>
    </div>
    <div class="flex gap-2">
        <a href="<?= base_url('projects/show/' . $project['slug']) ?>" target="_blank" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded font-semibold transition-colors text-sm flex items-center gap-1">
            <i data-lucide="external-link" class="w-4 h-4"></i> Public View
        </a>
        <a href="<?= base_url('admin/projects/edit/' . $project['id']) ?>" class="btn-primary flex items-center gap-1 text-sm">
            <i data-lucide="edit" class="w-4 h-4"></i> Edit Project
        </a>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
    <!-- Main Info -->
    <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 border-b border-gray-100 flex justify-between items-start">
            <div>
                <div class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">
                    <?= ucwords(str_replace('_', ' ', $project['project_type'])) ?>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-2"><?= h($project['title']) ?></h3>
                <div class="flex items-center gap-4 text-sm text-gray-500">
                    <span class="flex items-center gap-1"><i data-lucide="map-pin" class="w-4 h-4"></i> <?= h($project['location'] ?: 'N/A') ?></span>
                    <span class="flex items-center gap-1"><i data-lucide="building" class="w-4 h-4"></i> <?= h($project['client_name'] ?? 'No Client') ?></span>
                </div>
            </div>
            <div>
                <?= status_badge($project['status']) ?>
            </div>
        </div>
        
        <div class="p-6">
            <h4 class="font-bold text-gray-800 mb-2">Description</h4>
            <div class="text-gray-600 whitespace-pre-line mb-6"><?= h($project['description'] ?: 'No description provided.') ?></div>
            
            <h4 class="font-bold text-gray-800 mb-2">Scope of Work</h4>
            <div class="text-gray-600 whitespace-pre-line"><?= h($project['scope'] ?: 'No scope provided.') ?></div>
        </div>
        
        <div class="bg-gray-50 p-6 grid grid-cols-2 md:grid-cols-4 gap-4 border-t border-gray-100">
            <div>
                <div class="text-xs text-gray-400 font-semibold uppercase tracking-wider mb-1">Start Date</div>
                <div class="font-bold text-gray-800"><?= format_date($project['start_date']) ?></div>
            </div>
            <div>
                <div class="text-xs text-gray-400 font-semibold uppercase tracking-wider mb-1">End Date</div>
                <div class="font-bold text-gray-800"><?= format_date($project['end_date']) ?></div>
            </div>
            <div>
                <div class="text-xs text-gray-400 font-semibold uppercase tracking-wider mb-1">Visibility</div>
                <div class="font-bold text-gray-800">
                    <?= $project['is_active'] ? '<span class="text-green-600">Active</span>' : '<span class="text-red-600">Hidden</span>' ?>
                    <?= $project['is_featured'] ? ' &bull; Featured' : '' ?>
                </div>
            </div>
            <div>
                <div class="text-xs text-gray-400 font-semibold uppercase tracking-wider mb-1">Created</div>
                <div class="font-bold text-gray-800"><?= format_date($project['created_at']) ?></div>
            </div>
        </div>
    </div>

    <!-- Financials & Image -->
    <div class="space-y-6">
        <?php if ($project['featured_image']): ?>
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <img src="<?= upload_url($project['featured_image']) ?>" class="w-full h-48 object-cover">
            </div>
        <?php endif; ?>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 border-t-4 border-t-orange-500">
            <h3 class="font-bold text-gray-800 mb-4 flex items-center gap-2">
                <i data-lucide="circle-dollar-sign" class="w-5 h-5 text-orange-500"></i> Financial Summary
            </h3>
            
            <div class="space-y-4">
                <div class="flex justify-between">
                    <span class="text-gray-500">Contract Value:</span>
                    <span class="font-bold text-gray-800 text-lg"><?= format_currency($project['contract_value']) ?></span>
                </div>
                <div class="flex justify-between border-b border-gray-100 pb-2">
                    <span class="text-gray-500">Total Expenses:</span>
                    <span class="font-bold text-red-600 text-lg">- <?= format_currency((float)$expSummary['total_expenses']) ?></span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500 font-semibold">Remaining / Profit:</span>
                    <?php $remaining = $project['contract_value'] - (float)$expSummary['total_expenses']; ?>
                    <span class="font-bold text-xl <?= $remaining < 0 ? 'text-red-600' : 'text-green-600' ?>">
                        <?= format_currency($remaining) ?>
                    </span>
                </div>
                
                <?php 
                $percent = $project['contract_value'] > 0 ? ((float)$expSummary['total_expenses'] / $project['contract_value']) * 100 : 0;
                $pClass = $percent > 90 ? 'bg-danger' : ($percent > 75 ? 'bg-orange-500' : 'bg-success');
                ?>
                <div class="pt-2">
                    <div class="flex justify-between text-xs mb-1">
                        <span class="text-gray-500">Budget Consumed</span>
                        <span class="font-bold"><?= number_format($percent, 1) ?>%</span>
                    </div>
                    <div class="progress-bar-track">
                        <div class="progress-bar-fill <?= $pClass ?>" style="width: <?= min(100, $percent) ?>%"></div>
                    </div>
                </div>
            </div>
            
            <div class="mt-6">
                <a href="<?= base_url('admin/expenses/project/create?project_id=' . $project['id']) ?>" class="btn-primary w-full text-center text-sm py-2">
                    <i data-lucide="plus" class="w-4 h-4 inline mr-1"></i> Add Expense
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Project Expenses -->
<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden mb-6">
    <div class="p-4 border-b border-gray-100 flex justify-between items-center bg-gray-50">
        <h3 class="font-bold text-gray-800 flex items-center gap-2">
            <i data-lucide="receipt" class="w-5 h-5 text-gray-400"></i> Recent Expenses
        </h3>
        <a href="<?= base_url('admin/expenses/project?project_id=' . $project['id']) ?>" class="text-sm font-semibold text-orange-500 hover:text-orange-600">View All</a>
    </div>
    <div class="data-table-wrapper rounded-none border-0 shadow-none">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Category</th>
                    <th>Title</th>
                    <th>Status</th>
                    <th class="text-right">Amount</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($expenses)): ?>
                    <tr><td colspan="5" class="py-8 text-center text-gray-400">No expenses recorded for this project yet.</td></tr>
                <?php else: ?>
                    <?php foreach ($expenses as $exp): ?>
                        <tr>
                            <td class="text-gray-500 text-sm whitespace-nowrap"><?= format_date($exp['expense_date']) ?></td>
                            <td><span class="bg-gray-100 text-gray-600 px-2 py-1 rounded text-xs font-semibold"><?= h($exp['category_name'] ?? 'Uncategorized') ?></span></td>
                            <td class="font-medium text-gray-800"><?= h($exp['title']) ?></td>
                            <td><?= status_badge($exp['status']) ?></td>
                            <td class="text-right font-bold text-gray-800"><?= format_currency($exp['amount']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Image Gallery -->
<?php if (!empty($images)): ?>
<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
    <h3 class="font-bold text-gray-800 mb-4 flex items-center gap-2">
        <i data-lucide="images" class="w-5 h-5 text-gray-400"></i> Gallery
    </h3>
    <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
        <?php foreach ($images as $img): ?>
            <a href="<?= upload_url($img['image_path']) ?>" target="_blank" class="aspect-square rounded-lg overflow-hidden border border-gray-200 block hover:opacity-80 transition-opacity">
                <img src="<?= upload_url($img['image_path']) ?>" class="w-full h-full object-cover">
            </a>
        <?php endforeach; ?>
    </div>
</div>
<?php endif; ?>
