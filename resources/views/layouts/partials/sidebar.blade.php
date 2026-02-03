<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <div class="brand-container">
        <a href="{{route('home')}}" class="brand-link">
            <div class="brand-logo-wrapper">
                <img src="{{ asset('images/logo.png') }}" alt="{{ config('app.name') }}"
                    class="brand-image img-circle elevation-3">
                <div class="logo-pulse"></div>
            </div>
            <div class="brand-text-wrapper">
                <span class="brand-text font-weight-bold">{{ config('app.name') }}</span>
            </div>
        </a>
    </div>

    <!-- Search Bar -->
    <div class="sidebar-search px-3 mb-3">
        <div class="input-group">
            <input type="text" class="form-control sidebar-search-input" placeholder="{{ __('Search menu...') }}">
            <div class="input-group-append">
                <button class="btn btn-sidebar-search">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Sidebar -->
    <div>
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

                <!-- Dashboard -->
                <li class="nav-item">
                    <a href="{{route('home')}}" class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}">
                        <div class="nav-icon-wrapper">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <div class="nav-icon-badge"></div>
                        </div>
                        <p>{{ __('dashboard.title') }}</p>
                        <span class="nav-badge" title="Quick Stats">●</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('products.index') }}" class="nav-link {{ activeSegment('products') }}">
                        <i class="nav-icon fas fa-th-large"></i>
                        <p>{{ __('product.title') }}</p>
                    </a>
                </li>

                <!-- Sales Section -->
                <li class="nav-header">
                    <span class="nav-header-icon"><i class="fas fa-chart-line"></i></span>
                    {{ __('Sales') }}
                    <div class="nav-header-line"></div>
                </li>

                <!-- POS Cart -->
                <li class="nav-item">
                    <a href="{{ route('cart.index') }}" class="nav-link {{ activeSegment('cart') }}">
                        <div class="nav-icon-wrapper">
                            <i class="nav-icon fas fa-cash-register"></i>
                        </div>
                        <p>{{ __('POS') }}</p>
                    </a>
                </li>

                <!-- Orders -->
                <li class="nav-item">
                    <a href="{{ route('orders.index') }}" class="nav-link {{ activeSegment('orders') }}">
                        <div class="nav-icon-wrapper">
                            <i class="nav-icon fas fa-shopping-bag"></i>
                        </div>
                        <p>{{ __('order.Orders_List') }}</p>
                    </a>
                </li>

                <!-- Customers -->
                <li class="nav-item">
                    <a href="{{ route('customers.index') }}" class="nav-link {{ activeSegment('customers') }}">
                        <div class="nav-icon-wrapper">
                            <i class="nav-icon fas fa-user-friends"></i>
                        </div>
                        <p>{{ __('customer.title') }}</p>
                    </a>
                </li>

                <!-- Purchases Section -->
                <li class="nav-header">
                    <span class="nav-header-icon"><i class="fas fa-truck-loading"></i></span>
                    {{ __('Purchases') }}
                    <div class="nav-header-line"></div>
                </li>

                <!-- Purchases (Dropdown) -->
                <li class="nav-item {{ request()->routeIs('purchases.*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ activeSegment('purchases') }}">
                        <div class="nav-icon-wrapper">
                            <i class="nav-icon fas fa-box-open"></i>
                        </div>
                        <p>
                            {{ __('Purchases') }}
                            <i class="nav-arrow right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('purchases.create') }}"
                                class="nav-link {{ request()->routeIs('purchases.create') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-plus-circle"></i>
                                <p>{{ __('New Purchase') }}</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('purchases.index') }}"
                                class="nav-link {{ request()->routeIs('purchases.index') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-list-alt"></i>
                                <p>{{ __('All Purchases') }}</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Suppliers -->
                <li class="nav-item">
                    <a href="{{ route('suppliers.index') }}" class="nav-link {{ activeSegment('suppliers') }}">
                        <div class="nav-icon-wrapper">
                            <i class="nav-icon fas fa-truck"></i>
                        </div>
                        <p>{{ __('Supplier') }}</p>
                    </a>
                </li>

                <!-- Extra Section -->
                <li class="nav-header">
                    <span class="nav-header-icon"><i class="fas fa-cog"></i></span>
                    {{ __('System') }}
                    <div class="nav-header-line"></div>
                </li>

                <!-- Settings -->
                <li class="nav-item">
                    <a href="{{ route('settings.index') }}" class="nav-link {{ activeSegment('settings') }}">
                        <div class="nav-icon-wrapper">
                            <i class="nav-icon fas fa-sliders-h"></i>
                        </div>
                        <p>{{ __('settings.title') }}</p>
                    </a>
                </li>

                <!-- Logout -->
                <li class="nav-item logout-item">
                    <a href="#" class="nav-link logout-link"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <div class="nav-icon-wrapper">
                            <i class="nav-icon fas fa-sign-out-alt"></i>
                            <div class="logout-pulse"></div>
                        </div>
                        <p>{{ __('common.Logout') }}</p>
                        <span class="nav-badge-logout">{{ Auth::user()->name }}</span>
                    </a>
                    <form action="{{route('logout')}}" method="POST" id="logout-form" class="d-none">
                        @csrf
                    </form>
                </li>

                <!-- Sidebar Toggle (Mobile) -->
                <li class="nav-item sidebar-toggle d-md-none">
                    <a href="#" class="nav-link" data-widget="pushmenu">
                        <i class="fas fa-times"></i>
                        <p>{{ __('Close Menu') }}</p>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>

<style>
    .main-sidebar {
        max-height: 100vh !important;
        overflow: auto !important;
        position: fixed;
        top: 0;
        left: 0;
    }

    .brand-container {
        padding: 15px;
        background: linear-gradient(135deg, #343a40 0%, #212529 100%);
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }

    .brand-link {
        display: flex;
        align-items: center;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .brand-link:hover {
        transform: translateX(5px);
    }

    .brand-logo-wrapper {
        position: relative;
        width: 45px;
        height: 45px;
        margin-right: 12px;
    }

    .brand-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border: 2px solid rgba(255, 255, 255, 0.2);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
    }

    .logo-pulse {
        position: absolute;
        top: -2px;
        left: -2px;
        right: -2px;
        bottom: -2px;
        border-radius: 50%;
        border: 2px solid #007bff;
        animation: pulse 2s infinite;
        opacity: 0.5;
    }

    .brand-text-wrapper {
        display: flex;
        flex-direction: column;
    }

    .brand-text {
        font-size: 1.2rem;
        font-weight: 700;
        color: #fff;
        letter-spacing: 0.5px;
    }

    .brand-subtext {
        font-size: 0.7rem;
        color: rgba(255, 255, 255, 0.6);
        margin-top: 2px;
    }

    /* User Panel Styles */
    .user-panel {
        padding: 15px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }

    .user-panel .image {
        position: relative;
        width: 40px;
        height: 40px;
        margin-right: 10px;
    }

    .user-avatar {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border: 2px solid rgba(255, 255, 255, 0.2);
    }

    .status-indicator {
        position: absolute;
        bottom: 2px;
        right: 2px;
        width: 10px;
        height: 10px;
        border-radius: 50%;
        border: 2px solid #343a40;
    }

    .status-indicator.online {
        background: #28a745;
        animation: statusPulse 2s infinite;
    }

    .user-name {
        color: #fff;
        font-weight: 600;
        font-size: 0.95rem;
        margin-bottom: 2px;
    }

    .user-role {
        font-size: 0.75rem;
        background: rgba(255, 255, 255, 0.1);
        padding: 2px 8px;
        border-radius: 10px;
        display: inline-block;
    }

    /* Search Bar Styles */
    .sidebar-search {
        position: relative;
    }

    .sidebar-search-input {
        background: rgba(255, 255, 255, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
        color: #fff;
        border-radius: 20px;
        padding-left: 40px;
    }

    .sidebar-search-input:focus {
        background: rgba(255, 255, 255, 0.15);
        border-color: #007bff;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    }

    .sidebar-search-input::placeholder {
        color: rgba(255, 255, 255, 0.5);
    }

    .btn-sidebar-search {
        background: transparent;
        border: none;
        color: rgba(255, 255, 255, 0.5);
        position: absolute;
        left: 15px;
        top: 50%;
        transform: translateY(-50%);
        z-index: 2;
    }

    /* Navigation Styles */
    .nav-header {
        padding: 15px 25px 5px;
        font-size: 0.75rem;
        color: rgba(255, 255, 255, 0.5);
        text-transform: uppercase;
        letter-spacing: 1px;
        display: flex;
        align-items: center;
        margin-top: 10px;
    }

    .nav-header-icon {
        margin-right: 8px;
        color: #007bff;
    }

    .nav-header-line {
        flex: 1;
        height: 1px;
        background: rgba(255, 255, 255, 0.1);
        margin-left: 10px;
    }

    .nav-item {
        margin: 2px 10px;
    }

    .nav-link {
        border-radius: 8px;
        margin-bottom: 3px;
        padding: 12px 15px;
        display: flex;
        align-items: center;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .nav-link:hover {
        background: rgba(255, 255, 255, 0.1);
        transform: translateX(5px);
    }

    .nav-link.active {
        background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
        box-shadow: 0 4px 15px rgba(0, 123, 255, 0.3);
    }

    .nav-icon-wrapper {
        position: relative;
        width: 30px;
        margin-right: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .nav-icon {
        font-size: 1.1rem;
        color: rgba(255, 255, 255, 0.7);
    }

    .nav-link.active .nav-icon {
        color: #fff;
    }

    .nav-icon-badge {
        position: absolute;
        top: -5px;
        right: -5px;
        min-width: 18px;
        height: 18px;
        border-radius: 9px;
        font-size: 0.6rem;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0 4px;
    }

    .nav-icon-badge.badge-danger {
        background: #dc3545;
        color: white;
        animation: badgePulse 1.5s infinite;
    }

    .nav-icon-badge.badge-warning {
        background: #ffc107;
        color: #212529;
        animation: badgePulse 2s infinite;
    }

    .nav-link p {
        flex: 1;
        margin: 0;
        font-size: 0.9rem;
        font-weight: 500;
        color: rgba(255, 255, 255, 0.8);
    }

    .nav-link.active p {
        color: #fff;
        font-weight: 600;
    }

    .nav-badge {
        font-size: 0.7rem;
        padding: 2px 8px;
        border-radius: 10px;
        background: rgba(255, 255, 255, 0.1);
        color: rgba(255, 255, 255, 0.6);
        margin-left: 5px;
    }

    .nav-badge-new {
        font-size: 0.65rem;
        padding: 2px 6px;
        border-radius: 10px;
        background: #28a745;
        color: white;
        margin-left: 5px;
        animation: badgePulse 3s infinite;
    }

    .nav-arrow {
        color: rgba(255, 255, 255, 0.3);
        font-size: 0.8rem;
    }

    .nav-treeview {
        padding-left: 30px;
    }

    .nav-treeview .nav-link {
        padding: 8px 15px;
        margin-bottom: 2px;
    }

    .nav-treeview .nav-icon {
        font-size: 0.9rem;
    }

    /* Logout Item */
    .logout-item {
        margin-top: 20px;
        border-top: 1px solid rgba(255, 255, 255, 0.1);
        padding-top: 10px;
    }

    .logout-link {
        background: rgba(220, 53, 69, 0.1);
        border: 1px solid rgba(220, 53, 69, 0.2);
    }

    .logout-link:hover {
        background: rgba(220, 53, 69, 0.2);
        transform: translateX(5px);
    }

    .logout-pulse {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        border-radius: 8px;
        border: 2px solid #dc3545;
        animation: pulse 3s infinite;
        opacity: 0;
    }

    .nav-badge-logout {
        font-size: 0.7rem;
        color: rgba(255, 255, 255, 0.5);
        font-style: italic;
    }

    /* Sidebar Footer */
    .sidebar-footer {
        padding: 15px;
        border-top: 1px solid rgba(255, 255, 255, 0.1);
        background: rgba(0, 0, 0, 0.2);
    }

    .system-status {
        display: flex;
        justify-content: space-between;
        margin-bottom: 5px;
    }

    .status-item {
        display: flex;
        align-items: center;
    }

    .status-dot {
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: #28a745;
        margin-right: 5px;
        animation: statusPulse 2s infinite;
    }

    .status-dot.online {
        background: #28a745;
    }

    .version-info {
        text-align: center;
        color: rgba(255, 255, 255, 0.4);
        font-size: 0.7rem;
    }

    /* Divider */
    .nav-divider {
        height: 1px;
        background: rgba(255, 255, 255, 0.1);
        margin: 15px 0;
    }

    /* Animations */
    @keyframes pulse {
        0% {
            transform: scale(0.95);
            opacity: 0.5;
        }

        70% {
            transform: scale(1.05);
            opacity: 0.3;
        }

        100% {
            transform: scale(0.95);
            opacity: 0.5;
        }
    }

    @keyframes badgePulse {

        0%,
        100% {
            transform: scale(1);
        }

        50% {
            transform: scale(1.1);
        }
    }

    @keyframes statusPulse {
        0% {
            box-shadow: 0 0 0 0 rgba(40, 167, 69, 0.7);
        }

        70% {
            box-shadow: 0 0 0 5px rgba(40, 167, 69, 0);
        }

        100% {
            box-shadow: 0 0 0 0 rgba(40, 167, 69, 0);
        }
    }

    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateX(-20px);
        }

        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    /* Menu Search Highlight */
    .search-highlight {
        background: rgba(255, 193, 7, 0.2);
        border-radius: 3px;
        padding: 0 2px;
    }

    /* Responsive */
    @media (max-width: 767.98px) {
        .sidebar-footer {
            display: none;
        }

        .brand-text {
            font-size: 1rem;
        }

        .nav-link {
            padding: 10px 12px;
        }
    }

    /* Dark Mode Adjustments */
    .sidebar-dark-primary .nav-link.active {
        background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
    }

    /* Hover Effects */
    .nav-link::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        height: 100%;
        width: 3px;
        background: #007bff;
        transform: scaleY(0);
        transition: transform 0.3s ease;
    }

    .nav-link:hover::before {
        transform: scaleY(1);
    }

    .nav-link.active::before {
        transform: scaleY(1);
        background: #fff;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Search functionality
        const searchInput = document.querySelector('.sidebar-search-input');
        const navItems = document.querySelectorAll('.nav-item:not(.nav-header):not(.sidebar-toggle):not(.logout-item)');
        const navHeaders = document.querySelectorAll('.nav-header');

        if (searchInput) {
            searchInput.addEventListener('input', function () {
                const searchTerm = this.value.toLowerCase().trim();

                if (searchTerm === '') {
                    // Show all items
                    navItems.forEach(item => item.style.display = '');
                    navHeaders.forEach(header => header.style.display = '');
                    return;
                }

                let hasVisibleItems = false;
                let lastVisibleHeader = null;

                navItems.forEach(item => {
                    const link = item.querySelector('.nav-link p');
                    const text = link ? link.textContent.toLowerCase() : '';

                    if (text.includes(searchTerm)) {
                        item.style.display = '';
                        hasVisibleItems = true;

                        // Highlight matching text
                        if (link) {
                            const originalText = link.textContent;
                            const regex = new RegExp(`(${searchTerm})`, 'gi');
                            link.innerHTML = originalText.replace(regex, '<span class="search-highlight">$1</span>');
                        }
                    } else {
                        item.style.display = 'none';
                    }
                });

                // Hide headers if no items under them are visible
                navHeaders.forEach(header => {
                    const nextItems = [];
                    let nextElement = header.nextElementSibling;

                    while (nextElement && !nextElement.classList.contains('nav-header')) {
                        if (nextElement.classList.contains('nav-item')) {
                            nextItems.push(nextElement);
                        }
                        nextElement = nextElement.nextElementSibling;
                    }

                    const hasVisibleChildren = nextItems.some(item => item.style.display !== 'none');
                    header.style.display = hasVisibleChildren ? '' : 'none';
                });

                // Add animation
                document.querySelectorAll('.nav-item[style=""]').forEach((item, index) => {
                    item.style.animation = `slideIn 0.3s ease ${index * 0.05}s both`;
                });
            });
        }

        // Add click animation to nav items
        document.querySelectorAll('.nav-link').forEach(link => {
            link.addEventListener('click', function (e) {
                if (this.getAttribute('href') !== '#') {
                    // Add ripple effect
                    const ripple = document.createElement('span');
                    const rect = this.getBoundingClientRect();
                    const size = Math.max(rect.width, rect.height);
                    const x = e.clientX - rect.left - size / 2;
                    const y = e.clientY - rect.top - size / 2;

                    ripple.style.cssText = `
                    position: absolute;
                    border-radius: 50%;
                    background: rgba(255,255,255,0.3);
                    transform: scale(0);
                    animation: ripple 0.6s linear;
                    width: ${size}px;
                    height: ${size}px;
                    top: ${y}px;
                    left: ${x}px;
                    pointer-events: none;
                `;

                    this.appendChild(ripple);

                    setTimeout(() => {
                        ripple.remove();
                    }, 600);
                }
            });
        });

        // Auto-expand active parent menu
        document.querySelectorAll('.nav-item.menu-open').forEach(item => {
            const link = item.querySelector('.nav-link');
            if (link) {
                link.click(); // Trigger click to expand
            }
        });

        // Add CSS for ripple effect
        const style = document.createElement('style');
        style.textContent = `
        @keyframes ripple {
            to {
                transform: scale(4);
                opacity: 0;
            }
        }
    `;
        document.head.appendChild(style);
    });
</script>