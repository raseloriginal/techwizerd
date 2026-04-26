<?php $title = 'Contact Us'; ?>

<!-- Page Header -->
<section class="bg-gray-900 py-20 relative overflow-hidden">
    <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0naHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmcnIHdpZHRoPSc0MCcgaGVpZ2h0PSc0MCc+PGNpcmNsZSBjeD0nMjAnIGN5PScyMCcgcj0nMicgZmlsbD0nIzMzMycvPjwvc3ZnPg==')] opacity-30"></div>
    <div class="absolute top-0 right-0 w-1/3 h-full bg-orange-500 opacity-20 transform skew-x-12 translate-x-1/2"></div>
    
    <div class="container mx-auto px-4 relative z-10 text-center">
        <h1 class="text-5xl font-['Barlow_Condensed'] font-extrabold text-white mb-4">Contact Us</h1>
        <div class="flex items-center justify-center gap-2 text-gray-400 text-sm font-semibold uppercase tracking-wider">
            <a href="<?= base_url() ?>" class="hover:text-orange-500">Home</a>
            <i data-lucide="chevron-right" class="w-4 h-4"></i>
            <span class="text-orange-500">Contact</span>
        </div>
    </div>
</section>

<!-- Contact Section -->
<section class="py-24 bg-gray-50">
    <div class="container mx-auto px-4 max-w-6xl">
        
        <?php if ($flash): ?>
            <div class="mb-10 max-w-2xl mx-auto">
                <div class="alert alert-<?= $flash['type'] ?> flex items-start gap-3">
                    <?php if ($flash['type'] === 'success'): ?>
                        <i data-lucide="check-circle" class="w-6 h-6 mt-0.5"></i>
                    <?php else: ?>
                        <i data-lucide="alert-circle" class="w-6 h-6 mt-0.5"></i>
                    <?php endif; ?>
                    <div class="text-lg"><?= $flash['message'] ?></div>
                </div>
            </div>
        <?php endif; ?>

        <div class="flex flex-col lg:flex-row gap-12">
            
            <!-- Contact Info -->
            <div class="w-full lg:w-1/3">
                <h2 class="text-3xl font-['Barlow_Condensed'] font-bold text-gray-800 mb-8 border-l-4 border-orange-500 pl-4">Get In Touch</h2>
                
                <div class="space-y-8">
                    <div class="flex items-start gap-4 group">
                        <div class="w-12 h-12 bg-white rounded-full flex items-center justify-center shadow-sm text-orange-500 group-hover:bg-orange-500 group-hover:text-white transition-colors shrink-0">
                            <i data-lucide="map-pin" class="w-5 h-5"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-800 text-lg mb-1">Office Address</h4>
                            <p class="text-gray-600 leading-relaxed">House No-83, Flat-4A, 5A, Gulshan Badda Link Road, Dhaka-1212</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start gap-4 group">
                        <div class="w-12 h-12 bg-white rounded-full flex items-center justify-center shadow-sm text-orange-500 group-hover:bg-orange-500 group-hover:text-white transition-colors shrink-0">
                            <i data-lucide="phone" class="w-5 h-5"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-800 text-lg mb-1">Phone Number</h4>
                            <p class="text-gray-600 flex flex-col gap-1">
                                <a href="tel:+8801619161842" class="hover:text-orange-500">+8801619161842</a>
                                <a href="tel:01552666676" class="hover:text-orange-500">01552666676</a>
                            </p>
                        </div>
                    </div>
                    
                    <div class="flex items-start gap-4 group">
                        <div class="w-12 h-12 bg-white rounded-full flex items-center justify-center shadow-sm text-orange-500 group-hover:bg-orange-500 group-hover:text-white transition-colors shrink-0">
                            <i data-lucide="mail" class="w-5 h-5"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-800 text-lg mb-1">Email Address</h4>
                            <p class="text-gray-600">
                                <a href="mailto:info.techwizardbd@gmail.com" class="hover:text-orange-500">info.techwizardbd@gmail.com</a>
                            </p>
                        </div>
                    </div>
                </div>

                <div class="mt-12 bg-white p-6 rounded-xl shadow-sm border border-gray-100 text-center">
                    <h4 class="font-bold text-gray-800 mb-2">Business Hours</h4>
                    <p class="text-gray-500 text-sm">Saturday - Thursday: 9:00 AM - 6:00 PM</p>
                    <p class="text-gray-500 text-sm">Friday: Closed</p>
                </div>
            </div>

            <!-- Contact Form -->
            <div class="w-full lg:w-2/3">
                <div class="bg-white rounded-2xl shadow-xl p-8 md:p-10 border border-gray-100">
                    <h3 class="text-2xl font-bold text-gray-800 mb-2">Send us a message</h3>
                    <p class="text-gray-500 mb-8">Fill out the form below and our team will get back to you within 24 hours.</p>

                    <form action="<?= base_url('contact') ?>" method="POST">
                        <?= csrf_field() ?>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div class="form-group mb-0">
                                <label for="name" class="form-label">Full Name <span class="text-red-500">*</span></label>
                                <input type="text" id="name" name="name" class="form-control" required placeholder="John Doe">
                            </div>
                            
                            <div class="form-group mb-0">
                                <label for="email" class="form-label">Email Address <span class="text-red-500">*</span></label>
                                <input type="email" id="email" name="email" class="form-control" required placeholder="john@example.com">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div class="form-group mb-0">
                                <label for="phone" class="form-label">Phone Number</label>
                                <input type="text" id="phone" name="phone" class="form-control" placeholder="+8801...">
                            </div>
                            
                            <div class="form-group mb-0">
                                <label for="subject" class="form-label">Subject</label>
                                <input type="text" id="subject" name="subject" class="form-control" placeholder="How can we help?">
                            </div>
                        </div>

                        <div class="form-group mb-8">
                            <label for="message" class="form-label">Your Message <span class="text-red-500">*</span></label>
                            <textarea id="message" name="message" class="form-control" rows="5" required placeholder="Write your message here..."></textarea>
                        </div>

                        <button type="submit" class="btn-primary w-full md:w-auto text-lg px-10 py-4 flex items-center justify-center gap-2">
                            Send Message <i data-lucide="send" class="w-5 h-5"></i>
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</section>
