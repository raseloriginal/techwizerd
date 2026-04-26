<?php $title = 'Add Team Member'; ?>

<div class="flex items-center gap-2 mb-6">
    <a href="<?= base_url('admin/team') ?>" class="text-gray-500 hover:text-orange-500"><i data-lucide="arrow-left" class="w-5 h-5"></i></a>
    <h2 class="text-2xl font-bold text-gray-800 m-0">Add Team Member</h2>
</div>

<form action="<?= base_url('admin/team/create') ?>" method="POST" enctype="multipart/form-data" class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 md:p-8 max-w-2xl">
    <?= csrf_field() ?>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
        <div class="form-group">
            <label for="name" class="form-label">Full Name <span class="text-red-500">*</span></label>
            <input type="text" id="name" name="name" class="form-control font-semibold" required>
        </div>
        <div class="form-group">
            <label for="designation" class="form-label">Designation <span class="text-red-500">*</span></label>
            <input type="text" id="designation" name="designation" class="form-control" required placeholder="e.g. Managing Director">
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
        <div class="form-group">
            <label for="department" class="form-label">Department</label>
            <input type="text" id="department" name="department" class="form-control" placeholder="e.g. Board of Directors, Engineering">
        </div>
        <div class="form-group">
            <label for="qualification" class="form-label">Qualification</label>
            <input type="text" id="qualification" name="qualification" class="form-control" placeholder="e.g. B.Sc in Civil Engineering">
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
        <div class="form-group">
            <label for="phone" class="form-label">Phone Number</label>
            <input type="text" id="phone" name="phone" class="form-control">
        </div>
        <div class="form-group">
            <label for="email" class="form-label">Email Address</label>
            <input type="email" id="email" name="email" class="form-control">
        </div>
    </div>

    <div class="form-group">
        <label for="sort_order" class="form-label">Sort Order</label>
        <input type="number" id="sort_order" name="sort_order" class="form-control" value="0">
        <div class="text-xs text-gray-500 mt-1">Lower numbers appear first.</div>
    </div>

    <div class="form-group mb-6">
        <label class="form-label mb-2">Profile Photo</label>
        <div class="border-2 border-dashed border-gray-300 rounded-lg p-4 text-center bg-gray-50">
            <div class="mb-2 text-gray-400">
                <i data-lucide="image-plus" class="w-8 h-8 mx-auto"></i>
            </div>
            <input type="file" name="photo" id="photo" class="hidden" accept="image/*" data-preview="photo-preview">
            <label for="photo" class="text-sm font-semibold text-orange-500 hover:text-orange-600 cursor-pointer">Click to upload photo</label>
            <img id="photo-preview" src="#" alt="Preview" class="hidden mt-4 mx-auto w-32 h-32 object-cover rounded-full border border-gray-200 bg-white">
        </div>
    </div>

    <div class="form-group border-t border-gray-100 pt-6">
        <label class="flex items-center gap-3 cursor-pointer">
            <input type="checkbox" name="is_active" class="w-5 h-5 text-orange-500 rounded border-gray-300" checked>
            <span class="font-semibold text-gray-700">Active</span>
        </label>
    </div>

    <div class="mt-8 flex justify-end gap-4">
        <a href="<?= base_url('admin/team') ?>" class="px-6 py-2.5 rounded-lg border border-gray-300 text-gray-700 font-semibold hover:bg-gray-50">Cancel</a>
        <button type="submit" class="btn-primary flex items-center gap-2">
            <i data-lucide="save" class="w-4 h-4"></i> Save Member
        </button>
    </div>
</form>
