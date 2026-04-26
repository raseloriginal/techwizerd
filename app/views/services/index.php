<?php $title = 'Our Services'; ?>

<!-- Page Header -->
<section class="bg-gray-900 py-20 relative overflow-hidden">
    <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0naHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmcnIHdpZHRoPSc0MCcgaGVpZ2h0PSc0MCc+PGNpcmNsZSBjeD0nMjAnIGN5PScyMCcgcj0nMicgZmlsbD0nIzMzMycvPjwvc3ZnPg==')] opacity-30"></div>
    <div class="absolute top-0 left-0 w-1/3 h-full bg-orange-500 opacity-20 transform -skew-x-12 -translate-x-1/4"></div>
    
    <div class="container mx-auto px-4 relative z-10 text-center">
        <h1 class="text-5xl font-['Barlow_Condensed'] font-extrabold text-white mb-4">Our Services</h1>
        <div class="flex items-center justify-center gap-2 text-gray-400 text-sm font-semibold uppercase tracking-wider">
            <a href="<?= base_url() ?>" class="hover:text-orange-500">Home</a>
            <i data-lucide="chevron-right" class="w-4 h-4"></i>
            <span class="text-orange-500">Services</span>
        </div>
    </div>
</section>

<!-- Services List -->
<section class="py-24 bg-white">
    <div class="container mx-auto px-4 max-w-5xl">
        <div class="text-center mb-16 flex flex-col items-center">
            <h2 class="section-title">What We <span>Deliver</span></h2>
            <div class="section-divider"></div>
            <p class="section-subtitle">Comprehensive solutions tailored for the telecommunications and civil construction sectors.</p>
        </div>

        <div class="space-y-16">
            <?php foreach ($services as $index => $service): ?>
                <div class="flex flex-col <?= $index % 2 === 0 ? 'md:flex-row' : 'md:flex-row-reverse' ?> gap-8 md:gap-12 items-center group">
                    <div class="w-full md:w-1/3">
                        <div class="aspect-square bg-gray-50 rounded-2xl flex items-center justify-center border border-gray-100 group-hover:border-orange-200 group-hover:bg-orange-50 transition-colors relative overflow-hidden">
                            <!-- Background decorative icon -->
                            <i data-lucide="<?= h($service['icon'] ?: 'settings') ?>" class="w-64 h-64 text-gray-100 absolute -right-10 -bottom-10 group-hover:text-orange-100 transition-colors"></i>
                            
                            <!-- Main icon -->
                            <i data-lucide="<?= h($service['icon'] ?: 'settings') ?>" class="w-24 h-24 text-orange-500 relative z-10 group-hover:scale-110 transition-transform duration-500"></i>
                        </div>
                    </div>
                    <div class="w-full md:w-2/3">
                        <div class="text-orange-500 font-bold text-6xl opacity-10 font-['Barlow_Condensed'] absolute -mt-8 -ml-4">0<?= $index + 1 ?></div>
                        <h3 class="text-3xl font-bold text-gray-800 mb-4 relative z-10"><?= h($service['title']) ?></h3>
                        <p class="text-lg text-gray-600 leading-relaxed mb-6">
                            <?= h($service['description']) ?>
                        </p>
                        
                        <?php
                        // Example capability list mapping based on slug
                        $capabilities = [];
                        if ($service['slug'] === 'site-acquisition') {
                            $capabilities = ['Initial Site Investigation', 'Proposal Submission', 'Owner Negotiation', 'Deed Agreement Signing', 'Site Handover'];
                        } elseif ($service['slug'] === 'civil-construction') {
                            $capabilities = ['Site Layout & Survey', 'Piling & Casting', 'Brickwork & Plaster', 'Painting & Finishing', 'Electrical Wiring'];
                        } elseif ($service['slug'] === 'telecom-installation') {
                            $capabilities = ['MW & BTS Installation', 'Outdoor Equipment setup', 'Feeder Cable Routing', 'Antenna System Install', 'Commissioning'];
                        }
                        ?>
                        
                        <?php if (!empty($capabilities)): ?>
                            <ul class="grid grid-cols-1 sm:grid-cols-2 gap-3 mt-4">
                                <?php foreach ($capabilities as $cap): ?>
                                    <li class="flex items-start gap-2 text-gray-700">
                                        <i data-lucide="check-circle-2" class="w-5 h-5 text-orange-500 shrink-0 mt-0.5"></i>
                                        <span><?= $cap ?></span>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Technical Roadmap -->
<section class="py-24 bg-gray-50 border-t border-gray-200">
    <div class="container mx-auto px-4">
        <div class="text-center mb-20 flex flex-col items-center">
            <h2 class="section-title">Our Working <span>Process</span></h2>
            <div class="section-divider"></div>
        </div>

        <div class="max-w-6xl mx-auto relative">
            <!-- Connecting Line -->
            <div class="hidden md:block absolute top-1/2 left-0 w-full h-1 bg-gray-200 -translate-y-1/2 z-0"></div>
            
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12 relative z-10">
                <div class="text-center">
                    <div class="w-20 h-20 mx-auto bg-white border-4 border-orange-500 rounded-full flex items-center justify-center text-orange-500 text-2xl font-bold mb-6 shadow-lg">1</div>
                    <h4 class="text-xl font-bold text-gray-800 mb-2">Contract & Plan</h4>
                    <p class="text-gray-500 text-sm">Initial agreement, site survey, and project planning.</p>
                </div>
                
                <div class="text-center">
                    <div class="w-20 h-20 mx-auto bg-white border-4 border-orange-500 rounded-full flex items-center justify-center text-orange-500 text-2xl font-bold mb-6 shadow-lg">2</div>
                    <h4 class="text-xl font-bold text-gray-800 mb-2">Design & Procure</h4>
                    <p class="text-gray-500 text-sm">Engineering design, approvals, and material sourcing.</p>
                </div>
                
                <div class="text-center">
                    <div class="w-20 h-20 mx-auto bg-white border-4 border-orange-500 rounded-full flex items-center justify-center text-orange-500 text-2xl font-bold mb-6 shadow-lg">3</div>
                    <h4 class="text-xl font-bold text-gray-800 mb-2">Execution</h4>
                    <p class="text-gray-500 text-sm">Civil construction, installation, and deployment.</p>
                </div>
                
                <div class="text-center">
                    <div class="w-20 h-20 mx-auto bg-white border-4 border-orange-500 rounded-full flex items-center justify-center text-orange-500 text-2xl font-bold mb-6 shadow-lg">4</div>
                    <h4 class="text-xl font-bold text-gray-800 mb-2">Test & Handover</h4>
                    <p class="text-gray-500 text-sm">Quality checks, commissioning, and final handover.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA -->
<section class="py-16 bg-dark text-center border-t-4 border-orange-500">
    <div class="container mx-auto px-4">
        <h2 class="text-3xl font-bold text-white mb-6">Need a custom solution for your network?</h2>
        <a href="<?= base_url('contact') ?>" class="btn-primary px-8 py-3 text-lg">Discuss Your Project</a>
    </div>
</section>
