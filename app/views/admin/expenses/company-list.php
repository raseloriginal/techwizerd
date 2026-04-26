<?php $title = 'Company Expenses'; ?>

<div class="flex justify-between items-center mb-6">
    <div class="flex items-center gap-3">
        <a href="<?= base_url('admin/expenses/company/create') ?>" class="btn-primary flex items-center gap-2">
            <i data-lucide="plus" class="w-4 h-4"></i> Add Expense
        </a>
        <a href="<?= base_url('admin/expenses/company/summary') ?>" class="px-4 py-2 bg-white text-gray-700 border border-gray-300 rounded-lg font-semibold hover:bg-gray-50 flex items-center gap-2">
            <i data-lucide="pie-chart" class="w-4 h-4 text-orange-500"></i> Summary
        </a>
    </div>
    <a href="<?= base_url('admin/expenses/company/export?' . http_build_query($filters)) ?>" class="px-4 py-2 bg-green-600 text-white rounded-lg font-semibold hover:bg-green-700 flex items-center gap-2">
        <i data-lucide="download" class="w-4 h-4"></i> Export CSV
    </a>
</div>

<!-- Filters -->
<div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 mb-6">
    <form action="<?= base_url('admin/expenses/company') ?>" method="GET" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-6 gap-4 items-end">
        
        <div>
            <label class="form-label text-xs uppercase tracking-wider text-gray-500 mb-1">Category</label>
            <select name="category_id" class="form-control h-10 py-1">
                <option value="">All Categories</option>
                <?php foreach ($categories as $c): ?>
                    <option value="<?= $c['id'] ?>" <?= ($filters['category_id'] ?? '') == $c['id'] ? 'selected' : '' ?>><?= h($c['name']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        
        <div>
            <label class="form-label text-xs uppercase tracking-wider text-gray-500 mb-1">Status</label>
            <select name="status" class="form-control h-10 py-1">
                <option value="">All</option>
                <option value="pending" <?= ($filters['status'] ?? '') === 'pending' ? 'selected' : '' ?>>Pending</option>
                <option value="approved" <?= ($filters['status'] ?? '') === 'approved' ? 'selected' : '' ?>>Approved</option>
                <option value="rejected" <?= ($filters['status'] ?? '') === 'rejected' ? 'selected' : '' ?>>Rejected</option>
            </select>
        </div>

        <div>
            <label class="form-label text-xs uppercase tracking-wider text-gray-500 mb-1">Fiscal Year</label>
            <input type="text" name="fiscal_year" value="<?= h($filters['fiscal_year'] ?? '') ?>" placeholder="e.g. 2023-24" class="form-control h-10 py-1">
        </div>
        
        <div>
            <label class="form-label text-xs uppercase tracking-wider text-gray-500 mb-1">Month</label>
            <select name="month" class="form-control h-10 py-1">
                <option value="">All Months</option>
                <?php for($i=1; $i<=12; $i++): ?>
                    <option value="<?= $i ?>" <?= ($filters['month'] ?? '') == $i ? 'selected' : '' ?>><?= date("F", mktime(0, 0, 0, $i, 10)) ?></option>
                <?php endfor; ?>
            </select>
        </div>
        
        <div>
            <label class="form-label text-xs uppercase tracking-wider text-gray-500 mb-1">Year</label>
            <select name="year" class="form-control h-10 py-1">
                <option value="">All Years</option>
                <?php for($i=date('Y'); $i>=2020; $i--): ?>
                    <option value="<?= $i ?>" <?= ($filters['year'] ?? '') == $i ? 'selected' : '' ?>><?= $i ?></option>
                <?php endfor; ?>
            </select>
        </div>

        <div class="flex gap-2">
            <button type="submit" class="bg-gray-800 hover:bg-gray-900 text-white w-full py-2 rounded font-semibold transition-colors h-10 flex items-center justify-center gap-2">
                Filter
            </button>
            <?php if (!empty(array_filter($filters))): ?>
                <a href="<?= base_url('admin/expenses/company') ?>" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-3 py-2 rounded font-semibold transition-colors h-10 flex items-center" title="Clear"><i data-lucide="x" class="w-4 h-4"></i></a>
            <?php endif; ?>
        </div>
    </form>
</div>

<!-- Table -->
<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="data-table-wrapper rounded-none border-0 shadow-none">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Category</th>
                    <th>Details</th>
                    <th>Payment</th>
                    <th>Status</th>
                    <th class="text-right">Amount</th>
                    <th class="w-20 text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($expenses)): ?>
                    <tr>
                        <td colspan="7" class="py-12 text-center text-gray-400">
                            <i data-lucide="inbox" class="w-12 h-12 mx-auto mb-3 opacity-50"></i>
                            <p>No company expenses found.</p>
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($expenses as $expense): ?>
                        <tr>
                            <td class="text-gray-500 text-sm whitespace-nowrap">
                                <?= format_date($expense['expense_date'], 'd M, Y') ?>
                                <?php if ($expense['fiscal_year']): ?>
                                    <div class="text-[10px] uppercase text-gray-400 mt-1">FY: <?= h($expense['fiscal_year']) ?></div>
                                <?php endif; ?>
                            </td>
                            <td>
                                <span class="bg-gray-100 text-gray-600 px-2 py-0.5 rounded text-xs font-semibold"><?= h($expense['category_name'] ?? 'Uncategorized') ?></span>
                            </td>
                            <td>
                                <div class="font-medium text-gray-800 line-clamp-1"><?= h($expense['title']) ?></div>
                                <?php if ($expense['paid_to']): ?>
                                    <div class="text-xs text-gray-500 mt-0.5"><span class="text-gray-400">To:</span> <?= h($expense['paid_to']) ?></div>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div class="text-sm text-gray-700 capitalize"><?= str_replace('_', ' ', h($expense['payment_method'])) ?></div>
                            </td>
                            <td><?= status_badge($expense['status']) ?></td>
                            <td class="text-right font-bold text-gray-800">
                                <?= format_currency($expense['amount']) ?>
                            </td>
                            <td>
                                <div class="flex justify-center gap-2">
                                    <a href="<?= base_url('admin/expenses/company/edit/' . $expense['id']) ?>" class="p-1.5 bg-gray-100 text-gray-600 rounded hover:bg-gray-200 transition-colors" title="Edit">
                                        <i data-lucide="edit" class="w-4 h-4"></i>
                                    </a>
                                    <form action="<?= base_url('admin/expenses/company/delete/' . $expense['id']) ?>" method="POST" class="inline" data-confirm="Delete this expense?">
                                        <?= csrf_field() ?>
                                        <button type="submit" class="p-1.5 bg-red-50 text-red-600 rounded hover:bg-red-100 transition-colors" title="Delete">
                                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
            <?php if (!empty($expenses)): ?>
                <tfoot class="bg-gray-50 border-t-2 border-gray-200">
                    <tr>
                        <td colspan="5" class="text-right font-bold text-gray-600 uppercase tracking-wider text-sm py-4">Total for Current View:</td>
                        <td class="text-right font-bold text-orange-600 text-lg py-4 px-4"><?= format_currency($grandTotal) ?></td>
                        <td></td>
                    </tr>
                </tfoot>
            <?php endif; ?>
        </table>
    </div>
</div>

<!-- Pagination -->
<?php if ($pager['total_pages'] > 1): ?>
    <div class="mt-6 flex justify-between items-center">
        <div class="text-sm text-gray-500">
            Showing <?= $pager['offset'] + 1 ?> to <?= min($pager['offset'] + $pager['per_page'], $pager['total']) ?> of <?= $pager['total'] ?> entries
        </div>
        <div class="flex gap-1">
            <?php if ($pager['has_prev']): ?>
                <a href="?page=<?= $pager['current'] - 1 ?><?= http_build_query(array_filter($filters)) ? '&' . http_build_query(array_filter($filters)) : '' ?>" class="px-3 py-1 bg-white border border-gray-200 rounded hover:bg-gray-50">Prev</a>
            <?php endif; ?>
            
            <?php for ($i = 1; $i <= $pager['total_pages']; $i++): ?>
                <a href="?page=<?= $i ?><?= http_build_query(array_filter($filters)) ? '&' . http_build_query(array_filter($filters)) : '' ?>" class="px-3 py-1 border rounded <?= $i === $pager['current'] ? 'bg-orange-500 text-white border-orange-500' : 'bg-white border-gray-200 hover:bg-gray-50' ?>"><?= $i ?></a>
            <?php endfor; ?>

            <?php if ($pager['has_next']): ?>
                <a href="?page=<?= $pager['current'] + 1 ?><?= http_build_query(array_filter($filters)) ? '&' . http_build_query(array_filter($filters)) : '' ?>" class="px-3 py-1 bg-white border border-gray-200 rounded hover:bg-gray-50">Next</a>
            <?php endif; ?>
        </div>
    </div>
<?php endif; ?>
