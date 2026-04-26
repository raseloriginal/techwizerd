<?php $title = 'Project Expenses Summary'; ?>

<div class="flex justify-between items-center mb-6">
    <div class="flex items-center gap-3">
        <a href="<?= base_url('admin/expenses/project') ?>" class="text-gray-500 hover:text-orange-500"><i data-lucide="arrow-left" class="w-5 h-5"></i></a>
        <h2 class="text-2xl font-bold text-gray-800 m-0">Project Financial Summary</h2>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <h3 class="font-bold text-gray-800 mb-6 flex items-center gap-2">
            <i data-lucide="bar-chart-2" class="w-5 h-5 text-orange-500"></i> Expenses by Project
        </h3>
        
        <div class="space-y-4">
            <?php if (empty($byProject)): ?>
                <div class="text-center py-8 text-gray-400">No project expense data.</div>
            <?php else: ?>
                <?php foreach ($byProject as $p): ?>
                    <div class="border-b border-gray-50 pb-3 last:border-0 last:pb-0">
                        <div class="flex justify-between items-start mb-1">
                            <a href="<?= base_url('admin/projects/show/' . $p['project_id']) ?>" class="font-semibold text-gray-800 hover:text-orange-500"><?= h($p['project_title']) ?></a>
                            <span class="font-bold text-gray-800"><?= format_currency($p['total_amount']) ?></span>
                        </div>
                        <div class="flex justify-between text-xs text-gray-500">
                            <span>Contract: <?= format_currency($p['contract_value']) ?></span>
                            <?php 
                            $cv = $p['contract_value'];
                            if ($cv > 0) {
                                $pct = ($p['total_amount'] / $cv) * 100;
                                echo '<span class="' . ($pct > 90 ? 'text-red-500' : 'text-gray-500') . '">' . number_format($pct, 1) . '% used</span>';
                            } else {
                                echo '<span>N/A</span>';
                            }
                            ?>
                        </div>
                        <?php if ($cv > 0): ?>
                            <div class="w-full bg-gray-100 h-1.5 mt-2 rounded-full overflow-hidden">
                                <div class="h-full <?= ($pct > 90 ? 'bg-red-500' : ($pct > 75 ? 'bg-orange-500' : 'bg-green-500')) ?>" style="width: <?= min(100, $pct) ?>%"></div>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <h3 class="font-bold text-gray-800 mb-6 flex items-center gap-2">
            <i data-lucide="pie-chart" class="w-5 h-5 text-orange-500"></i> Expenses by Category
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
