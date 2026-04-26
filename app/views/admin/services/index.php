<?php $title = 'Services'; ?>

<div class="flex justify-between items-center mb-6">
    <a href="<?= base_url('admin/services/create') ?>" class="btn-primary flex items-center gap-2">
        <i data-lucide="plus" class="w-4 h-4"></i> Add Service
    </a>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="data-table-wrapper rounded-none border-0 shadow-none">
        <table class="data-table">
            <thead>
                <tr>
                    <th class="w-16">Icon</th>
                    <th>Service Details</th>
                    <th>Slug</th>
                    <th>Sort Order</th>
                    <th>Status</th>
                    <th class="w-24 text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($services)): ?>
                    <tr>
                        <td colspan="6" class="py-12 text-center text-gray-400">
                            <i data-lucide="briefcase" class="w-12 h-12 mx-auto mb-3 opacity-50"></i>
                            <p>No services found.</p>
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($services as $service): ?>
                        <tr>
                            <td>
                                <div class="w-10 h-10 rounded bg-orange-50 text-orange-500 flex items-center justify-center">
                                    <i data-lucide="<?= h($service['icon'] ?: 'settings') ?>" class="w-5 h-5"></i>
                                </div>
                            </td>
                            <td>
                                <div class="font-bold text-gray-800 mb-1"><?= h($service['title']) ?></div>
                                <div class="text-xs text-gray-500 line-clamp-1 max-w-sm"><?= h($service['description']) ?></div>
                            </td>
                            <td class="font-mono text-xs text-gray-500"><?= h($service['slug']) ?></td>
                            <td><?= $service['sort_order'] ?></td>
                            <td>
                                <?php if ($service['is_active']): ?>
                                    <span class="badge badge-completed">Active</span>
                                <?php else: ?>
                                    <span class="badge badge-cancelled">Inactive</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div class="flex justify-center gap-2">
                                    <a href="<?= base_url('admin/services/edit/' . $service['id']) ?>" class="p-1.5 bg-gray-100 text-gray-600 rounded hover:bg-gray-200 transition-colors" title="Edit">
                                        <i data-lucide="edit" class="w-4 h-4"></i>
                                    </a>
                                    <form action="<?= base_url('admin/services/delete/' . $service['id']) ?>" method="POST" class="inline" data-confirm="Delete this service?">
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
</div>
