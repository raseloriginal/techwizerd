<?php $title = 'Create Project'; ?>

<div class="flex items-center gap-2 mb-6">
    <a href="<?= base_url('admin/projects') ?>" class="text-gray-500 hover:text-orange-500"><i data-lucide="arrow-left" class="w-5 h-5"></i></a>
    <h2 class="text-2xl font-bold text-gray-800 m-0">Create New Project</h2>
</div>

<form action="<?= base_url('admin/projects/create') ?>" method="POST" enctype="multipart/form-data" class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 md:p-8">
    <?= csrf_field() ?>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Left Column (Main Details) -->
        <div class="lg:col-span-2 space-y-6">
            <div class="form-group">
                <label for="title" class="form-label">Project Title <span class="text-red-500">*</span></label>
                <input type="text" id="title" name="title" class="form-control text-lg font-semibold" required>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="form-group">
                    <label for="client_id" class="form-label">Client</label>
                    <select id="client_id" name="client_id" class="form-control">
                        <option value="">Select a Client</option>
                        <?php foreach ($clients as $client): ?>
                            <option value="<?= $client['id'] ?>"><?= h($client['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="location" class="form-label">Location</label>
                    <input type="text" id="location" name="location" class="form-control" placeholder="City, Region">
                </div>
            </div>

            <div class="form-group">
                <label for="description" class="form-label">Project Description</label>
                <textarea id="description" name="description" class="form-control" rows="5"></textarea>
            </div>
            
            <div class="form-group">
                <label for="scope" class="form-label">Scope of Work</label>
                <textarea id="scope" name="scope" class="form-control" rows="4" placeholder="Detailed breakdown of tasks..."></textarea>
            </div>
        </div>

        <!-- Right Column (Settings) -->
        <div class="bg-gray-50 p-6 rounded-xl border border-gray-100 h-fit space-y-6">
            
            <div class="form-group">
                <label for="project_type" class="form-label">Project Type</label>
                <select id="project_type" name="project_type" class="form-control">
                    <option value="civil">Civil Construction</option>
                    <option value="telecom">Telecom Installation</option>
                    <option value="steel_structure">Steel Structure</option>
                    <option value="maintenance">Maintenance</option>
                    <option value="power">Power Connection</option>
                    <option value="site_acquisition">Site Acquisition</option>
                    <option value="supply">Supply</option>
                    <option value="other" selected>Other</option>
                </select>
            </div>
            
            <div class="form-group">
                <label for="status" class="form-label">Status</label>
                <select id="status" name="status" class="form-control">
                    <option value="pending" selected>Pending</option>
                    <option value="ongoing">Ongoing</option>
                    <option value="completed">Completed</option>
                    <option value="on_hold">On Hold</option>
                    <option value="cancelled">Cancelled</option>
                </select>
            </div>
            
            <div class="form-group">
                <label for="contract_value" class="form-label">Contract Value (BDT)</label>
                <input type="number" step="0.01" id="contract_value" name="contract_value" class="form-control font-mono" value="0.00">
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div class="form-group">
                    <label for="start_date" class="form-label">Start Date</label>
                    <input type="date" id="start_date" name="start_date" class="form-control">
                </div>
                <div class="form-group">
                    <label for="end_date" class="form-label">End Date</label>
                    <input type="date" id="end_date" name="end_date" class="form-control">
                </div>
            </div>

            <div class="border-t border-gray-200 pt-6">
                <label class="form-label mb-3">Featured Image</label>
                <div class="border-2 border-dashed border-gray-300 rounded-lg p-4 text-center bg-white">
                    <div class="mb-2 text-gray-400">
                        <i data-lucide="image-plus" class="w-8 h-8 mx-auto"></i>
                    </div>
                    <input type="file" name="featured_image" id="featured_image" class="hidden" accept="image/*" data-preview="img-preview">
                    <label for="featured_image" class="text-sm font-semibold text-orange-500 hover:text-orange-600 cursor-pointer">Click to upload</label>
                    <div class="text-xs text-gray-500 mt-1">JPG, PNG up to 5MB</div>
                    <img id="img-preview" src="#" alt="Preview" class="hidden mt-4 mx-auto max-h-32 rounded">
                </div>
            </div>

            <div class="border-t border-gray-200 pt-6 space-y-3">
                <label class="flex items-center gap-3 cursor-pointer">
                    <input type="checkbox" name="is_featured" class="w-5 h-5 text-orange-500 rounded border-gray-300 focus:ring-orange-500">
                    <span class="font-semibold text-gray-700">Feature on Homepage</span>
                </label>
                <label class="flex items-center gap-3 cursor-pointer">
                    <input type="checkbox" name="is_active" class="w-5 h-5 text-orange-500 rounded border-gray-300 focus:ring-orange-500" checked>
                    <span class="font-semibold text-gray-700">Active / Published</span>
                </label>
            </div>

        </div>
    </div>

    <div class="mt-8 pt-6 border-t border-gray-100 flex justify-end gap-4">
        <a href="<?= base_url('admin/projects') ?>" class="px-6 py-2.5 rounded-lg border border-gray-300 text-gray-700 font-semibold hover:bg-gray-50">Cancel</a>
        <button type="submit" class="btn-primary flex items-center gap-2">
            <i data-lucide="save" class="w-4 h-4"></i> Save Project
        </button>
    </div>
</form>
