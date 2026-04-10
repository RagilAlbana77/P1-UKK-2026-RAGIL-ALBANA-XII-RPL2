import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

const DEFAULT_LOADING_TEXT = 'Memproses...';

document.addEventListener('DOMContentLoaded', () => {
    const loadingOverlay = document.getElementById('global-loading-overlay');

    document.querySelectorAll('form').forEach((form) => {
        form.addEventListener(
            'submit',
            () => {
                form.querySelectorAll('button[type="submit"], input[type="submit"]').forEach((button) => {
                    if (button.disabled) {
                        return;
                    }

                    const loadingText = button.getAttribute('data-loading-text') ?? DEFAULT_LOADING_TEXT;

                    if (button.tagName === 'INPUT') {
                        button.value = loadingText;
                    } else {
                        button.innerText = loadingText;
                    }

                    button.disabled = true;
                    button.classList.add('opacity-70', 'cursor-not-allowed');
                });

                if (loadingOverlay) {
                    loadingOverlay.classList.remove('hidden');
                    loadingOverlay.classList.add('flex');
                    loadingOverlay.setAttribute('aria-hidden', 'false');
                }
            },
            { once: true }
        );
    });
});
