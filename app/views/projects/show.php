<?php $title = h($project['title']); ?>

<!-- Page Header -->
<section class="bg-gray-900 py-16 relative overflow-hidden">
    <div class="absolute inset-0 opacity-20">
        <?php if ($project['featured_image']): ?>
            <img src="<?= upload_url($project['featured_image']) ?>" class="w-full h-full object-cover blur-sm">
        <?php endif; ?>
    </div>
    
    <div class="container mx-auto px-4 relative z-10">
        <div class="flex items-center gap-2 text-gray-400 text-sm font-semibold uppercase tracking-wider mb-4">
            <a href="<?= base_url() ?>" class="hover:text-orange-500">Home</a>
            <i data-lucide="chevron-right" class="w-4 h-4"></i>
            <a href="<?= base_url('projects') ?>" class="hover:text-orange-500">Projects</a>
            <i data-lucide="chevron-right" class="w-4 h-4"></i>
            <span class="text-orange-500 line-clamp-1"><?= h($project['title']) ?></span>
        </div>
        
        <h1 class="text-4xl md:text-5xl font-['Barlow_Condensed'] font-extrabold text-white mb-4"><?= h($project['title']) ?></h1>
        <div class="flex flex-wrap items-center gap-4 text-gray-300">
            <div class="flex items-center gap-1 bg-white/10 px-3 py-1 rounded-full text-sm">
                <i data-lucide="tag" class="w-4 h-4 text-orange-500"></i>
                <?= ucwords(str_replace('_', ' ', $project['project_type'])) ?>
            </div>
            <div class="flex items-center gap-1 bg-white/10 px-3 py-1 rounded-full text-sm">
                <i data-lucide="map-pin" class="w-4 h-4 text-orange-500"></i>
                <?= h($project['location']) ?>
            </div>
            <?= status_badge($project['status']) ?>
        </div>
    </div>
</section>

<section class="py-16 bg-white">
    <div class="container mx-auto px-4">
        <div class="flex flex-col lg:flex-row gap-12">
            
            <!-- Main Content -->
            <div class="w-full lg:w-2/3">
                <?php if ($project['featured_image']): ?>
                    <div class="rounded-xl overflow-hidden mb-10 shadow-lg">
                        <img src="<?= upload_url($project['featured_image']) ?>" alt="<?= h($project['title']) ?>" class="w-full h-auto object-cover max-h-[500px]">
                    </div>
                <?php endif; ?>
                
                <div class="prose prose-lg max-w-none text-gray-600 mb-12">
                    <h2 class="text-2xl font-bold text-gray-800 mb-4 border-b border-gray-100 pb-2">Project Overview</h2>
                    <div class="whitespace-pre-line leading-relaxed">
                        <?= h($project['description'] ?: 'No description available.') ?>
                    </div>
                    
                    <?php if ($project['scope']): ?>
                        <h2 class="text-2xl font-bold text-gray-800 mt-10 mb-4 border-b border-gray-100 pb-2">Scope of Work</h2>
                        <div class="whitespace-pre-line leading-relaxed">
                            <?= h($project['scope']) ?>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Image Gallery -->
                <?php if (!empty($images)): ?>
                    <h2 class="text-2xl font-bold text-gray-800 mb-6 border-b border-gray-100 pb-2">Project Gallery</h2>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4 mb-12">
                        <?php foreach ($images as $img): ?>
                            <div class="aspect-square rounded-lg overflow-hidden border border-gray-200 cursor-pointer group">
                                <img src="<?= upload_url($img['image_path']) ?>" alt="<?= h($img['caption']) ?>" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Sidebar -->
            <div class="w-full lg:w-1/3">
                <div class="bg-gray-50 rounded-xl p-8 sticky top-24 border border-gray-100">
                    <h3 class="text-xl font-['Barlow_Condensed'] font-bold text-gray-800 mb-6 uppercase tracking-wider border-l-4 border-orange-500 pl-3">Project Details</h3>
                    
                    <ul class="space-y-6">
                        <li>
                            <div class="text-sm text-gray-400 font-semibold uppercase tracking-wider mb-1">Client</div>
                            <div class="font-bold text-gray-800 text-lg"><?= h($project['client_name'] ?? 'N/A') ?></div>
                        </li>
                        
                        <li>
                            <div class="text-sm text-gray-400 font-semibold uppercase tracking-wider mb-1">Location</div>
                            <div class="font-bold text-gray-800 flex items-center gap-2">
                                <i data-lucide="map-pin" class="w-4 h-4 text-orange-500"></i> <?= h($project['location'] ?: 'N/A') ?>
                            </div>
                        </li>
                        
                        <li>
                            <div class="text-sm text-gray-400 font-semibold uppercase tracking-wider mb-1">Category</div>
                            <div class="font-bold text-gray-800"><?= ucwords(str_replace('_', ' ', $project['project_type'])) ?></div>
                        </li>

                        <li class="grid grid-cols-2 gap-4">
                            <div>
                                <div class="text-sm text-gray-400 font-semibold uppercase tracking-wider mb-1">Start Date</div>
                                <div class="font-bold text-gray-800 flex items-center gap-2">
                                    <i data-lucide="calendar" class="w-4 h-4 text-orange-500"></i> <?= format_date($project['start_date']) ?>
                                </div>
                            </div>
                            <div>
                                <div class="text-sm text-gray-400 font-semibold uppercase tracking-wider mb-1">End Date</div>
                                <div class="font-bold text-gray-800 flex items-center gap-2">
                                    <i data-lucide="calendar-check" class="w-4 h-4 text-orange-500"></i> <?= format_date($project['end_date']) ?>
                                </div>
                            </div>
                        </li>

                        <li>
                            <div class="text-sm text-gray-400 font-semibold uppercase tracking-wider mb-1">Status</div>
                            <div class="mt-1"><?= status_badge($project['status']) ?></div>
                        </li>
                    </ul>

                    <div class="mt-10 pt-6 border-t border-gray-200">
                        <a href="<?= base_url('contact') ?>" class="btn-primary w-full text-center">Inquire About Similar Project</a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- Related Projects -->
<?php if (!empty($related)): ?>
<section class="py-16 bg-gray-50 border-t border-gray-100">
    <div class="container mx-auto px-4">
        <h2 class="text-3xl font-['Barlow_Condensed'] font-bold text-gray-800 mb-10 text-center">Related Projects</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <?php foreach ($related as $rel): ?>
                <a href="<?= base_url('projects/show/' . $rel['slug']) ?>" class="project-card block relative bg-white">
                    <div class="aspect-video bg-gray-200 overflow-hidden relative">
                        <?php if ($rel['featured_image']): ?>
                            <img src="<?= upload_url($rel['featured_image']) ?>" class="w-full h-full object-cover">
                        <?php endif; ?>
                    </div>
                    <div class="p-6">
                        <h3 class="text-lg font-bold text-gray-800 mb-2 line-clamp-2"><?= h($rel['title']) ?></h3>
                        <p class="text-gray-500 text-sm"><i data-lucide="map-pin" class="w-4 h-4 inline text-gray-400"></i> <?= h($rel['location']) ?></p>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>
