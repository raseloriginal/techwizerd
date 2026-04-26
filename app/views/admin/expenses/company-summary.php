<?php $title = 'Company Expenses Summary'; ?>

<div class="flex justify-between items-center mb-6">
    <div class="flex items-center gap-3">
        <a href="<?= base_url('admin/expenses/company') ?>" class="text-gray-500 hover:text-orange-500"><i data-lucide="arrow-left" class="w-5 h-5"></i></a>
        <h2 class="text-2xl font-bold text-gray-800 m-0">Company Financial Summary</h2>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
    
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <h3 class="font-bold text-gray-800 mb-6 flex items-center gap-2">
            <i data-lucide="calendar" class="w-5 h-5 text-blue-500"></i> Expenses by Fiscal Year
        </h3>
        
        <div class="space-y-4">
            <?php if (empty($byYear)): ?>
                <div class="text-center py-8 text-gray-400">No yearly expense data.</div>
            <?php else: ?>
                <?php foreach ($byYear as $y): ?>
                    <div class="flex items-center justify-between border-b border-gray-50 pb-3 last:border-0 last:pb-0">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-lg bg-blue-50 flex items-center justify-center text-blue-600 font-bold text-sm">
                                <?= h($y['fiscal_year'] ?: 'N/A') ?>
                            </div>
                            <div>
                                <div class="font-semibold text-gray-800">Fiscal Year <?= h($y['fiscal_year'] ?: 'Unassigned') ?></div>
                                <div class="text-xs text-gray-500"><?= $y['cnt'] ?> transaction(s)</div>
                            </div>
                        </div>
                        <div class="font-bold text-gray-800 text-lg"><?= format_currency($y['total_amount']) ?></div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <h3 class="font-bold text-gray-800 mb-6 flex items-center gap-2">
            <i data-lucide="pie-chart" class="w-5 h-5 text-blue-500"></i> Expenses by Category
        </h3>
        
        <div class="space-y-4">
            <?php if (empty($byCategory)): ?>
                <div class="text-center py-8 text-gray-400">No category expense data.</div>
            <?php else: ?>
                <?php foreach ($byCategory as $c): ?>
                    <div class="flex items-center justify-between border-b border-gray-50 pb-3 last:border-0 last:pb-0">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center text-gray-500 font-bold text-xs">
                                <?= substr(h($c['category_name'] ?: 'U'), 0, 1) ?>
                            </div>
                            <div>
                                <div class="font-semibold text-gray-800"><?= h($c['category_name'] ?: 'Uncategorized') ?></div>
                                <div class="text-xs text-gray-500"><?= $c['cnt'] ?> transaction(s)</div>
                            </div>
                        </div>
                        <div class="font-bold text-gray-800"><?= format_currency($c['total_amount']) ?></div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>
