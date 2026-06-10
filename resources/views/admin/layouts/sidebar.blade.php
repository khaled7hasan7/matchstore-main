<!-- Modern Sidebar -->
<nav id="sidebar" class="modern-sidebar">
    <!-- Logo -->
    <div class="sidebar-logo">
        <img src="{{ asset('storage/brands/logo-ready.png') }}" alt="{{ __('cms.sidebar.logo') }}">
    </div>

    <!-- Search -->
    <div class="sidebar-search">
        <input type="text" class="search-input" placeholder="{{ __('cms.sidebar.search_placeholder') }}" id="searchInput" autocomplete="off">
    </div>

    <!-- Menu -->
    <div class="sidebar-menu">
        <!-- Dashboard -->
        <a href="{{ route('admin.dashboard') }}" class="menu-item {{ Route::currentRouteName() == 'admin.dashboard' ? 'active' : '' }}">
            <i class="fas fa-home"></i>
            <span>{{ __('cms.sidebar.dashboard') }}</span>
        </a>

        <!-- Products -->
        <div class="menu-group">
            <a href="#productMenu" class="menu-item" data-bs-toggle="collapse">
                <i class="fas fa-box"></i>
                <span>{{ __('cms.sidebar.products.title') }}</span>
                <i class="fas fa-chevron-down chevron"></i>
            </a>
            <div class="collapse {{ Route::currentRouteName() == 'admin.products.create' || Route::currentRouteName() == 'admin.products.index' ? 'show' : '' }}" id="productMenu">
                <a href="{{ route('admin.products.create') }}" class="submenu-item {{ Route::currentRouteName() == 'admin.products.create' ? 'active' : '' }}">{{ __('cms.sidebar.products.add_new') }}</a>
                <a href="{{ route('admin.products.index') }}" class="submenu-item {{ Route::currentRouteName() == 'admin.products.index' ? 'active' : '' }}">{{ __('cms.sidebar.products.list') }}</a>
            </div>
        </div>

        <!-- Categories -->
        <div class="menu-group">
            <a href="#categoryMenu" class="menu-item" data-bs-toggle="collapse">
                <i class="fas fa-th-large"></i>
                <span>{{ __('cms.sidebar.categories.title') }}</span>
                <i class="fas fa-chevron-down chevron"></i>
            </a>
            <div class="collapse {{ Route::currentRouteName() == 'admin.categories.create' || Route::currentRouteName() == 'admin.categories.index' ? 'show' : '' }}" id="categoryMenu">
                <a href="{{ route('admin.categories.create') }}" class="submenu-item {{ Route::currentRouteName() == 'admin.categories.create' ? 'active' : '' }}">{{ __('cms.sidebar.categories.add_new') }}</a>
                <a href="{{ route('admin.categories.index') }}" class="submenu-item {{ Route::currentRouteName() == 'admin.categories.index' ? 'active' : '' }}">{{ __('cms.sidebar.categories.list') }}</a>
            </div>
        </div>

        <!-- Brands -->
        <div class="menu-group">
            <a href="#brandMenu" class="menu-item" data-bs-toggle="collapse">
                <i class="fas fa-tags"></i>
                <span>{{ __('cms.sidebar.brands.title') }}</span>
                <i class="fas fa-chevron-down chevron"></i>
            </a>
            <div class="collapse {{ Route::currentRouteName() == 'admin.brands.create' || Route::currentRouteName() == 'admin.brands.index' ? 'show' : '' }}" id="brandMenu">
                <a href="{{ route('admin.brands.create') }}" class="submenu-item {{ Route::currentRouteName() == 'admin.brands.create' ? 'active' : '' }}">{{ __('cms.sidebar.brands.add_new') }}</a>
                <a href="{{ route('admin.brands.index') }}" class="submenu-item {{ Route::currentRouteName() == 'admin.brands.index' ? 'active' : '' }}">{{ __('cms.sidebar.brands.list') }}</a>
            </div>
        </div>

        <!-- Attributes -->
        <div class="menu-group">
            <a href="#attributeMenu" class="menu-item" data-bs-toggle="collapse">
                <i class="fas fa-cogs"></i>
                <span>{{ __('cms.sidebar.attributes.title') }}</span>
                <i class="fas fa-chevron-down chevron"></i>
            </a>
            <div class="collapse {{ Route::currentRouteName() == 'admin.attributes.create' || Route::currentRouteName() == 'admin.attributes.index' ? 'show' : '' }}" id="attributeMenu">
                <a href="{{ route('admin.attributes.create') }}" class="submenu-item {{ Route::currentRouteName() == 'admin.attributes.create' ? 'active' : '' }}">{{ __('cms.sidebar.attributes.add_new') }}</a>
                <a href="{{ route('admin.attributes.index') }}" class="submenu-item {{ Route::currentRouteName() == 'admin.attributes.index' ? 'active' : '' }}">{{ __('cms.sidebar.attributes.list') }}</a>
            </div>
        </div>

        <!-- Customers -->
        <div class="menu-group">
            <a href="#customerMenu" class="menu-item" data-bs-toggle="collapse">
                <i class="fas fa-users"></i>
                <span>{{ __('cms.sidebar.customers.title') }}</span>
                <i class="fas fa-chevron-down chevron"></i>
            </a>
            <div class="collapse {{ in_array(Route::currentRouteName(), ['admin.customers.create', 'admin.customers.index']) ? 'show' : '' }}" id="customerMenu">
                <a href="{{ route('admin.customers.index') }}" class="submenu-item {{ Route::currentRouteName() == 'admin.customers.index' ? 'active' : '' }}">{{ __('cms.sidebar.brands.list') }}</a>
            </div>
        </div>

        <!-- Newsletter Subscribers -->
        <a href="{{ route('admin.subscribers.index') }}" class="menu-item {{ Route::currentRouteName() == 'admin.subscribers.index' ? 'active' : '' }}">
            <i class="fas fa-envelope-open-text"></i>
            <span>Newsletter</span>
        </a>

        <!-- Vendors -->
        <div class="menu-group">
            <a href="#vendorMenu" class="menu-item" data-bs-toggle="collapse">
                <i class="fas fa-user-tag"></i>
                <span>{{ __('cms.sidebar.vendors.title') }}</span>
                <i class="fas fa-chevron-down chevron"></i>
            </a>
            <div class="collapse {{ in_array(Route::currentRouteName(), ['admin.vendors.create', 'admin.vendors.index']) ? 'show' : '' }}" id="vendorMenu">
                <a href="{{ route('admin.vendors.create') }}" class="submenu-item {{ Route::currentRouteName() == 'admin.vendors.create' ? 'active' : '' }}">{{ __('cms.sidebar.vendors.add_new') }}</a>
                <a href="{{ route('admin.vendors.index') }}" class="submenu-item {{ Route::currentRouteName() == 'admin.vendors.index' ? 'active' : '' }}">{{ __('cms.sidebar.vendors.list') }}</a>
            </div>
        </div>

        <!-- Orders -->
        <div class="menu-group">
            <a href="#ordersMenu" class="menu-item" data-bs-toggle="collapse">
                <i class="fas fa-shopping-cart"></i>
                <span>{{ __('cms.sidebar.orders.title') }}</span>
                <i class="fas fa-chevron-down chevron"></i>
            </a>
            <div class="collapse {{ Route::currentRouteName() == 'admin.orders.index' ? 'show' : '' }}" id="ordersMenu">
                <a href="{{ route('admin.orders.index') }}" class="submenu-item {{ Route::currentRouteName() == 'admin.orders.index' ? 'active' : '' }}">{{ __('cms.sidebar.orders.all_orders') }}</a>
            </div>
        </div>

        <!-- Coupons -->
        <div class="menu-group">
            <a href="#couponMenu" class="menu-item" data-bs-toggle="collapse">
                <i class="fas fa-ticket-alt"></i>
                <span>{{ __('cms.sidebar.coupons.title') }}</span>
                <i class="fas fa-chevron-down chevron"></i>
            </a>
            <div class="collapse {{ in_array(Route::currentRouteName(), ['admin.coupons.create', 'admin.coupons.index', 'admin.coupons.edit']) ? 'show' : '' }}" id="couponMenu">
                <a href="{{ route('admin.coupons.create') }}" class="submenu-item {{ Route::currentRouteName() == 'admin.coupons.create' ? 'active' : '' }}">{{ __('cms.sidebar.coupons.add_new') }}</a>
                <a href="{{ route('admin.coupons.index') }}" class="submenu-item {{ Route::currentRouteName() == 'admin.coupons.index' ? 'active' : '' }}">{{ __('cms.sidebar.coupons.list') }}</a>
            </div>
        </div>

        <!-- Payments -->
        <div class="menu-group">
            <a href="#paymentsMenu" class="menu-item" data-bs-toggle="collapse">
                <i class="fas fa-credit-card"></i>
                <span>{{ __('cms.sidebar.payments.title') }}</span>
                <i class="fas fa-chevron-down chevron"></i>
            </a>
            <div class="collapse {{ in_array(Route::currentRouteName(), ['admin.payments.index', 'admin.payments.getData']) ? 'show' : '' }}" id="paymentsMenu">
                <a href="{{ route('admin.payments.index') }}" class="submenu-item {{ Route::currentRouteName() == 'admin.payments.index' ? 'active' : '' }}">{{ __('cms.sidebar.payments.list') }}</a>
            </div>
        </div>

        <!-- Refunds -->
        <div class="menu-group">
            <a href="#refundsMenu" class="menu-item" data-bs-toggle="collapse">
                <i class="fas fa-undo"></i>
                <span>{{ __('cms.sidebar.refunds.title') }}</span>
                <i class="fas fa-chevron-down chevron"></i>
            </a>
            <div class="collapse {{ in_array(Route::currentRouteName(), ['admin.refunds.index', 'admin.refunds.getData']) ? 'show' : '' }}" id="refundsMenu">
                <a href="{{ route('admin.refunds.index') }}" class="submenu-item {{ Route::currentRouteName() == 'admin.refunds.index' ? 'active' : '' }}">{{ __('cms.sidebar.refunds.list') }}</a>
            </div>
        </div>

        <!-- Payment Gateways -->
        <div class="menu-group">
            <a href="#gatewaysMenu" class="menu-item" data-bs-toggle="collapse">
                <i class="fas fa-cogs"></i>
                <span>{{ __('cms.sidebar.payment_gateways.title') }}</span>
                <i class="fas fa-chevron-down chevron"></i>
            </a>
            <div class="collapse {{ in_array(Route::currentRouteName(), ['admin.payment-gateways.index', 'admin.payment-gateways.getData', 'admin.payment-gateways.edit']) ? 'show' : '' }}" id="gatewaysMenu">
                <a href="{{ route('admin.payment-gateways.index') }}" class="submenu-item {{ Route::currentRouteName() == 'admin.payment-gateways.index' ? 'active' : '' }}">{{ __('cms.sidebar.payment_gateways.list') }}</a>
            </div>
        </div>

        <!-- Product Reviews -->
        <div class="menu-group">
            <a href="#productReviewMenu" class="menu-item" data-bs-toggle="collapse">
                <i class="fas fa-star"></i>
                <span>{{ __('cms.sidebar.product_reviews.title') }}</span>
                <i class="fas fa-chevron-down chevron"></i>
            </a>
            <div class="collapse {{ in_array(Route::currentRouteName(), ['admin.product_reviews.create', 'admin.product_reviews.index']) ? 'show' : '' }}" id="productReviewMenu">
                <a href="{{ route('admin.reviews.index') }}" class="submenu-item {{ Route::currentRouteName() == 'admin.product_reviews.index' ? 'active' : '' }}">{{ __('cms.sidebar.product_reviews.list') }}</a>
            </div>
        </div>

        <!-- Banners -->
        <div class="menu-group">
            <a href="#bannerMenu" class="menu-item" data-bs-toggle="collapse">
                <i class="fas fa-image"></i>
                <span>{{ __('cms.sidebar.banners.title') }}</span>
                <i class="fas fa-chevron-down chevron"></i>
            </a>
            <div class="collapse {{ Route::currentRouteName() == 'admin.banners.create' || Route::currentRouteName() == 'admin.banners.index' ? 'show' : '' }}" id="bannerMenu">
                <a href="{{ route('admin.banners.create') }}" class="submenu-item {{ Route::currentRouteName() == 'admin.banners.create' ? 'active' : '' }}">{{ __('cms.sidebar.banners.add_new') }}</a>
                <a href="{{ route('admin.banners.index') }}" class="submenu-item {{ Route::currentRouteName() == 'admin.banners.index' ? 'active' : '' }}">{{ __('cms.sidebar.banners.list') }}</a>
            </div>
        </div>

        <!-- Promo Cards -->
        <div class="menu-group">
            <a href="#promoCardMenu" class="menu-item" data-bs-toggle="collapse">
                <i class="fas fa-rectangle-ad"></i>
                <span>{{ __('cms.sidebar.promo_cards.title') }}</span>
                <i class="fas fa-chevron-down chevron"></i>
            </a>
            <div class="collapse {{ in_array(Route::currentRouteName(), ['admin.promo-cards.create', 'admin.promo-cards.index', 'admin.promo-cards.edit']) ? 'show' : '' }}" id="promoCardMenu">
                <a href="{{ route('admin.promo-cards.create') }}" class="submenu-item {{ Route::currentRouteName() == 'admin.promo-cards.create' ? 'active' : '' }}">{{ __('cms.sidebar.promo_cards.add_new') }}</a>
                <a href="{{ route('admin.promo-cards.index') }}" class="submenu-item {{ Route::currentRouteName() == 'admin.promo-cards.index' ? 'active' : '' }}">{{ __('cms.sidebar.promo_cards.list') }}</a>
            </div>
        </div>

        <!-- Menus -->
        <div class="menu-group">
            <a href="#menuMenu" class="menu-item" data-bs-toggle="collapse">
                <i class="fas fa-bars"></i>
                <span>{{ __('cms.sidebar.menu.title') }}</span>
                <i class="fas fa-chevron-down chevron"></i>
            </a>
            <div class="collapse {{ Route::currentRouteName() == 'admin.menus.create' || Route::currentRouteName() == 'admin.menus.index' ? 'show' : '' }}" id="menuMenu">
                <a href="{{ route('admin.menus.create') }}" class="submenu-item {{ Route::currentRouteName() == 'admin.menus.create' ? 'active' : '' }}">{{ __('cms.sidebar.menu.add_new') }}</a>
                <a href="{{ route('admin.menus.index') }}" class="submenu-item {{ Route::currentRouteName() == 'admin.menus.index' ? 'active' : '' }}">{{ __('cms.sidebar.menu.list') }}</a>
            </div>
        </div>

        <!-- Menu Items -->
        <div class="menu-group">
            <a href="#menuItemMenu" class="menu-item" data-bs-toggle="collapse">
                <i class="fas fa-list"></i>
                <span>{{ __('cms.sidebar.menu_items.title') }}</span>
                <i class="fas fa-chevron-down chevron"></i>
            </a>
            <div class="collapse {{ Route::currentRouteName() == 'admin.menuitems.create' || Route::currentRouteName() == 'admin.menuitems.index' ? 'show' : '' }}" id="menuItemMenu">
                @if(isset($menu) && $menu)
                <a href="{{ route('admin.menus.items.create', $menu) }}" class="submenu-item {{ Route::currentRouteName() == 'admin.menu.items.create' ? 'active' : '' }}">{{ __('cms.sidebar.menu_items.add_new') }}</a>
                <a href="{{ route('admin.menus.item.index') }}" class="submenu-item {{ Route::currentRouteName() == 'admin.menus.item.index' ? 'active' : '' }}">{{ __('cms.sidebar.menu_items.list') }}</a>
                @endif
            </div>
        </div>

        <!-- Social Media Links -->
        <div class="menu-group">
            <a href="#socialMediaLinkMenu" class="menu-item" data-bs-toggle="collapse">
                <i class="fas fa-link"></i>
                <span>{{ __('cms.sidebar.social_media_links.title') }}</span>
                <i class="fas fa-chevron-down chevron"></i>
            </a>
            <div class="collapse {{ Route::currentRouteName() == 'admin.social-media-links.create' || Route::currentRouteName() == 'admin.social-media-links.index' ? 'show' : '' }}" id="socialMediaLinkMenu">
                <a href="{{ route('admin.social-media-links.create') }}" class="submenu-item {{ Route::currentRouteName() == 'admin.social-media-links.create' ? 'active' : '' }}">{{ __('cms.sidebar.social_media_links.add_new') }}</a>
                <a href="{{ route('admin.social-media-links.index') }}" class="submenu-item {{ Route::currentRouteName() == 'admin.social-media-links.index' ? 'active' : '' }}">{{ __('cms.sidebar.social_media_links.list') }}</a>
            </div>
        </div>

        <!-- Pages -->
        <div class="menu-group">
            <a href="#pageMenu" class="menu-item" data-bs-toggle="collapse">
                <i class="fas fa-file-alt"></i>
                <span>{{ __('cms.sidebar.pages.title') }}</span>
                <i class="fas fa-chevron-down chevron"></i>
            </a>
            <div class="collapse {{ Route::currentRouteName() == 'admin.pages.create' || Route::currentRouteName() == 'admin.pages.index' ? 'show' : '' }}" id="pageMenu">
                <a href="{{ route('admin.pages.create') }}" class="submenu-item {{ Route::currentRouteName() == 'admin.pages.create' ? 'active' : '' }}">{{ __('cms.sidebar.pages.add_new') }}</a>
                <a href="{{ route('admin.pages.index') }}" class="submenu-item {{ Route::currentRouteName() == 'admin.pages.index' ? 'active' : '' }}">{{ __('cms.sidebar.pages.list') }}</a>
            </div>
        </div>

        <!-- Site Settings -->
        <div class="menu-group">
            <a href="#siteSettingsMenu" class="menu-item" data-bs-toggle="collapse">
                <i class="fas fa-cog"></i>
                <span>{{ __('cms.sidebar.site_settings.title') }}</span>
                <i class="fas fa-chevron-down chevron"></i>
            </a>
            <div class="collapse {{ Route::currentRouteName() == 'admin.site-settings.index' ? 'show' : '' }}" id="siteSettingsMenu">
                <a href="{{ route('admin.site-settings.index') }}" class="submenu-item {{ Route::currentRouteName() == 'admin.site-settings.index' ? 'active' : '' }}">{{ __('cms.sidebar.site_settings.manage') }}</a>
            </div>
        </div>
    </div>
</nav>

<style>
/* Modern Sidebar Styling */
.modern-sidebar {
    width: 250px;
    height: 100vh;
    background: #2d3748;
    position: fixed;
    top: 0;
    left: 0;
    overflow-y: auto;
    overflow-x: hidden;
    z-index: 1000;
    padding: 0;
}

[dir="rtl"] .modern-sidebar {
    left: auto;
    right: 0;
}

/* Logo */
.sidebar-logo {
    padding: 1.5rem 1rem;
    text-align: center;
    border-bottom: 1px solid #4a5568;
}

.sidebar-logo img {
    max-width: 150px;
    height: auto;
}

/* Search */
.sidebar-search {
    padding: 1rem;
}

.search-input {
    width: 100%;
    padding: 0.5rem 0.75rem;
    background: #1a202c;
    border: 1px solid #4a5568;
    border-radius: 0.375rem;
    color: #cbd5e0;
    font-size: 0.875rem;
}

.search-input::placeholder {
    color: #718096;
}

.search-input:focus {
    outline: none;
    border-color: #4299e1;
}

/* Menu */
.sidebar-menu {
    padding: 0.5rem 0;
}

.menu-item {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 0.75rem 1rem;
    color: #cbd5e0;
    text-decoration: none;
    transition: all 0.2s;
    cursor: pointer;
    position: relative;
}

.menu-item i {
    width: 20px;
    font-size: 1rem;
}

.menu-item .chevron {
    margin-left: auto;
    font-size: 0.75rem;
    transition: transform 0.2s;
}

[dir="rtl"] .menu-item .chevron {
    margin-left: 0;
    margin-right: auto;
}

.menu-item:hover {
    background: #374151;
    color: #fff;
}

.menu-item.active {
    background: #4299e1;
    color: #fff;
}

.menu-item[aria-expanded="true"] .chevron {
    transform: rotate(180deg);
}

/* Submenu */
.submenu-item {
    display: block;
    padding: 0.625rem 1rem 0.625rem 3rem;
    color: #a0aec0;
    text-decoration: none;
    font-size: 0.875rem;
    transition: all 0.2s;
}

[dir="rtl"] .submenu-item {
    padding: 0.625rem 3rem 0.625rem 1rem;
}

.submenu-item:hover {
    background: #374151;
    color: #fff;
}

.submenu-item.active {
    background: #2c5282;
    color: #fff;
    border-left: 3px solid #4299e1;
}

[dir="rtl"] .submenu-item.active {
    border-left: none;
    border-right: 3px solid #4299e1;
}

/* Menu Group */
.menu-group {
    margin-bottom: 0.25rem;
}

/* Scrollbar */
.modern-sidebar::-webkit-scrollbar {
    width: 6px;
}

.modern-sidebar::-webkit-scrollbar-track {
    background: #1a202c;
}

.modern-sidebar::-webkit-scrollbar-thumb {
    background: #4a5568;
    border-radius: 3px;
}

.modern-sidebar::-webkit-scrollbar-thumb:hover {
    background: #718096;
}

/* Search Functionality */
.menu-group:not([style*="display: block"]) {
    display: block;
}

/* Collapsed Sidebar (default state) */
.modern-sidebar.collapsed {
    width: 70px;
    transition: width 0.3s ease;
}

.modern-sidebar.collapsed .sidebar-logo {
    opacity: 0;
    height: 0;
    padding: 0;
    overflow: hidden;
    transition: all 0.3s ease;
}

.modern-sidebar.collapsed .sidebar-search {
    display: none;
}

.modern-sidebar.collapsed .menu-item span {
    display: none;
}

.modern-sidebar.collapsed .menu-item .chevron {
    display: none;
}

.modern-sidebar.collapsed .menu-item {
    justify-content: center;
    padding: 0.75rem;
}

.modern-sidebar.collapsed .menu-item i:first-child {
    margin: 0;
    width: auto;
}

.modern-sidebar.collapsed .submenu-item {
    display: none;
}

.modern-sidebar.collapsed .menu-group > .collapse {
    display: none !important;
}

/* Expanded Sidebar (on hover) */
.modern-sidebar:hover,
.modern-sidebar.expanded {
    width: 250px;
}

.modern-sidebar:hover .sidebar-logo,
.modern-sidebar.expanded .sidebar-logo {
    opacity: 1;
    height: auto;
    padding: 1rem;
}

.modern-sidebar:hover .sidebar-search,
.modern-sidebar.expanded .sidebar-search {
    display: block;
}

.modern-sidebar:hover .menu-item span,
.modern-sidebar.expanded .menu-item span {
    display: inline;
}

.modern-sidebar:hover .menu-item .chevron,
.modern-sidebar.expanded .menu-item .chevron {
    display: inline;
}

.modern-sidebar:hover .menu-item,
.modern-sidebar.expanded .menu-item {
    justify-content: flex-start;
    padding: 0.75rem 1rem;
}

.modern-sidebar:hover .menu-item i:first-child,
.modern-sidebar.expanded .menu-item i:first-child {
    margin: 0;
    margin-right: 0.75rem;
    width: 1.25rem;
}

.modern-sidebar:hover .submenu-item,
.modern-sidebar.expanded .submenu-item {
    display: block;
}

.modern-sidebar:hover .menu-group > .collapse.show,
.modern-sidebar.expanded .menu-group > .collapse.show {
    display: block !important;
}

/* Add transition to sidebar */
.modern-sidebar {
    transition: width 0.3s ease;
}
</style>

<script>
// Search functionality
document.addEventListener("DOMContentLoaded", function () {
    const searchInput = document.getElementById("searchInput");
    const menuGroups = document.querySelectorAll(".menu-group");
    const menuItems = document.querySelectorAll(".menu-item");

    searchInput.addEventListener("input", function () {
        const searchTerm = searchInput.value.toLowerCase();

        menuGroups.forEach((group) => {
            const text = group.textContent.toLowerCase();
            if (text.includes(searchTerm)) {
                group.style.display = "block";
            } else {
                group.style.display = "none";
            }
        });

        menuItems.forEach((item) => {
            if (!item.closest(".menu-group")) {
                const text = item.textContent.toLowerCase();
                if (text.includes(searchTerm)) {
                    item.style.display = "flex";
                } else {
                    item.style.display = "none";
                }
            }
        });
    });
});
</script>
