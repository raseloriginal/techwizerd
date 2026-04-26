<?php $title = 'Edit Client: ' . h($client['name']); ?>

<div class="flex items-center gap-2 mb-6">
    <a href="<?= base_url('admin/clients') ?>" class="text-gray-500 hover:text-orange-500"><i data-lucide="arrow-left" class="w-5 h-5"></i></a>
    <h2 class="text-2xl font-bold text-gray-800 m-0">Edit Client</h2>
</div>

<form action="<?= base_url('admin/clients/edit/' . $client['id']) ?>" method="POST" enctype="multipart/form-data" class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 md:p-8 max-w-2xl">
    <?= csrf_field() ?>

    <div class="form-group">
        <label for="name" class="form-label">Client Name / Company Name <span class="text-red-500">*</span></label>
        <input type="text" id="name" name="name" class="form-control text-lg font-semibold" value="<?= h($client['name']) ?>" required>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
        <div class="form-group">
            <label for="contact_email" class="form-label">Email Address</label>
            <input type="email" id="contact_email" name="contact_email" class="form-control" value="<?= h($client['contact_email'] ?? '') ?>">
        </div>
        <div class="form-group">
            <label for="contact_phone" class="form-label">Phone Number</label>
            <input type="text" id="contact_phone" name="contact_phone" class="form-control" value="<?= h($client['contact_phone'] ?? '') ?>">
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
        <div class="form-group">
            <label for="contact_person" class="form-label">Contact Person</label>
            <input type="text" id="contact_person" name="contact_person" class="form-control" value="<?= h($client['contact_person'] ?? '') ?>">
        </div>
        <div class="form-group">
            <label for="website" class="form-label">Website URL</label>
            <input type="url" id="website" name="website" class="form-control" placeholder="https://" value="<?= h($client['website'] ?? '') ?>">
        </div>
    </div>

    <div class="form-group mb-6">
        <label class="form-label mb-2">Client Logo</label>
        
        <?php if ($client['logo']): ?>
            <div class="mb-4">
                <img src="<?= upload_url($client['logo']) ?>" class="h-20 w-auto object-contain border border-gray-200 rounded p-1 bg-white">
            </div>
        <?php endif; ?>
        
        <input type="file" name="logo" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-sm file:font-semibold file:bg-orange-50 file:text-orange-700 hover:file:bg-orange-100" accept="image/*">
        <div class="text-xs text-gray-400 mt-1">Upload new to replace existing logo.</div>
    </div>

    <div class="form-group border-t border-gray-100 pt-6">
        <label class="flex items-center gap-3 cursor-pointer">
            <input type="checkbox" name="is_active" class="w-5 h-5 text-orange-500 rounded border-gray-300" <?= $client['is_active'] ? 'checked' : '' ?>>
            <span class="font-semibold text-gray-700">Active</span>
        </label>
    </div>

    <div class="mt-8 flex justify-end gap-4">
        <a href="<?= base_url('admin/clients') ?>" class="px-6 py-2.5 rounded-lg border border-gray-300 text-gray-700 font-semibold hover:bg-gray-50">Cancel</a>
        <button type="submit" class="btn-primary flex items-center gap-2">
            <i data-lucide="save" class="w-4 h-4"></i> Update Client
        </button>
    </div>
</form>
