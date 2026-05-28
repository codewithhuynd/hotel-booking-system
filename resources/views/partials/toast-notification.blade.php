{{-- Toast Notification Partial --}}
<div id="toast-container" style="
    position: fixed;
    top: 20px;
    right: 20px;
    z-index: 9999;
    display: flex;
    flex-direction: column;
    gap: 12px;
    pointer-events: none;
"></div>

<script>
    // Toast Notification System
    class ToastNotification {
        constructor() {
            this.container = document.getElementById('toast-container');
            this.toasts = new Map();
        }

        show(message, type = 'info', duration = 2000) {
            const id = Date.now() + Math.random();
            const toast = this.createToastElement(message, type, id);
            
            this.container.appendChild(toast);
            this.toasts.set(id, { element: toast, timeout: null });

            // Trigger animation
            setTimeout(() => toast.classList.add('show'), 10);

            // Auto remove
            const timeout = setTimeout(() => this.remove(id), duration);
            this.toasts.get(id).timeout = timeout;

            return id;
        }

        createToastElement(message, type, id) {
            const toast = document.createElement('div');
            toast.className = 'toast';
            toast.id = `toast-${id}`;

            // Determine colors based on type
            let bgColor, borderColor, textColor, icon;
            
            switch(type) {
                case 'success':
                    bgColor = '#ecfdf3';
                    borderColor = '#bbf7d0';
                    textColor = '#065f46';
                    icon = 'fa-circle-check';
                    break;
                case 'error':
                    bgColor = '#fef2f2';
                    borderColor = '#fecaca';
                    textColor = '#7f1d1d';
                    icon = 'fa-triangle-exclamation';
                    break;
                case 'warning':
                    bgColor = '#fef3c7';
                    borderColor = '#fde047';
                    textColor = '#78350f';
                    icon = 'fa-exclamation-circle';
                    break;
                case 'info':
                default:
                    bgColor = '#eff6ff';
                    borderColor = '#bfdbfe';
                    textColor = '#1e40af';
                    icon = 'fa-info-circle';
                    break;
            }

            toast.style.cssText = `
                background-color: ${bgColor};
                border: 1px solid ${borderColor};
                color: ${textColor};
                padding: 14px 16px;
                border-radius: 12px;
                display: flex;
                align-items: center;
                gap: 10px;
                font-weight: 600;
                font-size: 14px;
                max-width: 350px;
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
                opacity: 0;
                transform: translateX(400px);
                transition: opacity 0.3s ease, transform 0.3s ease;
                pointer-events: auto;
                animation: slideInRight 0.3s ease forwards;
            `;

            toast.innerHTML = `
                <i class="fa-solid ${icon}" style="flex-shrink: 0;"></i>
                <span style="flex: 1; word-break: break-word;">${this.escapeHtml(message)}</span>
                <button onclick="window.toastManager.remove(${id})" style="
                    background: none;
                    border: none;
                    color: inherit;
                    cursor: pointer;
                    padding: 0;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    opacity: 0.5;
                    hover-opacity: 1;
                    transition: opacity 0.2s;
                " onmouseover="this.style.opacity = '0.8'" onmouseout="this.style.opacity = '0.5'">
                    <i class="fa-solid fa-times" style="font-size: 12px;"></i>
                </button>
            `;

            return toast;
        }

        remove(id) {
            const data = this.toasts.get(id);
            if (!data) return;

            const { element, timeout } = data;
            
            if (timeout) clearTimeout(timeout);

            element.style.animation = 'slideOutRight 0.3s ease forwards';
            
            setTimeout(() => {
                element.remove();
                this.toasts.delete(id);
            }, 300);
        }

        escapeHtml(text) {
            const div = document.createElement('div');
            div.textContent = text;
            return div.innerHTML;
        }

        success(message, duration = 2000) {
            return this.show(message, 'success', duration);
        }

        error(message, duration = 2000) {
            return this.show(message, 'error', duration);
        }

        warning(message, duration = 2000) {
            return this.show(message, 'warning', duration);
        }

        info(message, duration = 2000) {
            return this.show(message, 'info', duration);
        }
    }

    // Initialize and expose to window
    window.toastManager = new ToastNotification();

    // Listen for Laravel session messages
    document.addEventListener('DOMContentLoaded', function() {
        @if(session('success'))
            window.toastManager.success("{{ session('success') }}", 2000);
        @endif

        @if(session('error'))
            window.toastManager.error("{{ session('error') }}", 3000);
        @endif

        @if(session('warning'))
            window.toastManager.warning("{{ session('warning') }}", 2000);
        @endif

        @if(session('status') === 'verification-link-sent')
            window.toastManager.info('Liên kết xác thực đã được gửi đến email của bạn.', 2000);
        @endif

        @if($errors->any())
            const errorMessages = @json($errors->all());
            errorMessages.forEach((error, index) => {
                // Stagger errors so they don't all appear at once
                setTimeout(() => {
                    window.toastManager.error(error, 3000);
                }, index * 200);
            });
        @endif
    });
</script>

<style>
    @keyframes slideInRight {
        from {
            opacity: 0;
            transform: translateX(400px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    @keyframes slideOutRight {
        from {
            opacity: 1;
            transform: translateX(0);
        }
        to {
            opacity: 0;
            transform: translateX(400px);
        }
    }

    .toast.show {
        opacity: 1;
        transform: translateX(0);
    }

    /* Responsive design for mobile */
    @media (max-width: 640px) {
        #toast-container {
            left: 12px;
            right: 12px;
            top: 12px;
        }

        .toast {
            max-width: 100% !important;
        }
    }
</style>
