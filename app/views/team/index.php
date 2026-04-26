<?php $title = 'Our Team'; ?>

<!-- Page Header -->
<section class="bg-gray-900 py-20 relative overflow-hidden">
    <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0naHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmcnIHdpZHRoPSc0MCcgaGVpZ2h0PSc0MCc+PGNpcmNsZSBjeD0nMjAnIGN5PScyMCcgcj0nMicgZmlsbD0nIzMzMycvPjwvc3ZnPg==')] opacity-30"></div>
    
    <div class="container mx-auto px-4 relative z-10 text-center">
        <h1 class="text-5xl font-['Barlow_Condensed'] font-extrabold text-white mb-4">Our Team</h1>
        <div class="flex items-center justify-center gap-2 text-gray-400 text-sm font-semibold uppercase tracking-wider">
            <a href="<?= base_url() ?>" class="hover:text-orange-500">Home</a>
            <i data-lucide="chevron-right" class="w-4 h-4"></i>
            <span class="text-orange-500">Team</span>
        </div>
    </div>
</section>

<!-- Team Section -->
<section class="py-24 bg-white">
    <div class="container mx-auto px-4 max-w-6xl">
        
        <?php if (empty($grouped)): ?>
            <div class="text-center py-20 text-gray-500">
                <p>No team members found.</p>
            </div>
        <?php else: ?>
            
            <?php foreach ($grouped as $department => $members): ?>
                <div class="mb-20 last:mb-0">
                    <div class="flex items-center gap-4 mb-10">
                        <h2 class="text-3xl font-['Barlow_Condensed'] font-bold text-gray-800 uppercase tracking-widest m-0"><?= h($department) ?></h2>
                        <div class="h-px bg-gray-200 flex-1 mt-2"></div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
                        <?php foreach ($members as $member): ?>
                            <div class="bg-gray-50 rounded-xl p-6 text-center border border-gray-100 hover:shadow-xl hover:border-orange-200 transition-all duration-300 group">
                                <div class="w-32 h-32 mx-auto rounded-full overflow-hidden mb-6 shadow-md border-4 border-white group-hover:scale-105 transition-transform duration-300">
                                    <?php if ($member['photo']): ?>
                                        <img src="<?= upload_url($member['photo']) ?>" alt="<?= h($member['name']) ?>" class="w-full h-full object-cover">
                                    <?php else: ?>
                                        <div class="w-full h-full bg-gray-200 flex items-center justify-center text-gray-400">
                                            <i data-lucide="user" class="w-12 h-12"></i>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                
                                <h3 class="text-lg font-bold text-gray-800 mb-1"><?= h($member['name']) ?></h3>
                                <p class="text-orange-500 font-semibold text-sm uppercase tracking-wider mb-3"><?= h($member['designation']) ?></p>
                                
                                <div class="text-gray-500 text-sm flex flex-col gap-1 items-center">
                                    <?php if ($member['qualification']): ?>
                                        <div class="flex items-center gap-1">
                                            <i data-lucide="graduation-cap" class="w-3 h-3"></i> <?= h($member['qualification']) ?>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <?php if ($member['phone']): ?>
                                        <div class="flex items-center gap-1 mt-2">
                                            <i data-lucide="phone" class="w-3 h-3 text-orange-400"></i> <a href="tel:<?= h($member['phone']) ?>" class="hover:text-orange-500"><?= h($member['phone']) ?></a>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <?php if ($member['email']): ?>
                                        <div class="flex items-center gap-1 mt-1">
                                            <i data-lucide="mail" class="w-3 h-3 text-orange-400"></i> <a href="mailto:<?= h($member['email']) ?>" class="hover:text-orange-500 line-clamp-1" title="<?= h($member['email']) ?>"><?= h($member['email']) ?></a>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endforeach; ?>

        <?php endif; ?>
        
    </div>
</section>
