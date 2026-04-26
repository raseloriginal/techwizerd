<?php $title = 'Projects'; ?>

<div class="flex justify-between items-center mb-6">
    <div class="flex items-center gap-3">
        <a href="<?= base_url('admin/projects/create') ?>" class="btn-primary flex items-center gap-2">
            <i data-lucide="plus" class="w-4 h-4"></i> New Project
        </a>
    </div>
</div>

<!-- Filters -->
<div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 mb-6">
    <form action="<?= base_url('admin/projects') ?>" method="GET" class="flex flex-wrap gap-4 items-end">
        
        <div class="flex-1 min-w-[200px]">
            <label class="form-label text-xs uppercase tracking-wider text-gray-500 mb-1">Search</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i data-lucide="search" class="w-4 h-4 text-gray-400"></i>
                </div>
                <input type="text" name="search" value="<?= h($filters['search'] ?? '') ?>" placeholder="Title, Location..." class="form-control pl-10 h-10 py-1">
            </div>
        </div>

        <div class="w-full sm:w-48">
            <label class="form-label text-xs uppercase tracking-wider text-gray-500 mb-1">Type</label>
            <select name="type" class="form-control h-10 py-1 cursor-pointer">
                <option value="">All Types</option>
                <option value="civil" <?= ($filters['type'] ?? '') === 'civil' ? 'selected' : '' ?>>Civil</option>
                <option value="telecom" <?= ($filters['type'] ?? '') === 'telecom' ? 'selected' : '' ?>>Telecom</option>
                <option value="steel_structure" <?= ($filters['type'] ?? '') === 'steel_structure' ? 'selected' : '' ?>>Steel Structure</option>
                <option value="maintenance" <?= ($filters['type'] ?? '') === 'maintenance' ? 'selected' : '' ?>>Maintenance</option>
                <option value="power" <?= ($filters['type'] ?? '') === 'power' ? 'selected' : '' ?>>Power</option>
                <option value="site_acquisition" <?= ($filters['type'] ?? '') === 'site_acquisition' ? 'selected' : '' ?>>Site Acquisition</option>
                <option value="supply" <?= ($filters['type'] ?? '') === 'supply' ? 'selected' : '' ?>>Supply</option>
            </select>
        </div>

        <div class="w-full sm:w-48">
            <label class="form-label text-xs uppercase tracking-wider text-gray-500 mb-1">Status</label>
            <select name="status" class="form-control h-10 py-1 cursor-pointer">
                <option value="">All Statuses</option>
                <option value="pending" <?= ($filters['status'] ?? '') === 'pending' ? 'selected' : '' ?>>Pending</option>
                <option value="ongoing" <?= ($filters['status'] ?? '') === 'ongoing' ? 'selected' : '' ?>>Ongoing</option>
                <option value="completed" <?= ($filters['status'] ?? '') === 'completed' ? 'selected' : '' ?>>Completed</option>
                <option value="on_hold" <?= ($filters['status'] ?? '') === 'on_hold' ? 'selected' : '' ?>>On Hold</option>
                <option value="cancelled" <?= ($filters['status'] ?? '') === 'cancelled' ? 'selected' : '' ?>>Cancelled</option>
            </select>
        </div>

        <div class="flex gap-2">
            <button type="submit" class="bg-gray-800 hover:bg-gray-900 text-white px-4 py-2 rounded font-semibold transition-colors h-10 flex items-center gap-2">
                <i data-lucide="filter" class="w-4 h-4"></i> Filter
            </button>
            <?php if (!empty(array_filter($filters))): ?>
                <a href="<?= base_url('admin/projects') ?>" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded font-semibold transition-colors h-10 flex items-center">Clear</a>
            <?php endif; ?>
        </div>
    </form>
</div>

<!-- Table -->
<div class="data-table-wrapper">
    <table class="data-table">
        <thead>
            <tr>
                <th class="w-16">ID</th>
                <th>Project Details</th>
                <th>Client</th>
                <th>Type & Status</th>
                <th class="text-right">Contract Value</th>
                <th class="w-24 text-center">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($projects)): ?>
                <tr>
                    <td colspan="6" class="py-12 text-center text-gray-400">
                        <i data-lucide="inbox" class="w-12 h-12 mx-auto mb-3 opacity-50"></i>
                        <p>No projects found matching your criteria.</p>
                    </td>
                </tr>
            <?php else: ?>
                <?php foreach ($projects as $project): ?>
                    <tr>
                        <td class="text-gray-500 font-mono text-sm">#<?= $project['id'] ?></td>
                        <td>
                            <div class="font-bold text-gray-800 mb-1">
                                <?= $project['is_featured'] ? '<i data-lucide="star" class="w-3 h-3 text-yellow-500 inline fill-current mr-1"></i>' : '' ?>
                                <a href="<?= base_url('admin/projects/show/' . $project['id']) ?>" class="hover:text-orange-500"><?= h($project['title']) ?></a>
                            </div>
                            <div class="text-xs text-gray-500 flex items-center gap-1">
                                <i data-lucide="map-pin" class="w-3 h-3"></i> <?= h($project['location'] ?: 'No location') ?>
                            </div>
                        </td>
                        <td>
                            <span class="font-medium text-gray-700"><?= h($project['client_name'] ?? '—') ?></span>
                        </td>
                        <td>
                            <div class="mb-1 text-xs font-bold text-gray-500 uppercase tracking-wider">
                                <?= ucwords(str_replace('_', ' ', $project['project_type'])) ?>
                            </div>
                            <?= status_badge($project['status']) ?>
                        </td>
                        <td class="text-right font-semibold text-gray-800">
                            <?= format_currency($project['contract_value']) ?>
                        </td>
                        <td>
                            <div class="flex justify-center gap-2">
                                <a href="<?= base_url('admin/projects/show/' . $project['id']) ?>" class="p-1.5 bg-blue-50 text-blue-600 rounded hover:bg-blue-100 transition-colors" title="View Details">
                                    <i data-lucide="eye" class="w-4 h-4"></i>
                                </a>
                                <a href="<?= base_url('admin/projects/edit/' . $project['id']) ?>" class="p-1.5 bg-gray-100 text-gray-600 rounded hover:bg-gray-200 transition-colors" title="Edit">
                                    <i data-lucide="edit" class="w-4 h-4"></i>
                                </a>
                                <form action="<?= base_url('admin/projects/delete/' . $project['id']) ?>" method="POST" class="inline" data-confirm="Are you sure you want to delete this project?">
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
    </table>
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
