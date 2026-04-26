<?php $title = 'Add Service'; ?>

<div class="flex items-center gap-2 mb-6">
    <a href="<?= base_url('admin/services') ?>" class="text-gray-500 hover:text-orange-500"><i data-lucide="arrow-left" class="w-5 h-5"></i></a>
    <h2 class="text-2xl font-bold text-gray-800 m-0">Add Service</h2>
</div>

<form action="<?= base_url('admin/services/create') ?>" method="POST" class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 md:p-8 max-w-2xl">
    <?= csrf_field() ?>

    <div class="form-group">
        <label for="title" class="form-label">Service Title <span class="text-red-500">*</span></label>
        <input type="text" id="title" name="title" class="form-control text-lg font-semibold" required>
    </div>

    <div class="form-group">
        <label for="description" class="form-label">Description</label>
        <textarea id="description" name="description" class="form-control" rows="4"></textarea>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
        <div class="form-group">
            <label for="icon" class="form-label">Lucide Icon Name</label>
            <input type="text" id="icon" name="icon" class="form-control" placeholder="e.g. settings, radio-tower">
            <div class="text-xs text-gray-500 mt-1">Check <a href="https://lucide.dev/icons" target="_blank" class="text-blue-500 hover:underline">lucide.dev/icons</a> for names.</div>
        </div>
        
        <div class="form-group">
            <label for="sort_order" class="form-label">Sort Order</label>
            <input type="number" id="sort_order" name="sort_order" class="form-control" value="0">
        </div>
    </div>

    <div class="form-group border-t border-gray-100 pt-6">
        <label class="flex items-center gap-3 cursor-pointer">
            <input type="checkbox" name="is_active" class="w-5 h-5 text-orange-500 rounded border-gray-300" checked>
            <span class="font-semibold text-gray-700">Active</span>
        </label>
    </div>

    <div class="mt-8 flex justify-end gap-4">
        <a href="<?= base_url('admin/services') ?>" class="px-6 py-2.5 rounded-lg border border-gray-300 text-gray-700 font-semibold hover:bg-gray-50">Cancel</a>
        <button type="submit" class="btn-primary flex items-center gap-2">
            <i data-lucide="save" class="w-4 h-4"></i> Save Service
        </button>
    </div>
</form>
