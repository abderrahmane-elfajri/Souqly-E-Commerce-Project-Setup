/**
 * SOUQLY — Main Application JavaScript (Vanilla ES6+)
 * High performance, zero heavy dependencies.
 */

document.addEventListener('DOMContentLoaded', () => {
    // Mobile navigation toggle
    const mobileMenuBtn = document.querySelector('[data-toggle-menu]');
    const mobileNav = document.querySelector('[data-mobile-menu]');
    if (mobileMenuBtn && mobileNav) {
        mobileMenuBtn.addEventListener('click', () => {
            mobileNav.classList.toggle('hidden');
        });
    }

    // Language switcher handler
    const langSelect = document.querySelector('[data-lang-select]');
    if (langSelect) {
        langSelect.addEventListener('change', (e) => {
            const newLocale = e.target.value;
            const currentPath = window.location.pathname;
            const segments = currentPath.split('/').filter(Boolean);
            if (['fr', 'ar', 'en'].includes(segments[0])) {
                segments[0] = newLocale;
                window.location.href = '/' + segments.join('/') + window.location.search;
            } else {
                window.location.href = '/' + newLocale + currentPath;
            }
        });
    }

    // Dismissable alerts
    document.querySelectorAll('[data-dismiss-alert]').forEach(button => {
        button.addEventListener('click', () => {
            button.closest('.alert')?.remove();
        });
    });
});
