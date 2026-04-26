<?php $title = 'About Us'; ?>

<!-- Page Header -->
<section class="bg-gray-900 py-20 relative overflow-hidden">
    <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0naHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmcnIHdpZHRoPSc0MCcgaGVpZ2h0PSc0MCc+PGNpcmNsZSBjeD0nMjAnIGN5PScyMCcgcj0nMicgZmlsbD0nIzMzMycvPjwvc3ZnPg==')] opacity-30"></div>
    <!-- Diagonal orange accent -->
    <div class="absolute top-0 right-0 w-1/3 h-full bg-orange-500 opacity-20 transform skew-x-12 translate-x-1/2"></div>
    
    <div class="container mx-auto px-4 relative z-10 text-center">
        <h1 class="text-5xl font-['Barlow_Condensed'] font-extrabold text-white mb-4">About Us</h1>
        <div class="flex items-center justify-center gap-2 text-gray-400 text-sm font-semibold uppercase tracking-wider">
            <a href="<?= base_url() ?>" class="hover:text-orange-500">Home</a>
            <i data-lucide="chevron-right" class="w-4 h-4"></i>
            <span class="text-orange-500">About</span>
        </div>
    </div>
</section>

<!-- Company Story -->
<section class="py-24 bg-white">
    <div class="container mx-auto px-4">
        <div class="flex flex-col lg:flex-row gap-16 items-center">
            <div class="w-full lg:w-3/5">
                <h2 class="section-title mb-6">Our <span>Story</span></h2>
                <div class="section-divider"></div>
                
                <div class="prose prose-lg text-gray-600">
                    <p class="text-xl leading-relaxed mb-6 font-light">
                        <?= h($settings['site_description'] ?? 'Tech Wizard is a leading telecom and civil construction contractor in Bangladesh providing quality services to major telecom operators.') ?>
                    </p>
                    <p class="mb-4">
                        Founded with a vision to revolutionize the telecommunications infrastructure in Bangladesh, Tech Wizard has grown into a trusted partner for industry giants. We specialize in end-to-end solutions ranging from site acquisition to full-scale civil construction and network maintenance.
                    </p>
                    <p>
                        Our commitment to quality, safety, and timely delivery has earned us a reputation for excellence. We take pride in our highly skilled workforce and our ability to tackle complex engineering challenges across the nation.
                    </p>
                </div>
            </div>
            
            <div class="w-full lg:w-2/5">
                <div class="bg-orange-500 p-10 rounded-2xl text-white shadow-2xl relative">
                    <!-- Decorative element -->
                    <div class="absolute top-0 right-0 text-white opacity-10">
                        <i data-lucide="radio-tower" class="w-48 h-48 -mt-8 -mr-8"></i>
                    </div>
                    
                    <h3 class="text-3xl font-['Barlow_Condensed'] font-bold mb-8 relative z-10">Company at a Glance</h3>
                    
                    <ul class="space-y-6 relative z-10">
                        <li class="flex items-start gap-4">
                            <div class="bg-white/20 p-2 rounded text-white mt-1">
                                <i data-lucide="calendar" class="w-5 h-5"></i>
                            </div>
                            <div>
                                <span class="block text-sm uppercase tracking-wider font-semibold opacity-80">Established</span>
                                <span class="text-xl font-bold">2012</span>
                            </div>
                        </li>
                        <li class="flex items-start gap-4">
                            <div class="bg-white/20 p-2 rounded text-white mt-1">
                                <i data-lucide="map" class="w-5 h-5"></i>
                            </div>
                            <div>
                                <span class="block text-sm uppercase tracking-wider font-semibold opacity-80">Coverage</span>
                                <span class="text-xl font-bold">Nationwide (Bangladesh)</span>
                            </div>
                        </li>
                        <li class="flex items-start gap-4">
                            <div class="bg-white/20 p-2 rounded text-white mt-1">
                                <i data-lucide="users" class="w-5 h-5"></i>
                            </div>
                            <div>
                                <span class="block text-sm uppercase tracking-wider font-semibold opacity-80">Workforce</span>
                                <span class="text-xl font-bold">50+ Technical Experts</span>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Mission & Vision -->
<section class="py-24 bg-gray-50 border-t border-gray-100">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="bg-white p-10 rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow group">
                <div class="w-16 h-16 bg-orange-50 rounded-2xl flex items-center justify-center mb-6 text-orange-500 group-hover:scale-110 transition-transform">
                    <i data-lucide="target" class="w-8 h-8"></i>
                </div>
                <h3 class="text-2xl font-bold text-gray-800 mb-4">Our Mission</h3>
                <p class="text-gray-600 leading-relaxed">
                    To deliver innovative, reliable, and high-quality infrastructure solutions that empower our clients to build a more connected world, while ensuring safety and environmental sustainability.
                </p>
            </div>
            
            <div class="bg-white p-10 rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow group relative overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-1 bg-orange-500"></div>
                <div class="w-16 h-16 bg-orange-50 rounded-2xl flex items-center justify-center mb-6 text-orange-500 group-hover:scale-110 transition-transform">
                    <i data-lucide="eye" class="w-8 h-8"></i>
                </div>
                <h3 class="text-2xl font-bold text-gray-800 mb-4">Our Vision</h3>
                <p class="text-gray-600 leading-relaxed">
                    To be the leading and most trusted engineering and construction partner in the telecommunications sector of Bangladesh, setting industry benchmarks for excellence.
                </p>
            </div>
            
            <div class="bg-white p-10 rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow group">
                <div class="w-16 h-16 bg-orange-50 rounded-2xl flex items-center justify-center mb-6 text-orange-500 group-hover:scale-110 transition-transform">
                    <i data-lucide="heart" class="w-8 h-8"></i>
                </div>
                <h3 class="text-2xl font-bold text-gray-800 mb-4">Our Values</h3>
                <p class="text-gray-600 leading-relaxed">
                    Integrity, Quality, Safety, Innovation, and Teamwork. We believe in building lasting relationships based on transparency and mutual trust.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Certifications -->
<section class="py-24 bg-white border-t border-gray-100">
    <div class="container mx-auto px-4">
        <div class="text-center mb-16 flex flex-col items-center">
            <h2 class="section-title">Legal & <span>Credentials</span></h2>
            <div class="section-divider"></div>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 max-w-5xl mx-auto">
            <div class="border border-gray-200 p-6 rounded-lg text-center hover:border-orange-500 transition-colors">
                <i data-lucide="file-text" class="w-10 h-10 text-gray-400 mx-auto mb-4"></i>
                <div class="text-sm text-gray-500 uppercase tracking-wider font-semibold mb-2">Trade License</div>
                <div class="text-lg font-bold text-gray-800">TRAD/DNCC/050231/2022</div>
            </div>
            <div class="border border-gray-200 p-6 rounded-lg text-center hover:border-orange-500 transition-colors">
                <i data-lucide="file-digit" class="w-10 h-10 text-gray-400 mx-auto mb-4"></i>
                <div class="text-sm text-gray-500 uppercase tracking-wider font-semibold mb-2">TIN</div>
                <div class="text-lg font-bold text-gray-800">228441662024</div>
            </div>
            <div class="border border-gray-200 p-6 rounded-lg text-center hover:border-orange-500 transition-colors">
                <i data-lucide="file-badge" class="w-10 h-10 text-gray-400 mx-auto mb-4"></i>
                <div class="text-sm text-gray-500 uppercase tracking-wider font-semibold mb-2">BIN / VAT Registration</div>
                <div class="text-lg font-bold text-gray-800">003581231-0101</div>
            </div>
            <div class="border border-gray-200 p-6 rounded-lg text-center hover:border-orange-500 transition-colors">
                <i data-lucide="landmark" class="w-10 h-10 text-gray-400 mx-auto mb-4"></i>
                <div class="text-sm text-gray-500 uppercase tracking-wider font-semibold mb-2">Legal Status</div>
                <div class="text-lg font-bold text-gray-800">Partnership</div>
            </div>
        </div>
    </div>
</section>
