<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= SITE_NAME ?> — <?= htmlspecialchars($title ?? 'Keep Your World Connected') ?></title>
    
    <!-- Custom CSS (base styles first) -->
    <link rel="stylesheet" href="<?= asset('css/custom.css') ?>">

    <!-- Tailwind CSS (CDN utilities override/extend base) -->
    <script>
      window.tailwind = { config: {
        theme: {
          extend: {
            colors: {
              orange: { 50:'#FFF7F0',100:'#FFF0E0',200:'#FFD9B5',300:'#FFBE80',400:'#FFA04D',500:'#F47920',600:'#D96B12',700:'#B55A0A',800:'#91470A',900:'#6E370A' }
            },
            fontFamily: {
              barlow: ['Barlow Condensed', 'sans-serif'],
              nunito: ['Nunito Sans', 'sans-serif']
            }
          }
        }
      }}
    </script>
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@400;600;700;800&family=Nunito+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">
    
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body class="antialiased">

    <!-- Header / Navbar -->
    <header class="navbar">
        <div class="container mx-auto px-4 py-4 flex items-center justify-between">
            <a href="<?= base_url() ?>" class="flex items-center gap-2">
                <!-- Logo placeholder, in production use an SVG -->
                <i data-lucide="radio-tower" class="text-orange-500 w-8 h-8"></i>
                <span class="logo-text">TECH <span>WIZARD</span></span>
            </a>

            <!-- Desktop Nav -->
            <nav class="hidden md:flex items-center gap-6">
                <a href="<?= base_url() ?>" class="nav-link <?= active('') ?>">Home</a>
                <a href="<?= base_url('about') ?>" class="nav-link <?= active('about') ?>">About</a>
                <a href="<?= base_url('services') ?>" class="nav-link <?= active('services') ?>">Services</a>
                <a href="<?= base_url('projects') ?>" class="nav-link <?= active('projects') ?>">Projects</a>
                <a href="<?= base_url('team') ?>" class="nav-link <?= active('team') ?>">Team</a>
                <a href="<?= base_url('contact') ?>" class="nav-link <?= active('contact') ?>">Contact</a>
                <a href="<?= base_url('contact') ?>" class="btn-primary ml-4">Get a Quote</a>
            </nav>

            <!-- Mobile menu button -->
            <button id="mobile-menu-btn" class="md:hidden text-gray-800">
                <i data-lucide="menu" class="w-6 h-6"></i>
            </button>
        </div>

        <!-- Mobile Nav -->
        <div id="mobile-menu" class="hidden md:hidden bg-white border-t border-gray-100 p-4 absolute w-full left-0">
            <div class="flex flex-col gap-4">
                <a href="<?= base_url() ?>" class="nav-link <?= active('') ?>">Home</a>
                <a href="<?= base_url('about') ?>" class="nav-link <?= active('about') ?>">About</a>
                <a href="<?= base_url('services') ?>" class="nav-link <?= active('services') ?>">Services</a>
                <a href="<?= base_url('projects') ?>" class="nav-link <?= active('projects') ?>">Projects</a>
                <a href="<?= base_url('team') ?>" class="nav-link <?= active('team') ?>">Team</a>
                <a href="<?= base_url('contact') ?>" class="nav-link <?= active('contact') ?>">Contact</a>
                <a href="<?= base_url('contact') ?>" class="btn-primary inline-block text-center mt-2">Get a Quote</a>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main>
        <?= $content ?>
    </main>

    <!-- Footer -->
    <footer class="footer pt-16 pb-8">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-12">
                <div>
                    <a href="<?= base_url() ?>" class="flex items-center gap-2 mb-6">
                        <i data-lucide="radio-tower" class="text-orange-500 w-8 h-8"></i>
                        <span class="footer-logo">TECH <span>WIZARD</span></span>
                    </a>
                    <p class="mb-6 text-gray-400">Bangladesh's trusted partner for Telecom, Civil Construction & Steel Structures.</p>
                </div>
                
                <div>
                    <h4 class="text-white text-xl mb-6 border-b border-gray-700 pb-2 inline-block">Quick Links</h4>
                    <ul class="flex flex-col gap-3">
                        <li><a href="<?= base_url('about') ?>">About Us</a></li>
                        <li><a href="<?= base_url('projects') ?>">Our Projects</a></li>
                        <li><a href="<?= base_url('team') ?>">Our Team</a></li>
                        <li><a href="<?= base_url('contact') ?>">Contact Us</a></li>
                        <li><a href="<?= base_url('admin/login') ?>">Admin Login</a></li>
                    </ul>
                </div>
                
                <div>
                    <h4 class="text-white text-xl mb-6 border-b border-gray-700 pb-2 inline-block">Our Services</h4>
                    <ul class="flex flex-col gap-3">
                        <li><a href="<?= base_url('services') ?>">Site Acquisition</a></li>
                        <li><a href="<?= base_url('services') ?>">Civil Construction</a></li>
                        <li><a href="<?= base_url('services') ?>">Telecom Installation</a></li>
                        <li><a href="<?= base_url('services') ?>">Maintenance</a></li>
                    </ul>
                </div>
                
                <div>
                    <h4 class="text-white text-xl mb-6 border-b border-gray-700 pb-2 inline-block">Contact Info</h4>
                    <ul class="flex flex-col gap-4 text-gray-400">
                        <li class="flex items-start gap-3">
                            <i data-lucide="map-pin" class="w-5 h-5 text-orange-500 flex-shrink-0 mt-1"></i>
                            <span>House No-83, Flat-4A, 5A, Gulshan Badda Link Road, Dhaka-1212</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <i data-lucide="phone" class="w-5 h-5 text-orange-500 flex-shrink-0"></i>
                            <span>+8801619161842, 01552666676</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <i data-lucide="mail" class="w-5 h-5 text-orange-500 flex-shrink-0"></i>
                            <span>info.techwizardbd@gmail.com</span>
                        </li>
                    </ul>
                </div>
            </div>
            
            <div class="border-t border-gray-800 pt-8 flex flex-col md:flex-row justify-between items-center text-gray-500 text-sm">
                <p>&copy; <?= date('Y') ?> Tech Wizard. All rights reserved.</p>
                <div class="flex gap-4 mt-4 md:mt-0">
                    <a href="#" class="hover:text-orange-500"><i data-lucide="facebook" class="w-5 h-5"></i></a>
                    <a href="#" class="hover:text-orange-500"><i data-lucide="linkedin" class="w-5 h-5"></i></a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script>
      lucide.createIcons();
    </script>
    <script src="<?= asset('js/main.js') ?>"></script>
</body>
</html>
