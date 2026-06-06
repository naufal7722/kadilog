/**
 * KasaLog - Global JavaScript Utilities
 * Sistem Informasi Distribusi UMKM Antarpulau
 */

document.addEventListener('DOMContentLoaded', function () {

    // ========================================
    // 1. SIDEBAR TOGGLE
    // ========================================
    const sidebar = document.getElementById('sidebar');
    const sidebarOverlay = document.getElementById('sidebar-overlay');
    const sidebarToggleBtn = document.getElementById('sidebar-toggle');
    const sidebarCollapseBtn = document.getElementById('sidebar-collapse');
    const mainContent = document.getElementById('main-content');

    // Mobile: open/close drawer
    if (sidebarToggleBtn) {
        sidebarToggleBtn.addEventListener('click', function () {
            sidebar.classList.toggle('-translate-x-full');
            sidebarOverlay.classList.toggle('hidden');
        });
    }

    if (sidebarOverlay) {
        sidebarOverlay.addEventListener('click', function () {
            sidebar.classList.add('-translate-x-full');
            sidebarOverlay.classList.add('hidden');
        });
    }

    // Desktop: collapse/expand
    if (sidebarCollapseBtn) {
        sidebarCollapseBtn.addEventListener('click', function () {
            sidebar.classList.toggle('sidebar-collapsed');
            sidebar.classList.toggle('w-64');
            sidebar.classList.toggle('w-[70px]');
            if (mainContent) {
                mainContent.classList.toggle('lg:ml-64');
                mainContent.classList.toggle('lg:ml-[70px]');
            }
            // Save state
            const isCollapsed = sidebar.classList.contains('sidebar-collapsed');
            localStorage.setItem('sidebar-collapsed', isCollapsed);
        });

        // Restore state
        const savedState = localStorage.getItem('sidebar-collapsed');
        if (savedState === 'true') {
            sidebar.classList.add('sidebar-collapsed', 'w-[70px]');
            sidebar.classList.remove('w-64');
            if (mainContent) {
                mainContent.classList.remove('lg:ml-64');
                mainContent.classList.add('lg:ml-[70px]');
            }
        }
    }

    // ========================================
    // 2. MODAL MANAGEMENT
    // ========================================
    window.openModal = function (modalId) {
        const modal = document.getElementById(modalId);
        if (!modal) return;
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        document.body.style.overflow = 'hidden';
        // Focus first input
        setTimeout(() => {
            const firstInput = modal.querySelector('input:not([type="hidden"]), select, textarea');
            if (firstInput) firstInput.focus();
        }, 100);
    };

    window.closeModal = function (modalId) {
        const modal = document.getElementById(modalId);
        if (!modal) return;
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        document.body.style.overflow = '';
        // Reset form if exists
        const form = modal.querySelector('form');
        if (form) form.reset();
    };

    // Close modal on backdrop click
    document.querySelectorAll('[data-modal-backdrop]').forEach(function (backdrop) {
        backdrop.addEventListener('click', function (e) {
            if (e.target === backdrop) {
                const modalId = backdrop.id;
                closeModal(modalId);
            }
        });
    });

    // Close modal on Escape key
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') {
            document.querySelectorAll('[data-modal-backdrop]:not(.hidden)').forEach(function (modal) {
                closeModal(modal.id);
            });
        }
    });

    // ========================================
    // 3. DROPDOWN TOGGLE
    // ========================================
    document.querySelectorAll('[data-dropdown-toggle]').forEach(function (trigger) {
        trigger.addEventListener('click', function (e) {
            e.stopPropagation();
            const targetId = trigger.getAttribute('data-dropdown-toggle');
            const dropdown = document.getElementById(targetId);
            if (!dropdown) return;

            // Close other dropdowns
            document.querySelectorAll('.dropdown-menu:not(.hidden)').forEach(function (d) {
                if (d.id !== targetId) d.classList.add('hidden');
            });

            dropdown.classList.toggle('hidden');
        });
    });

    // Close dropdowns on outside click
    document.addEventListener('click', function () {
        document.querySelectorAll('.dropdown-menu:not(.hidden)').forEach(function (d) {
            d.classList.add('hidden');
        });
    });

    // ========================================
    // 4. TABLE SEARCH
    // ========================================
    document.querySelectorAll('[data-table-search]').forEach(function (input) {
        input.addEventListener('input', function () {
            const tableId = input.getAttribute('data-table-search');
            const table = document.getElementById(tableId);
            if (!table) return;

            const query = input.value.toLowerCase().trim();
            const rows = table.querySelectorAll('tbody tr');

            rows.forEach(function (row) {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(query) ? '' : 'none';
            });

            // Update count
            const visibleCount = table.querySelectorAll('tbody tr:not([style*="display: none"])').length;
            const countEl = document.getElementById(tableId + '-count');
            if (countEl) countEl.textContent = visibleCount;
        });
    });

    // ========================================
    // 5. TOAST NOTIFICATIONS
    // ========================================
    window.showToast = function (message, type = 'success', duration = 3000) {
        let container = document.querySelector('.toast-container');
        if (!container) {
            container = document.createElement('div');
            container.className = 'toast-container';
            document.body.appendChild(container);
        }

        const icons = {
            success: '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>',
            error: '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>',
            info: '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>',
            warning: '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"/></svg>'
        };

        const colors = {
            success: 'bg-success-50 text-success-700 border-success-500',
            error: 'bg-danger-50 text-danger-700 border-danger-500',
            info: 'bg-info-50 text-info-600 border-info-500',
            warning: 'bg-warning-50 text-warning-700 border-warning-500'
        };

        const toast = document.createElement('div');
        toast.className = `toast flex items-center gap-3 px-4 py-3 rounded-lg border-l-4 shadow-lg min-w-[320px] ${colors[type] || colors.info}`;
        toast.innerHTML = `
            ${icons[type] || icons.info}
            <span class="flex-1 text-sm font-medium">${message}</span>
            <button onclick="this.parentElement.remove()" class="opacity-60 hover:opacity-100 transition-opacity">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        `;

        container.appendChild(toast);

        setTimeout(function () {
            toast.classList.add('toast-exit');
            setTimeout(function () { toast.remove(); }, 200);
        }, duration);
    };

    // ========================================
    // 6. DELETE CONFIRMATION
    // ========================================
    window.confirmDelete = function (itemName, callback) {
        const modalHtml = `
            <div id="delete-confirm-modal" data-modal-backdrop class="fixed inset-0 z-50 flex items-center justify-center modal-backdrop">
                <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md mx-4 animate-scale-in">
                    <div class="p-6 text-center">
                        <div class="mx-auto w-14 h-14 rounded-full bg-danger-50 flex items-center justify-center mb-4">
                            <svg class="w-7 h-7 text-danger-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-secondary-900 mb-2">Hapus Data</h3>
                        <p class="text-secondary-500 text-sm">Apakah Anda yakin ingin menghapus <strong class="text-secondary-700">${itemName}</strong>? Tindakan ini tidak dapat dibatalkan.</p>
                    </div>
                    <div class="flex gap-3 px-6 pb-6">
                        <button onclick="document.getElementById('delete-confirm-modal').remove(); document.body.style.overflow='';" class="flex-1 px-4 py-2.5 text-sm font-medium text-secondary-700 bg-secondary-100 rounded-xl hover:bg-secondary-200 transition-colors">
                            Batal
                        </button>
                        <button id="confirm-delete-btn" class="flex-1 px-4 py-2.5 text-sm font-medium text-white bg-danger-500 rounded-xl hover:bg-danger-600 transition-colors">
                            Ya, Hapus
                        </button>
                    </div>
                </div>
            </div>
        `;

        document.body.insertAdjacentHTML('beforeend', modalHtml);
        document.body.style.overflow = 'hidden';

        document.getElementById('confirm-delete-btn').addEventListener('click', function () {
            document.getElementById('delete-confirm-modal').remove();
            document.body.style.overflow = '';
            if (typeof callback === 'function') callback();
            showToast('Data berhasil dihapus', 'success');
        });

        document.getElementById('delete-confirm-modal').addEventListener('click', function (e) {
            if (e.target === this) {
                this.remove();
                document.body.style.overflow = '';
            }
        });
    };

    // ========================================
    // 7. TAB SWITCHING
    // ========================================
    document.querySelectorAll('[data-tab-trigger]').forEach(function (trigger) {
        trigger.addEventListener('click', function () {
            const group = trigger.getAttribute('data-tab-group');
            const target = trigger.getAttribute('data-tab-trigger');

            // Deactivate all triggers in group
            document.querySelectorAll(`[data-tab-group="${group}"][data-tab-trigger]`).forEach(function (t) {
                t.classList.remove('border-primary-500', 'text-primary-600');
                t.classList.add('border-transparent', 'text-secondary-500');
            });

            // Activate this trigger
            trigger.classList.add('border-primary-500', 'text-primary-600');
            trigger.classList.remove('border-transparent', 'text-secondary-500');

            // Hide all panels in group
            document.querySelectorAll(`[data-tab-group="${group}"][data-tab-panel]`).forEach(function (panel) {
                panel.classList.add('hidden');
            });

            // Show target panel
            const panel = document.querySelector(`[data-tab-group="${group}"][data-tab-panel="${target}"]`);
            if (panel) panel.classList.remove('hidden');
        });
    });

    // ========================================
    // 8. EDIT MODAL POPULATION
    // ========================================
    window.populateEditModal = function (modalId, data) {
        const modal = document.getElementById(modalId);
        if (!modal) return;

        Object.keys(data).forEach(function (key) {
            const input = modal.querySelector(`[name="${key}"]`);
            if (input) {
                if (input.type === 'checkbox' || input.type === 'radio') {
                    input.checked = Boolean(data[key]);
                } else {
                    input.value = data[key];
                }
            }
        });

        openModal(modalId);
    };

    // ========================================
    // 9. FORM DEMO SUBMIT (Frontend only)
    // ========================================
    document.querySelectorAll('[data-demo-form]').forEach(function (form) {
        form.addEventListener('submit', function (e) {
            e.preventDefault();
            const modalId = form.closest('[data-modal-backdrop]')?.id;
            if (modalId) closeModal(modalId);
            showToast('Data berhasil disimpan!', 'success');
        });
    });

    // ========================================
    // 10. NOTIFICATION BELL
    // ========================================
    const notifBell = document.getElementById('notif-bell');
    const notifDropdown = document.getElementById('notif-dropdown');
    if (notifBell && notifDropdown) {
        notifBell.addEventListener('click', function (e) {
            e.stopPropagation();
            notifDropdown.classList.toggle('hidden');
        });
    }

    // ========================================
    // 11. PAGINATION (Demo)
    // ========================================
    window.goToPage = function (page) {
        showToast(`Navigasi ke halaman ${page}`, 'info');
    };

    // ========================================
    // 12. EXPORT (Demo)
    // ========================================
    window.exportData = function (format) {
        showToast(`Data berhasil di-export sebagai ${format}`, 'success');
    };

    // ========================================
    // 13. TOOLTIP
    // ========================================
    document.querySelectorAll('[data-tooltip]').forEach(function (el) {
        el.addEventListener('mouseenter', function () {
            const text = el.getAttribute('data-tooltip');
            const tooltip = document.createElement('div');
            tooltip.className = 'absolute z-50 px-2 py-1 text-xs text-white bg-secondary-800 rounded-md shadow-lg whitespace-nowrap animate-fade-in';
            tooltip.textContent = text;
            tooltip.id = 'active-tooltip';
            el.style.position = 'relative';
            el.appendChild(tooltip);
            tooltip.style.bottom = '100%';
            tooltip.style.left = '50%';
            tooltip.style.transform = 'translateX(-50%)';
            tooltip.style.marginBottom = '4px';
        });
        el.addEventListener('mouseleave', function () {
            const tooltip = document.getElementById('active-tooltip');
            if (tooltip) tooltip.remove();
        });
    });

});
