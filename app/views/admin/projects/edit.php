<?php $title = 'Edit Project: ' . h($project['title']); ?>

<div class="flex justify-between items-center mb-6">
    <div class="flex items-center gap-2">
        <a href="<?= base_url('admin/projects') ?>" class="text-gray-500 hover:text-orange-500"><i data-lucide="arrow-left" class="w-5 h-5"></i></a>
        <h2 class="text-2xl font-bold text-gray-800 m-0">Edit Project</h2>
    </div>
    <div class="flex gap-2">
        <a href="<?= base_url('admin/projects/show/' . $project['id']) ?>" class="btn-secondary flex items-center gap-2 text-sm">
            <i data-lucide="eye" class="w-4 h-4"></i> View Detail
        </a>
    </div>
</div>

<div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
    
    <!-- Main Edit Form -->
    <div class="xl:col-span-2">
        <form action="<?= base_url('admin/projects/edit/' . $project['id']) ?>" method="POST" enctype="multipart/form-data" class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <?= csrf_field() ?>

            <div class="form-group">
                <label for="title" class="form-label">Project Title <span class="text-red-500">*</span></label>
                <input type="text" id="title" name="title" class="form-control text-lg font-semibold" value="<?= h($project['title']) ?>" required>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="form-group">
                    <label for="client_id" class="form-label">Client</label>
                    <select id="client_id" name="client_id" class="form-control">
                        <option value="">Select a Client</option>
                        <?php foreach ($clients as $client): ?>
                            <option value="<?= $client['id'] ?>" <?= $client['id'] == $project['client_id'] ? 'selected' : '' ?>><?= h($client['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="location" class="form-label">Location</label>
                    <input type="text" id="location" name="location" class="form-control" value="<?= h($project['location']) ?>">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="form-group">
                    <label for="project_type" class="form-label">Project Type</label>
                    <select id="project_type" name="project_type" class="form-control">
                        <?php 
                        $types = ['civil'=>'Civil Construction', 'telecom'=>'Telecom Installation', 'steel_structure'=>'Steel Structure', 'maintenance'=>'Maintenance', 'power'=>'Power Connection', 'site_acquisition'=>'Site Acquisition', 'supply'=>'Supply', 'other'=>'Other'];
                        foreach ($types as $val => $label) {
                            $sel = $val === $project['project_type'] ? 'selected' : '';
                            echo "<option value=\"$val\" $sel>$label</option>";
                        }
                        ?>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="status" class="form-label">Status</label>
                    <select id="status" name="status" class="form-control">
                        <?php 
                        $statuses = ['pending'=>'Pending', 'ongoing'=>'Ongoing', 'completed'=>'Completed', 'on_hold'=>'On Hold', 'cancelled'=>'Cancelled'];
                        foreach ($statuses as $val => $label) {
                            $sel = $val === $project['status'] ? 'selected' : '';
                            echo "<option value=\"$val\" $sel>$label</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label for="description" class="form-label">Project Description</label>
                <textarea id="description" name="description" class="form-control" rows="5"><?= h($project['description']) ?></textarea>
            </div>
            
            <div class="form-group">
                <label for="scope" class="form-label">Scope of Work</label>
                <textarea id="scope" name="scope" class="form-control" rows="4"><?= h($project['scope']) ?></textarea>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 pt-4 border-t border-gray-100">
                <div class="form-group">
                    <label for="contract_value" class="form-label">Contract Value (BDT)</label>
                    <input type="number" step="0.01" id="contract_value" name="contract_value" class="form-control font-mono" value="<?= h($project['contract_value']) ?>">
                </div>
                <div class="form-group">
                    <label for="start_date" class="form-label">Start Date</label>
                    <input type="date" id="start_date" name="start_date" class="form-control" value="<?= h($project['start_date']) ?>">
                </div>
                <div class="form-group">
                    <label for="end_date" class="form-label">End Date</label>
                    <input type="date" id="end_date" name="end_date" class="form-control" value="<?= h($project['end_date']) ?>">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-4 border-t border-gray-100 items-center">
                <div class="space-y-3">
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="checkbox" name="is_featured" class="w-5 h-5 text-orange-500 rounded border-gray-300" <?= $project['is_featured'] ? 'checked' : '' ?>>
                        <span class="font-semibold text-gray-700">Feature on Homepage</span>
                    </label>
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="checkbox" name="is_active" class="w-5 h-5 text-orange-500 rounded border-gray-300" <?= $project['is_active'] ? 'checked' : '' ?>>
                        <span class="font-semibold text-gray-700">Active / Published</span>
                    </label>
                </div>
                
                <div>
                    <label class="form-label mb-2">Featured Image</label>
                    <div class="flex gap-4 items-center">
                        <?php if ($project['featured_image']): ?>
                            <img src="<?= upload_url($project['featured_image']) ?>" class="w-20 h-20 object-cover rounded shadow border border-gray-200">
                        <?php endif; ?>
                        <div class="flex-1">
                            <input type="file" name="featured_image" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-sm file:font-semibold file:bg-orange-50 file:text-orange-700 hover:file:bg-orange-100" accept="image/*">
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-8 pt-6 border-t border-gray-100 flex justify-end">
                <button type="submit" class="btn-primary flex items-center gap-2">
                    <i data-lucide="save" class="w-4 h-4"></i> Update Project
                </button>
            </div>
        </form>
    </div>

    <!-- Sidebar (Gallery & Expenses) -->
    <div class="space-y-6">
        
        <!-- Expense Summary -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h3 class="font-bold text-gray-800 mb-4 flex items-center gap-2">
                <i data-lucide="circle-dollar-sign" class="w-5 h-5 text-orange-500"></i> Financial Summary
            </h3>
            
            <div class="space-y-4">
                <div class="flex justify-between text-sm">
                    <span class="text-gray-500">Contract Value:</span>
                    <span class="font-bold text-gray-800"><?= format_currency($project['contract_value']) ?></span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-gray-500">Total Expenses:</span>
                    <span class="font-bold text-red-600"><?= format_currency($expSummary['total_expenses']) ?></span>
                </div>
                <div class="flex justify-between text-sm border-t border-gray-100 pt-2">
                    <span class="text-gray-500 font-semibold">Remaining:</span>
                    <?php $remaining = $project['contract_value'] - $expSummary['total_expenses']; ?>
                    <span class="font-bold <?= $remaining < 0 ? 'text-red-600' : 'text-green-600' ?>">
                        <?= format_currency($remaining) ?>
                    </span>
                </div>
                
                <?php 
                $percent = $project['contract_value'] > 0 ? ($expSummary['total_expenses'] / $project['contract_value']) * 100 : 0;
                $pClass = $percent > 90 ? 'bg-danger' : ($percent > 75 ? 'bg-orange-500' : 'bg-success');
                ?>
                <div class="pt-2">
                    <div class="flex justify-between text-xs mb-1">
                        <span class="text-gray-500">Budget Used</span>
                        <span class="font-bold"><?= number_format($percent, 1) ?>%</span>
                    </div>
                    <div class="progress-bar-track">
                        <div class="progress-bar-fill <?= $pClass ?>" style="width: <?= min(100, $percent) ?>%"></div>
                    </div>
                </div>
            </div>
            
            <div class="mt-6 pt-4 border-t border-gray-100 text-center">
                <a href="<?= base_url('admin/expenses/project?project_id=' . $project['id']) ?>" class="text-sm font-semibold text-orange-500 hover:text-orange-600">Manage Expenses &rarr;</a>
            </div>
        </div>

        <!-- Image Gallery -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h3 class="font-bold text-gray-800 mb-4 flex items-center gap-2">
                <i data-lucide="images" class="w-5 h-5 text-orange-500"></i> Project Gallery
            </h3>
            
            <div class="grid grid-cols-2 gap-3 mb-6">
                <?php foreach ($images as $img): ?>
                    <div class="relative group aspect-square rounded overflow-hidden border border-gray-200">
                        <img src="<?= upload_url($img['image_path']) ?>" class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                            <form action="<?= base_url('admin/projects/delete-image/' . $img['id']) ?>" method="POST" data-confirm="Delete this image?">
                                <?= csrf_field() ?>
                                <button type="submit" class="p-2 bg-red-600 text-white rounded-full hover:bg-red-700" title="Delete">
                                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                <?php endforeach; ?>
                <?php if (empty($images)): ?>
                    <div class="col-span-2 text-center py-6 text-gray-400 text-sm border-2 border-dashed border-gray-200 rounded">
                        No additional images.
                    </div>
                <?php endif; ?>
            </div>

            <form action="<?= base_url('admin/projects/upload-image/' . $project['id']) ?>" method="POST" enctype="multipart/form-data" class="bg-gray-50 p-4 rounded border border-gray-200">
                <?= csrf_field() ?>
                <div class="mb-3">
                    <label class="text-xs font-semibold text-gray-600 mb-1 block">Upload New Image</label>
                    <input type="file" name="image" class="w-full text-xs file:mr-2 file:py-1 file:px-2 file:rounded file:border-0 file:text-xs file:bg-white file:border-gray-300" accept="image/*" required>
                </div>
                <div class="mb-3">
                    <input type="text" name="caption" placeholder="Caption (optional)" class="form-control text-sm py-1">
                </div>
                <button type="submit" class="w-full bg-gray-800 text-white text-sm font-semibold py-1.5 rounded hover:bg-gray-900">Upload</button>
            </form>
        </div>

    </div>
</div>
