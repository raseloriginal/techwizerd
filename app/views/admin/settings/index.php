<?php $title = 'Site Settings'; ?>

<div class="flex items-center gap-2 mb-6">
    <h2 class="text-2xl font-bold text-gray-800 m-0">Site Settings</h2>
</div>

<form action="<?= base_url('admin/settings/update') ?>" method="POST" class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 md:p-8 max-w-4xl">
    <?= csrf_field() ?>

    <h3 class="text-lg font-bold text-gray-800 mb-4 border-b border-gray-100 pb-2">General Information</h3>
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        <div class="form-group mb-0">
            <label for="site_title" class="form-label">Site Title</label>
            <input type="text" id="site_title" name="site_title" class="form-control" value="<?= h($settings['site_title'] ?? '') ?>">
        </div>
        <div class="form-group mb-0">
            <label for="site_tagline" class="form-label">Tagline / Slogan</label>
            <input type="text" id="site_tagline" name="site_tagline" class="form-control" value="<?= h($settings['site_tagline'] ?? '') ?>">
        </div>
    </div>

    <div class="form-group mb-8">
        <label for="site_description" class="form-label">Company Description (About Us snippet)</label>
        <textarea id="site_description" name="site_description" class="form-control" rows="3"><?= h($settings['site_description'] ?? '') ?></textarea>
    </div>

    <h3 class="text-lg font-bold text-gray-800 mb-4 border-b border-gray-100 pb-2">Contact Details</h3>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        <div class="form-group mb-0">
            <label for="site_email" class="form-label">Primary Email</label>
            <input type="email" id="site_email" name="site_email" class="form-control" value="<?= h($settings['site_email'] ?? '') ?>">
        </div>
        <div class="form-group mb-0">
            <label for="site_phone" class="form-label">Primary Phone</label>
            <input type="text" id="site_phone" name="site_phone" class="form-control" value="<?= h($settings['site_phone'] ?? '') ?>">
        </div>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        <div class="form-group mb-0">
            <label for="site_phone2" class="form-label">Secondary Phone (Optional)</label>
            <input type="text" id="site_phone2" name="site_phone2" class="form-control" value="<?= h($settings['site_phone2'] ?? '') ?>">
        </div>
        <div class="form-group mb-0">
            <label for="site_address" class="form-label">Office Address</label>
            <input type="text" id="site_address" name="site_address" class="form-control" value="<?= h($settings['site_address'] ?? '') ?>">
        </div>
    </div>

    <h3 class="text-lg font-bold text-gray-800 mb-4 border-b border-gray-100 pb-2 mt-8">Social Media & Integrations</h3>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        <div class="form-group mb-0">
            <label for="facebook_url" class="form-label">Facebook URL</label>
            <input type="url" id="facebook_url" name="facebook_url" class="form-control" value="<?= h($settings['facebook_url'] ?? '') ?>">
        </div>
        <div class="form-group mb-0">
            <label for="linkedin_url" class="form-label">LinkedIn URL</label>
            <input type="url" id="linkedin_url" name="linkedin_url" class="form-control" value="<?= h($settings['linkedin_url'] ?? '') ?>">
        </div>
    </div>
    
    <div class="form-group mb-6">
        <label for="google_map_embed" class="form-label">Google Maps Embed HTML</label>
        <textarea id="google_map_embed" name="google_map_embed" class="form-control font-mono text-sm" rows="3"><?= h($settings['google_map_embed'] ?? '') ?></textarea>
    </div>

    <div class="mt-8 flex justify-end">
        <button type="submit" class="btn-primary flex items-center gap-2">
            <i data-lucide="save" class="w-4 h-4"></i> Save Settings
        </button>
    </div>
</form>
