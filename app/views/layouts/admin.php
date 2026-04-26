<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= SITE_NAME ?> — Admin Panel</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@400;600;700;800&family=Nunito+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">
    
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
    
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?= asset('css/custom.css') ?>">
</head>
<body class="antialiased bg-gray-50 text-gray-800">

    <!-- Sidebar -->
    <aside class="admin-sidebar bg-white shadow-xl flex flex-col show md:translate-x-0">
        <div class="p-6 border-b border-gray-100 flex justify-between items-center">
            <a href="<?= base_url('admin/dashboard') ?>" class="flex items-center gap-2">
                <i data-lucide="radio-tower" class="text-orange-500 w-6 h-6"></i>
                <span class="font-['Barlow_Condensed'] font-extrabold text-xl tracking-wide">TECH <span class="text-orange-500">WIZARD</span></span>
            </a>
            <button id="sidebar-toggle-close" class="md:hidden text-gray-400 hover:text-gray-600">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>

        <nav class="flex-1 overflow-y-auto py-4">
            <a href="<?= base_url('admin/dashboard') ?>" class="admin-nav-link <?= is_admin_active('dashboard') ?>">
                <i data-lucide="layout-dashboard" class="w-5 h-5"></i> Dashboard
            </a>
            
            <div class="px-5 text-xs font-semibold text-gray-400 uppercase tracking-wider mt-6 mb-2">Management</div>
            
            <a href="<?= base_url('admin/projects') ?>" class="admin-nav-link <?= is_admin_active('projects') ?>">
                <i data-lucide="folder-kanban" class="w-5 h-5"></i> Projects
            </a>
            
            <a href="<?= base_url('admin/expenses/project') ?>" class="admin-nav-link <?= is_admin_active('expenses/project') ?>">
                <i data-lucide="circle-dollar-sign" class="w-5 h-5"></i> Project Expenses
            </a>
            
            <a href="<?= base_url('admin/expenses/company') ?>" class="admin-nav-link <?= is_admin_active('expenses/company') ?>">
                <i data-lucide="building-2" class="w-5 h-5"></i> Company Expenses
            </a>
            
            <a href="<?= base_url('admin/clients') ?>" class="admin-nav-link <?= is_admin_active('clients') ?>">
                <i data-lucide="users" class="w-5 h-5"></i> Clients
            </a>
            
            <a href="<?= base_url('admin/team') ?>" class="admin-nav-link <?= is_admin_active('team') ?>">
                <i data-lucide="contact-2" class="w-5 h-5"></i> Team Members
            </a>
            
            <a href="<?= base_url('admin/services') ?>" class="admin-nav-link <?= is_admin_active('services') ?>">
                <i data-lucide="briefcase" class="w-5 h-5"></i> Services
            </a>
            
            <div class="px-5 text-xs font-semibold text-gray-400 uppercase tracking-wider mt-6 mb-2">System</div>
            
            <a href="<?= base_url('admin/contacts') ?>" class="admin-nav-link <?= is_admin_active('contacts') ?>">
                <i data-lucide="mail" class="w-5 h-5"></i> Messages
            </a>
            
            <a href="<?= base_url('admin/settings') ?>" class="admin-nav-link <?= is_admin_active('settings') ?>">
                <i data-lucide="settings" class="w-5 h-5"></i> Settings
            </a>
        </nav>

        <div class="p-4 border-t border-gray-100">
            <a href="<?= base_url('admin/logout') ?>" class="flex items-center justify-center gap-2 w-full py-2 px-4 rounded text-red-600 hover:bg-red-50 font-semibold transition-colors">
                <i data-lucide="log-out" class="w-4 h-4"></i> Logout
            </a>
        </div>
    </aside>

    <!-- Main Content Wrapper -->
    <div class="admin-content flex flex-col min-h-screen">
        
        <!-- Topbar -->
        <header class="bg-white shadow-sm border-b border-gray-200 sticky top-0 z-40">
            <div class="flex items-center justify-between px-6 py-4">
                <div class="flex items-center gap-4">
                    <button id="sidebar-toggle" class="text-gray-500 hover:text-orange-500 focus:outline-none md:hidden">
                        <i data-lucide="menu" class="w-6 h-6"></i>
                    </button>
                    <h2 class="text-xl font-semibold text-gray-800 m-0"><?= $title ?? 'Dashboard' ?></h2>
                </div>
                
                <div class="flex items-center gap-4">
                    <a href="<?= base_url() ?>" target="_blank" class="text-sm text-gray-500 hover:text-orange-500 hidden sm:flex items-center gap-1">
                        <i data-lucide="external-link" class="w-4 h-4"></i> View Site
                    </a>
                    <div class="h-8 w-px bg-gray-200 hidden sm:block"></div>
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 rounded-full bg-orange-100 text-orange-600 flex items-center justify-center font-bold">
                            <?= substr($_SESSION[ADMIN_SESSION_KEY]['name'] ?? 'A', 0, 1) ?>
                        </div>
                        <span class="text-sm font-medium hidden sm:block"><?= $_SESSION[ADMIN_SESSION_KEY]['name'] ?? 'Admin' ?></span>
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Content Area -->
        <main class="flex-1 p-6">
            
            <?php if (isset($flash) && $flash): ?>
                <div class="alert alert-<?= $flash['type'] ?> mb-6 flex items-start gap-3">
                    <?php if ($flash['type'] === 'success'): ?>
                        <i data-lucide="check-circle" class="w-5 h-5 mt-0.5"></i>
                    <?php else: ?>
                        <i data-lucide="alert-circle" class="w-5 h-5 mt-0.5"></i>
                    <?php endif; ?>
                    <div><?= $flash['message'] ?></div>
                </div>
            <?php endif; ?>

            <?= $content ?>
            
        </main>
        
        <!-- Footer -->
        <footer class="p-6 text-center text-sm text-gray-400 mt-auto">
            &copy; <?= date('Y') ?> Tech Wizard Admin Panel.
        </footer>
    </div>

    <!-- Scripts -->
    <script>
      lucide.createIcons();
      
      // Admin specific logic for mobile sidebar close
      document.getElementById('sidebar-toggle-close')?.addEventListener('click', () => {
          document.querySelector('.admin-sidebar').classList.remove('show');
      });
    </script>
    <script src="<?= asset('js/main.js') ?>"></script>
    
    <!-- Render any custom scripts injected by views -->
    <?= $scripts ?? '' ?>
</body>
</html>
