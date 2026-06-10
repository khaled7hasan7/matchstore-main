{{-- Notification Bar --}}
@if(!session('notification_dismissed'))
    @php
        $notification = \App\Models\Banner::where('type', 'notification')
            ->where('status', 1)
            ->with('translation')
            ->first();
    @endphp

    @if($notification && $notification->translation)
        <div class="notification-bar" id="notificationBar">
            <div class="container-fluid">
                <div class="notification-content">
                    <span class="notification-text">{{ $notification->translation->title }}</span>
                    <button type="button" class="close-btn" onclick="dismissNotification()" aria-label="Close">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
        </div>

        <style>
            .notification-bar {
                background: linear-gradient(135deg, var(--accent-color) 0%, #ff9800 100%);
                color: var(--dark-color);
                padding: 0.75rem 0;
                position: relative;
                z-index: 1030;
                box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            }

            .notification-content {
                display: flex;
                justify-content: center;
                align-items: center;
                position: relative;
            }

            .notification-text {
                font-weight: 500;
                font-size: 0.9rem;
                text-align: center;
            }

            .notification-bar .close-btn {
                position: absolute;
                right: 1rem;
                background: transparent;
                border: none;
                color: var(--dark-color);
                cursor: pointer;
                padding: 0.25rem 0.5rem;
                font-size: 1rem;
                transition: opacity 0.3s ease;
            }

            .notification-bar .close-btn:hover {
                opacity: 0.7;
            }

            @media (max-width: 768px) {
                .notification-text {
                    font-size: 0.85rem;
                    padding-right: 2rem;
                }
            }
        </style>

        <script>
            function dismissNotification() {
                const notificationBar = document.getElementById('notificationBar');
                if (notificationBar) {
                    notificationBar.style.transition = 'opacity 0.3s ease';
                    notificationBar.style.opacity = '0';
                    setTimeout(() => {
                        notificationBar.remove();
                    }, 300);

                    // Store dismissal in session
                    fetch('{{ route("notification.dismiss") }}', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json'
                        }
                    });
                }
            }
        </script>
    @endif
@endif
