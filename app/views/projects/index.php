<?php $title = 'Our Projects'; ?>

<!-- Page Header -->
<section class="bg-gray-900 py-20 relative overflow-hidden">
    <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0naHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmcnIHdpZHRoPSc0MCcgaGVpZ2h0PSc0MCc+PGNpcmNsZSBjeD0nMjAnIGN5PScyMCcgcj0nMicgZmlsbD0nIzMzMycvPjwvc3ZnPg==')] opacity-30"></div>
    
    <div class="container mx-auto px-4 relative z-10 text-center">
        <h1 class="text-5xl font-['Barlow_Condensed'] font-extrabold text-white mb-4">Our Projects</h1>
        <div class="flex items-center justify-center gap-2 text-gray-400 text-sm font-semibold uppercase tracking-wider">
            <a href="<?= base_url() ?>" class="hover:text-orange-500">Home</a>
            <i data-lucide="chevron-right" class="w-4 h-4"></i>
            <span class="text-orange-500">Projects</span>
        </div>
    </div>
</section>

<!-- Filter Bar -->
<section class="py-8 bg-white border-b border-gray-100 sticky top-[72px] z-40 shadow-sm">
    <div class="container mx-auto px-4">
        <form action="<?= base_url('projects') ?>" method="GET" class="flex flex-wrap items-center gap-4">
            
            <div class="flex-1 min-w-[200px]">
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i data-lucide="search" class="w-4 h-4 text-gray-400"></i>
                    </div>
                    <input type="text" name="search" value="<?= h($filters['search'] ?? '') ?>" placeholder="Search projects, location..." class="form-control pl-10">
                </div>
            </div>

            <div class="w-full sm:w-auto">
                <select name="type" class="form-control cursor-pointer">
                    <option value="">All Categories</option>
                    <option value="civil" <?= ($filters['type'] ?? '') === 'civil' ? 'selected' : '' ?>>Civil Construction</option>
                    <option value="telecom" <?= ($filters['type'] ?? '') === 'telecom' ? 'selected' : '' ?>>Telecom Installation</option>
                    <option value="steel_structure" <?= ($filters['type'] ?? '') === 'steel_structure' ? 'selected' : '' ?>>Steel Structure</option>
                    <option value="maintenance" <?= ($filters['type'] ?? '') === 'maintenance' ? 'selected' : '' ?>>Maintenance</option>
                    <option value="power" <?= ($filters['type'] ?? '') === 'power' ? 'selected' : '' ?>>Power Connection</option>
                    <option value="site_acquisition" <?= ($filters['type'] ?? '') === 'site_acquisition' ? 'selected' : '' ?>>Site Acquisition</option>
                </select>
            </div>

            <div class="w-full sm:w-auto">
                <select name="status" class="form-control cursor-pointer">
                    <option value="">All Statuses</option>
                    <option value="ongoing" <?= ($filters['status'] ?? '') === 'ongoing' ? 'selected' : '' ?>>Ongoing</option>
                    <option value="completed" <?= ($filters['status'] ?? '') === 'completed' ? 'selected' : '' ?>>Completed</option>
                </select>
            </div>

            <button type="submit" class="btn-primary w-full sm:w-auto py-[0.65rem]">Filter</button>
            <?php if (!empty(array_filter($filters))): ?>
                <a href="<?= base_url('projects') ?>" class="text-gray-500 hover:text-orange-500 text-sm font-semibold ml-2">Clear Filters</a>
            <?php endif; ?>
        </form>
    </div>
</section>

<!-- Projects Grid -->
<section class="py-16 bg-gray-50 min-h-[50vh]">
    <div class="container mx-auto px-4">
        
        <?php if (empty($projects)): ?>
            <div class="text-center py-20 bg-white rounded-lg border border-dashed border-gray-300">
                <i data-lucide="folder-search" class="w-16 h-16 text-gray-300 mx-auto mb-4"></i>
                <h3 class="text-xl font-bold text-gray-700 mb-2">No projects found</h3>
                <p class="text-gray-500">Try adjusting your filters or search term.</p>
            </div>
        <?php else: ?>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php foreach ($projects as $project): ?>
                    <a href="<?= base_url('projects/show/' . $project['slug']) ?>" class="project-card block relative bg-white h-full flex flex-col">
                        <div class="aspect-video bg-gray-200 overflow-hidden relative">
                            <?php if ($project['featured_image']): ?>
                                <img src="<?= upload_url($project['featured_image']) ?>" alt="<?= h($project['title']) ?>" class="w-full h-full object-cover">
                            <?php else: ?>
                                <div class="w-full h-full flex items-center justify-center text-gray-400">
                                    <i data-lucide="image" class="w-12 h-12"></i>
                                </div>
                            <?php endif; ?>
                            <div class="absolute top-4 right-4">
                                <?= status_badge($project['status']) ?>
                            </div>
                        </div>
                        <div class="p-6 flex-1 flex flex-col">
                            <div class="mb-2">
                                <span class="text-xs font-bold text-orange-500 uppercase tracking-wider"><?= ucwords(str_replace('_', ' ', $project['project_type'])) ?></span>
                            </div>
                            <h3 class="text-xl font-bold text-gray-800 mb-2 line-clamp-2"><?= h($project['title']) ?></h3>
                            <p class="text-gray-500 text-sm mb-4 flex-1"><i data-lucide="map-pin" class="w-4 h-4 inline text-gray-400"></i> <?= h($project['location']) ?></p>
                            
                            <div class="flex justify-between items-center pt-4 border-t border-gray-100 mt-auto">
                                <div class="text-sm">
                                    <span class="text-gray-400">Client:</span> 
                                    <span class="font-semibold text-gray-700"><?= h($project['client_name'] ?? 'Unknown') ?></span>
                                </div>
                                <?php if ($project['start_date']): ?>
                                    <div class="text-xs text-gray-400">
                                        <?= date('M Y', strtotime($project['start_date'])) ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        
    </div>
</section>
