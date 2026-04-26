<?php $title = 'Contact Messages'; ?>

<div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-bold text-gray-800 m-0">Contact Messages</h2>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="data-table-wrapper rounded-none border-0 shadow-none">
        <table class="data-table">
            <thead>
                <tr>
                    <th class="w-16">Date</th>
                    <th>Sender</th>
                    <th>Message Details</th>
                    <th class="w-24">Status</th>
                    <th class="w-24 text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($messages)): ?>
                    <tr>
                        <td colspan="5" class="py-12 text-center text-gray-400">
                            <i data-lucide="mail-open" class="w-12 h-12 mx-auto mb-3 opacity-50"></i>
                            <p>No contact messages found.</p>
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($messages as $msg): ?>
                        <tr class="<?= !$msg['is_read'] ? 'bg-orange-50/30' : '' ?>">
                            <td class="text-gray-500 text-sm whitespace-nowrap">
                                <div class="font-semibold text-gray-700"><?= format_date($msg['created_at'], 'd M') ?></div>
                                <div class="text-xs"><?= format_date($msg['created_at'], 'h:i A') ?></div>
                            </td>
                            <td>
                                <div class="font-bold <?= !$msg['is_read'] ? 'text-gray-900' : 'text-gray-700' ?> mb-1"><?= h($msg['name']) ?></div>
                                <div class="text-xs text-gray-500 flex flex-col gap-1">
                                    <span><i data-lucide="mail" class="w-3 h-3 inline"></i> <a href="mailto:<?= h($msg['email']) ?>" class="hover:text-orange-500"><?= h($msg['email']) ?></a></span>
                                    <?php if ($msg['phone']): ?>
                                        <span><i data-lucide="phone" class="w-3 h-3 inline"></i> <?= h($msg['phone']) ?></span>
                                    <?php endif; ?>
                                </div>
                            </td>
                            <td class="max-w-md">
                                <div class="font-bold text-gray-800 mb-1 line-clamp-1"><?= h($msg['subject'] ?: 'No Subject') ?></div>
                                <div class="text-sm text-gray-600 line-clamp-2"><?= h($msg['message']) ?></div>
                            </td>
                            <td>
                                <?php if (!$msg['is_read']): ?>
                                    <span class="badge badge-warning">Unread</span>
                                <?php else: ?>
                                    <span class="badge badge-completed bg-gray-100 text-gray-600">Read</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div class="flex justify-center gap-2">
                                    <?php if (!$msg['is_read']): ?>
                                        <form action="<?= base_url('admin/contacts/mark-read/' . $msg['id']) ?>" method="POST" class="inline">
                                            <?= csrf_field() ?>
                                            <button type="submit" class="p-1.5 bg-green-50 text-green-600 rounded hover:bg-green-100 transition-colors" title="Mark as Read">
                                                <i data-lucide="check" class="w-4 h-4"></i>
                                            </button>
                                        </form>
                                    <?php endif; ?>
                                    <form action="<?= base_url('admin/contacts/delete/' . $msg['id']) ?>" method="POST" class="inline" data-confirm="Delete this message forever?">
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
