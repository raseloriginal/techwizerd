<?php $title = 'Team Members'; ?>

<div class="flex justify-between items-center mb-6">
    <a href="<?= base_url('admin/team/create') ?>" class="btn-primary flex items-center gap-2">
        <i data-lucide="plus" class="w-4 h-4"></i> Add Member
    </a>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="data-table-wrapper rounded-none border-0 shadow-none">
        <table class="data-table">
            <thead>
                <tr>
                    <th class="w-16">Photo</th>
                    <th>Member Details</th>
                    <th>Department</th>
                    <th>Sort Order</th>
                    <th>Status</th>
                    <th class="w-24 text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($members)): ?>
                    <tr>
                        <td colspan="6" class="py-12 text-center text-gray-400">
                            <i data-lucide="users" class="w-12 h-12 mx-auto mb-3 opacity-50"></i>
                            <p>No team members found.</p>
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($members as $member): ?>
                        <tr>
                            <td>
                                <?php if ($member['photo']): ?>
                                    <img src="<?= upload_url($member['photo']) ?>" class="w-10 h-10 rounded-full object-cover border border-gray-200">
                                <?php else: ?>
                                    <div class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center text-gray-400">
                                        <i data-lucide="user" class="w-5 h-5"></i>
                                    </div>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div class="font-bold text-gray-800 mb-1"><?= h($member['name']) ?></div>
                                <div class="text-xs text-orange-500 font-semibold uppercase tracking-wider"><?= h($member['designation']) ?></div>
                                <div class="text-xs text-gray-500 mt-1 flex gap-3">
                                    <?php if ($member['email']): ?><span><i data-lucide="mail" class="w-3 h-3 inline"></i> <?= h($member['email']) ?></span><?php endif; ?>
                                    <?php if ($member['phone']): ?><span><i data-lucide="phone" class="w-3 h-3 inline"></i> <?= h($member['phone']) ?></span><?php endif; ?>
                                </div>
                            </td>
                            <td>
                                <span class="font-medium text-gray-700"><?= h($member['department']) ?></span>
                            </td>
                            <td><?= $member['sort_order'] ?></td>
                            <td>
                                <?php if ($member['is_active']): ?>
                                    <span class="badge badge-completed">Active</span>
                                <?php else: ?>
                                    <span class="badge badge-cancelled">Inactive</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div class="flex justify-center gap-2">
                                    <a href="<?= base_url('admin/team/edit/' . $member['id']) ?>" class="p-1.5 bg-gray-100 text-gray-600 rounded hover:bg-gray-200 transition-colors" title="Edit">
                                        <i data-lucide="edit" class="w-4 h-4"></i>
                                    </a>
                                    <form action="<?= base_url('admin/team/delete/' . $member['id']) ?>" method="POST" class="inline" data-confirm="Delete this member?">
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
