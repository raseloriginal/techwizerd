<!-- Hero Section -->
<section class="hero flex items-center justify-center pt-20 pb-32">
    <div class="hero-grid-bg"></div>
    <div class="container mx-auto px-4 hero-content text-center">
        <h1 class="text-5xl md:text-7xl font-['Barlow_Condensed'] font-extrabold text-white mb-6 tracking-tight leading-tight">
            Keep Your <span class="text-orange-500">World Connected</span>
        </h1>
        <p class="text-xl md:text-2xl text-gray-300 max-w-3xl mx-auto mb-10 leading-relaxed font-light">
            Bangladesh's trusted partner for Telecom, Civil Construction & Steel Structures. Delivering excellence nationwide.
        </p>
        <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
            <a href="<?= base_url('services') ?>" class="btn-primary w-full sm:w-auto text-lg px-8 py-4">View Our Services</a>
            <a href="<?= base_url('contact') ?>" class="w-full sm:w-auto px-8 py-4 rounded-lg font-bold text-white border-2 border-white hover:bg-white hover:text-gray-900 transition-colors text-lg text-center">Contact Us</a>
        </div>
    </div>
</section>

<!-- Stats Section -->
<section class="bg-white -mt-16 relative z-20 shadow-xl mx-4 lg:mx-auto max-w-6xl rounded-xl border border-gray-100">
    <div class="grid grid-cols-2 md:grid-cols-4 divide-x divide-y md:divide-y-0 divide-gray-100">
        <div class="stat-card">
            <div class="stat-number" data-target="10">0</div>
            <div class="stat-label uppercase tracking-widest font-bold mt-2">Years Experience</div>
        </div>
        <div class="stat-card">
            <div class="stat-number" data-target="500">0</div>
            <div class="stat-label uppercase tracking-widest font-bold mt-2">Projects Completed</div>
        </div>
        <div class="stat-card">
            <div class="stat-number" data-target="6">0</div>
            <div class="stat-label uppercase tracking-widest font-bold mt-2">Major Clients</div>
        </div>
        <div class="stat-card">
            <div class="stat-number" data-target="20">0</div>
            <div class="stat-label uppercase tracking-widest font-bold mt-2">Expert Team Members</div>
        </div>
    </div>
</section>

<!-- Services Preview -->
<section class="py-24 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="text-center mb-16 flex flex-col items-center">
            <h2 class="section-title">What We <span>Do</span></h2>
            <div class="section-divider"></div>
            <p class="section-subtitle">Comprehensive solutions for the telecommunications and construction industries.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <?php foreach ($services as $service): ?>
                <div class="service-card group cursor-pointer" onclick="window.location.href='<?= base_url('services') ?>'">
                    <div class="service-icon">
                        <i data-lucide="<?= h($service['icon'] ?: 'settings') ?>" class="w-8 h-8"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-3 text-gray-800"><?= h($service['title']) ?></h3>
                    <p class="text-gray-500 text-sm mb-4 line-clamp-3"><?= h($service['description']) ?></p>
                    <a href="<?= base_url('services') ?>" class="text-orange-500 font-semibold text-sm inline-flex items-center gap-1 group-hover:translate-x-2 transition-transform">
                        Learn More <i data-lucide="arrow-right" class="w-4 h-4"></i>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
        
        <div class="text-center mt-12">
            <a href="<?= base_url('services') ?>" class="inline-block text-gray-600 font-semibold hover:text-orange-500 transition-colors">
                View All Services &rarr;
            </a>
        </div>
    </div>
</section>

<!-- Clients / Trusted By Section -->
<section class="py-20 bg-white border-y border-gray-100 overflow-hidden">
    <div class="container mx-auto px-4 text-center">
        <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Our Partners</p>
        <h3 class="text-3xl font-['Barlow_Condensed'] font-bold text-gray-800 mb-2">Trusted By <span class="text-orange-500">Industry Leaders</span></h3>
        <p class="text-gray-400 text-sm mb-10">We are proud to work alongside Bangladesh's most trusted telecommunications and infrastructure companies.</p>

        <div class="flex flex-wrap justify-center items-center gap-8 md:gap-14">
            <?php foreach ($clients as $client): ?>
                <div class="client-logo-card group">
                    <?php if (!empty($client['logo'])): ?>
                        <img
                            src="<?= upload_url($client['logo']) ?>"
                            alt="<?= h($client['name']) ?>"
                            class="client-logo-img"
                            loading="lazy"
                        >
                    <?php endif; ?>
                    <span class="client-logo-fallback<?= !empty($client['logo']) ? ' text-xs mt-1 opacity-70' : '' ?>">
                        <?= h($client['name']) ?>
                    </span>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Project Gallery -->
<section class="py-24 bg-white">
    <div class="container mx-auto px-4">
        <div class="text-center mb-16 flex flex-col items-center">
            <h2 class="section-title">Our <span>Gallery</span></h2>
            <div class="section-divider"></div>
            <p class="section-subtitle">A visual showcase of our technical expertise and infrastructure projects across Bangladesh.</p>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 md:gap-6">
            <?php
            // Build array from all available gallery images
            $gallery_images = [];
            for ($i = 14; $i <= 49; $i++) {
                $gallery_images[] = $i . '.jpg';
            }
            foreach ($gallery_images as $img):
            ?>
                <div class="gallery-item group">
                    <img src="<?= base_url('images/' . $img) ?>" alt="Tech Wizard Project <?= pathinfo($img, PATHINFO_FILENAME) ?>" loading="lazy">
                    <div class="gallery-overlay">
                        <div class="text-white">
                            <i data-lucide="maximize-2" class="w-6 h-6 mb-1"></i>
                            <p class="text-xs font-bold uppercase tracking-widest">View</p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Lightbox Modal -->
<div id="lightbox-modal" role="dialog" aria-modal="true" aria-label="Image viewer">
    <div class="lightbox-content">
        <span class="lightbox-close" title="Close (Esc)">&times;</span>
        <img src="" alt="" class="lightbox-img">
    </div>
</div>

<!-- Featured Projects -->
<section class="py-24 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="flex flex-col md:flex-row justify-between items-end mb-16">
            <div>
                <h2 class="section-title">Our <span>Work</span></h2>
                <div class="section-divider ml-0"></div>
                <p class="section-subtitle mb-0">Explore some of our recently completed featured projects.</p>
            </div>
            <a href="<?= base_url('projects') ?>" class="btn-primary mt-6 md:mt-0">View All Projects</a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php foreach ($featuredProjects as $project): ?>
                <a href="<?= base_url('projects/show/' . $project['slug']) ?>" class="project-card block relative">
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
                    <div class="p-6">
                        <div class="mb-2">
                            <span class="text-xs font-bold text-orange-500 uppercase tracking-wider"><?= ucwords(str_replace('_', ' ', $project['project_type'])) ?></span>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800 mb-2 line-clamp-2"><?= h($project['title']) ?></h3>
                        <p class="text-gray-500 text-sm mb-4"><i data-lucide="map-pin" class="w-4 h-4 inline text-gray-400"></i> <?= h($project['location']) ?></p>
                        
                        <div class="flex justify-between items-center pt-4 border-t border-gray-100">
                            <div class="text-sm">
                                <span class="text-gray-400">Client:</span> 
                                <span class="font-semibold text-gray-700"><?= h($project['client_name'] ?? 'Unknown') ?></span>
                            </div>
                        </div>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Why Choose Us / CTA Banner -->
<section class="py-24 bg-orange-500 text-white relative overflow-hidden">
    <div class="absolute inset-0 opacity-10 bg-[url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0naHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmcnIHdpZHRoPSc0MCcgaGVpZ2h0PSc0MCc+PGNpcmNsZSBjeD0nMjAnIGN5PScyMCcgcj0nMicgZmlsbD0nI2ZmZicvPjwvc3ZnPg==')]"></div>
    <div class="container mx-auto px-4 relative z-10 text-center">
        <h2 class="text-4xl md:text-5xl font-['Barlow_Condensed'] font-extrabold mb-6">Ready to Start Your Project?</h2>
        <p class="text-xl opacity-90 max-w-2xl mx-auto mb-10">We bring expertise, efficiency, and excellence to every job. Contact us today to discuss your requirements.</p>
        <a href="<?= base_url('contact') ?>" class="inline-block bg-white text-orange-500 font-bold text-lg px-10 py-4 rounded-lg shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all">Contact Us Today</a>
    </div>
</section>

<!-- Team Preview -->
<section class="py-24 bg-white">
    <div class="container mx-auto px-4">
        <div class="text-center mb-16 flex flex-col items-center">
            <h2 class="section-title">Meet Our <span>Leaders</span></h2>
            <div class="section-divider"></div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            <?php foreach ($leaders as $member): ?>
                <div class="text-center group">
                    <div class="w-48 h-48 mx-auto rounded-full overflow-hidden mb-6 bg-gray-100 shadow-lg border-4 border-white ring-4 ring-gray-50 group-hover:ring-orange-100 transition-all duration-300">
                        <?php if ($member['photo']): ?>
                            <img src="<?= upload_url($member['photo']) ?>" alt="<?= h($member['name']) ?>" class="w-full h-full object-cover">
                        <?php else: ?>
                            <div class="w-full h-full flex items-center justify-center text-gray-300">
                                <i data-lucide="user" class="w-16 h-16"></i>
                            </div>
                        <?php endif; ?>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-1"><?= h($member['name']) ?></h3>
                    <p class="text-orange-500 font-semibold text-sm uppercase tracking-wider"><?= h($member['designation']) ?></p>
                </div>
            <?php endforeach; ?>
        </div>
        
        <div class="text-center mt-12">
            <a href="<?= base_url('team') ?>" class="btn-primary">View Full Team</a>
        </div>
    </div>
</section>
