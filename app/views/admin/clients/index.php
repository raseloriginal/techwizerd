<?php $title = 'Clients'; ?>

<div class="flex justify-between items-center mb-6">
    <a href="<?= base_url('admin/clients/create') ?>" class="btn-primary flex items-center gap-2">
        <i data-lucide="plus" class="w-4 h-4"></i> Add Client
    </a>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="data-table-wrapper rounded-none border-0 shadow-none">
        <table class="data-table">
            <thead>
                <tr>
                    <th class="w-16">ID</th>
                    <th>Logo</th>
                    <th>Client Details</th>
                    <th>Status</th>
                    <th class="w-24 text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($clients)): ?>
                    <tr>
                        <td colspan="5" class="py-12 text-center text-gray-400">
                            <i data-lucide="users" class="w-12 h-12 mx-auto mb-3 opacity-50"></i>
                            <p>No clients found.</p>
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($clients as $client): ?>
                        <tr>
                            <td class="text-gray-500 font-mono text-sm">#<?= $client['id'] ?></td>
                            <td>
                                <?php if ($client['logo']): ?>
                                    <div class="w-12 h-12 rounded bg-gray-50 border border-gray-200 flex items-center justify-center p-1">
                                        <img src="<?= upload_url($client['logo']) ?>" class="max-w-full max-h-full object-contain">
                                    </div>
                                <?php else: ?>
                                    <div class="w-12 h-12 rounded bg-gray-100 flex items-center justify-center text-gray-400">
                                        <i data-lucide="image" class="w-6 h-6"></i>
                                    </div>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div class="font-bold text-gray-800 mb-1"><?= h($client['name']) ?></div>
                                <div class="text-xs text-gray-500 flex gap-4">
                                    <?php if ($client['contact_email']): ?>
                                        <span><i data-lucide="mail" class="w-3 h-3 inline"></i> <?= h($client['contact_email']) ?></span>
                                    <?php endif; ?>
                                    <?php if ($client['contact_phone']): ?>
                                        <span><i data-lucide="phone" class="w-3 h-3 inline"></i> <?= h($client['contact_phone']) ?></span>
                                    <?php endif; ?>
                                </div>
                            </td>
                            <td>
                                <?php if ($client['is_active']): ?>
                                    <span class="badge badge-completed">Active</span>
                                <?php else: ?>
                                    <span class="badge badge-cancelled">Inactive</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div class="flex justify-center gap-2">
                                    <a href="<?= base_url('admin/clients/edit/' . $client['id']) ?>" class="p-1.5 bg-gray-100 text-gray-600 rounded hover:bg-gray-200 transition-colors" title="Edit">
                                        <i data-lucide="edit" class="w-4 h-4"></i>
                                    </a>
                                    <form action="<?= base_url('admin/clients/delete/' . $client['id']) ?>" method="POST" class="inline" data-confirm="Delete this client?">
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
