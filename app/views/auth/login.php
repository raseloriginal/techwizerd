<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Tech Wizard</title>
    <link rel="stylesheet" href="<?= asset('css/custom.css') ?>">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
      tailwind.config = {
        theme: {
          extend: {
            colors: {
              orange: { 50:'#FFF7F0',100:'#FFF0E0',200:'#FFD9B5',300:'#FFBE80',400:'#FFA04D',500:'#F47920',600:'#D96B12',700:'#B55A0A',800:'#91470A',900:'#6E370A' }
            }
          }
        }
      }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@700;800&family=Nunito+Sans:wght@400;600&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">

    <div class="bg-white p-8 rounded-lg shadow-xl w-full max-w-md border-t-4 border-orange-500">
        
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-orange-100 text-orange-500 rounded-full mb-4">
                <i data-lucide="radio-tower" class="w-8 h-8"></i>
            </div>
            <h1 class="font-['Barlow_Condensed'] font-extrabold text-3xl text-gray-900 tracking-wide">
                TECH <span class="text-orange-500">WIZARD</span>
            </h1>
            <p class="text-gray-500 mt-2">Admin Portal Login</p>
        </div>

        <?php if (!empty($error)): ?>
            <div class="bg-red-50 text-red-600 p-3 rounded mb-6 text-sm flex items-center gap-2 border border-red-200">
                <i data-lucide="alert-circle" class="w-4 h-4"></i> <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <form action="<?= base_url('admin/login') ?>" method="POST">
            <?= csrf_field() ?>
            
            <div class="form-group">
                <label class="form-label" for="email">Email Address</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i data-lucide="mail" class="w-5 h-5 text-gray-400"></i>
                    </div>
                    <input type="email" id="email" name="email" class="form-control pl-10" placeholder="admin@techwizard.com" required autofocus>
                </div>
            </div>

            <div class="form-group mb-8">
                <label class="form-label" for="password">Password</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i data-lucide="lock" class="w-5 h-5 text-gray-400"></i>
                    </div>
                    <input type="password" id="password" name="password" class="form-control pl-10" placeholder="••••••••" required>
                </div>
            </div>

            <button type="submit" class="w-full btn-primary flex justify-center items-center gap-2 py-3 text-lg">
                <i data-lucide="log-in" class="w-5 h-5"></i> Sign In
            </button>
        </form>
        
        <div class="text-center mt-6 text-sm text-gray-500">
            <a href="<?= base_url() ?>" class="hover:text-orange-500 flex items-center justify-center gap-1">
                <i data-lucide="arrow-left" class="w-4 h-4"></i> Back to Website
            </a>
        </div>
    </div>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>
