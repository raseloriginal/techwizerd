document.addEventListener('DOMContentLoaded', function () {

    // ── Mobile navigation toggle ──────────────────────────────────────────────
    const mobileMenuBtn = document.getElementById('mobile-menu-btn');
    const mobileMenu    = document.getElementById('mobile-menu');

    if (mobileMenuBtn && mobileMenu) {
        mobileMenuBtn.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });
    }

    // ── Admin sidebar toggle ──────────────────────────────────────────────────
    const sidebarToggle = document.getElementById('sidebar-toggle');
    const adminSidebar  = document.querySelector('.admin-sidebar');

    if (sidebarToggle && adminSidebar) {
        sidebarToggle.addEventListener('click', () => {
            adminSidebar.classList.toggle('show');
        });
    }

    // ── Flash message auto-dismiss (5 s) ─────────────────────────────────────
    document.querySelectorAll('.alert').forEach(alert => {
        setTimeout(() => {
            alert.style.transition = 'opacity 0.5s ease';
            alert.style.opacity    = '0';
            setTimeout(() => alert.remove(), 500);
        }, 5000);
    });

    // ── File upload preview (requires data-preview="<imgId>" on the input) ───
    document.querySelectorAll('input[type="file"][data-preview]').forEach(input => {
        input.addEventListener('change', function () {
            const file = this.files[0];
            if (!file) return;
            const previewEl = document.getElementById(this.dataset.preview);
            if (!previewEl) return;
            const reader = new FileReader();
            reader.onload = e => {
                previewEl.src = e.target.result;
                previewEl.classList.remove('hidden');
            };
            reader.readAsDataURL(file);
        });
    });

    // ── Confirm delete dialogs ────────────────────────────────────────────────
    document.querySelectorAll('form[data-confirm]').forEach(form => {
        form.addEventListener('submit', function (e) {
            const msg = this.dataset.confirm || 'Are you sure you want to delete this item?';
            if (!confirm(msg)) e.preventDefault();
        });
    });

    // ── Counter animation (IntersectionObserver) ──────────────────────────────
    const counters = document.querySelectorAll('.stat-number');
    if (counters.length > 0) {
        const counterObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (!entry.isIntersecting) return;
                const el         = entry.target;
                const finalValue = parseInt(el.dataset.target, 10) || 0;
                const duration   = 2000;
                const step       = Math.max(1, Math.floor(finalValue / (duration / 16)));
                let current      = 0;

                const tick = () => {
                    current += step;
                    if (current < finalValue) {
                        el.textContent = current + '+';
                        requestAnimationFrame(tick);
                    } else {
                        el.textContent = finalValue + '+';
                    }
                };
                tick();
                observer.unobserve(el);
            });
        }, { threshold: 0.5 });

        counters.forEach(c => counterObserver.observe(c));
    }
    // ─────────────────────────────────────────────────────────────────────────
    // NOTE: Lightbox MUST be outside the counter if-block above.
    // ─────────────────────────────────────────────────────────────────────────

    // ── Gallery lightbox ──────────────────────────────────────────────────────
    const lightbox      = document.getElementById('lightbox-modal');
    const lightboxImg   = lightbox ? lightbox.querySelector('.lightbox-img')   : null;
    const lightboxClose = lightbox ? lightbox.querySelector('.lightbox-close') : null;
    const galleryItems  = document.querySelectorAll('.gallery-item');

    if (lightbox && lightboxImg && galleryItems.length > 0) {

        galleryItems.forEach(item => {
            item.addEventListener('click', () => {
                const img = item.querySelector('img');
                if (img) {
                    lightboxImg.src = img.src;
                    lightboxImg.alt = img.alt || '';
                }
                lightbox.classList.add('active');
                document.body.style.overflow = 'hidden';
            });
        });

        const closeLightbox = () => {
            lightbox.classList.remove('active');
            lightboxImg.src = '';   // clear src so alt text never flashes
            document.body.style.overflow = '';
        };

        if (lightboxClose) {
            lightboxClose.addEventListener('click', closeLightbox);
        }

        lightbox.addEventListener('click', e => {
            if (e.target === lightbox) closeLightbox();
        });

        document.addEventListener('keydown', e => {
            if (e.key === 'Escape' && lightbox.classList.contains('active')) {
                closeLightbox();
            }
        });
    }
});
