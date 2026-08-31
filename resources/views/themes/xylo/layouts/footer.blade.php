@php
    use App\Models\Page;
    use App\Models\SocialMediaLink;

    // Get active pages for footer (cached per language)
    $footerPages = Cache::remember('footer_pages_' . app()->getLocale(), 3600, function() {
        return Page::where('status', true)->get();
    });

    // Get social media links
    $socialLinks = Cache::remember('social_media_links', 3600, function() {
        return SocialMediaLink::all();
    });
@endphp

<footer class="modern-footer">
    {{-- Newsletter Section --}}
    <div class="footer-newsletter">
        <div class="container-fluid">
            <div class="row align-items-center py-4">
                <div class="col-lg-6 mb-3 mb-lg-0">
                    <div class="newsletter-content">
                        <h4 class="newsletter-title">
                            <i class="fas fa-envelope-open-text me-2"></i>
                            {{ __('store.footer.subscribe_newsletter') }}
                        </h4>
                        <p class="newsletter-text mb-0">
                            {{ __('store.footer.newsletter_description') }}
                        </p>
                    </div>
                </div>
                <div class="col-lg-6">
                    <form class="newsletter-form" id="footerNewsletterForm">
                        @csrf
                        <div class="input-group {{ app()->getLocale() == 'ar' ? 'rtl-newsletter' : '' }}">
                            @if(app()->getLocale() == 'ar')
                                <button type="submit" class="btn btn-newsletter">
                                    <i class="fas fa-paper-plane me-2"></i>
                                    {{ __('store.footer.subscribe') }}
                                </button>
                                <input type="email"
                                       class="form-control"
                                       name="email"
                                       placeholder="{{ __('store.footer.enter_email') }}"
                                       required>
                            @else
                                <input type="email"
                                       class="form-control"
                                       name="email"
                                       placeholder="{{ __('store.footer.enter_email') }}"
                                       required>
                                <button type="submit" class="btn btn-newsletter">
                                    <i class="fas fa-paper-plane me-2"></i>
                                    {{ __('store.footer.subscribe') }}
                                </button>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Main Footer Content --}}
    <div class="footer-main">
        <div class="container-fluid">
            <div class="row g-4 py-5">
                {{-- Column 1: Logo & About --}}
                <div class="col-lg-4 col-md-6">
                    <div class="footer-brand">
                        @if($siteSettings && $siteSettings->logo)
                            <img src="{{ store_image($siteSettings->logo) }}"
                                 alt="{{ $siteSettings->site_name ?? 'Logo' }}"
                                 class="footer-logo mb-3">
                        @else
                            <div class="footer-logo-placeholder mb-3">
                                <i class="fas fa-store"></i>
                            </div>
                        @endif

                        <h4 class="footer-brand-name">
                            {{ $siteSettings->site_name ?? 'MatchStore' }}
                        </h4>

                        @if($siteSettings && $siteSettings->tagline)
                            <p class="footer-tagline">
                                {{ $siteSettings->tagline }}
                            </p>
                        @else
                            <p class="footer-tagline">
                                Your trusted destination for quality products and exceptional service.
                            </p>
                        @endif

                        {{-- Social Media Links --}}
                        <div class="footer-social mt-4">
                            <h6 class="mb-3">{{ __('store.footer.follow_us') }}</h6>
                            <div class="social-icons">
                                @forelse($socialLinks as $social)
                                    <a href="{{ $social->link }}"
                                       target="_blank"
                                       rel="noopener noreferrer"
                                       class="social-link social-{{ strtolower($social->platform) }}"
                                       title="{{ ucfirst($social->platform) }}">
                                        <i class="fab fa-{{ strtolower($social->platform) }}"></i>
                                    </a>
                                @empty
                                    <a href="#" class="social-link"><i class="fab fa-facebook-f"></i></a>
                                    <a href="#" class="social-link"><i class="fab fa-twitter"></i></a>
                                    <a href="#" class="social-link"><i class="fab fa-instagram"></i></a>
                                    <a href="#" class="social-link"><i class="fab fa-linkedin-in"></i></a>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Column 2: Quick Links --}}
                <div class="col-lg-2 col-md-6">
                    <div class="footer-section footer-collapsible">
                        <h5 class="footer-title footer-toggle" data-target="pages-menu">
                            {{ __('store.footer.pages') }}
                            <i class="fas fa-chevron-down toggle-icon"></i>
                        </h5>
                        <ul class="footer-menu footer-collapse" id="pages-menu">
                            @forelse($footerPages as $page)
                                @php
                                    $pageTranslation = $page->translations()
                                        ->where('language_code', app()->getLocale())
                                        ->first() ?? $page->translations()->first();
                                @endphp
                                @if($pageTranslation)
                                    <li>
                                        <a href="{{ route('page.show', $page->slug) }}" class="footer-link">
                                            <i class="fas fa-chevron-right"></i>
                                            {{ $pageTranslation->title }}
                                        </a>
                                    </li>
                                @endif
                            @empty
                                <li>
                                    <a href="#" class="footer-link">
                                        <i class="fas fa-chevron-right"></i>
                                        {{ __('store.footer.privacy_policy') }}
                                    </a>
                                </li>
                                <li>
                                    <a href="#" class="footer-link">
                                        <i class="fas fa-chevron-right"></i>
                                        {{ __('store.footer.terms_of_service') }}
                                    </a>
                                </li>
                            @endforelse
                        </ul>
                    </div>
                </div>

                {{-- Column 3: Account --}}
                <div class="col-lg-2 col-md-6">
                    <div class="footer-section footer-collapsible">
                        <h5 class="footer-title footer-toggle" data-target="account-menu">
                            {{ __('store.footer.account') }}
                            <i class="fas fa-chevron-down toggle-icon"></i>
                        </h5>
                        <ul class="footer-menu footer-collapse" id="account-menu">
                            <li>
                                <a href="{{ auth('customer')->check() ? route('customer.profile.edit') : route('customer.login') }}"
                                   class="footer-link">
                                    <i class="fas fa-chevron-right"></i>
                                    {{ __('store.footer.my_account') }}
                                </a>
                            </li>
                            <li>
                                <a href="{{ auth('customer')->check() ? route('customer.wishlist.index') : route('customer.login') }}"
                                   class="footer-link">
                                    <i class="fas fa-chevron-right"></i>
                                    {{ __('store.footer.wishlist') }}
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('cart.view') }}" class="footer-link">
                                    <i class="fas fa-chevron-right"></i>
                                    {{ __('store.footer.shopping_cart') }}
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>

                {{-- Column 4: Contact Info --}}
                <div class="col-lg-4 col-md-6">
                    <div class="footer-section footer-collapsible">
                        <h5 class="footer-title footer-toggle" data-target="contact-menu">
                            {{ __('store.footer.contact_us') }}
                            <i class="fas fa-chevron-down toggle-icon"></i>
                        </h5>
                        <ul class="footer-contact footer-collapse" id="contact-menu">
                            @if($siteSettings && $siteSettings->contact_email)
                                <li class="contact-item">
                                    <div class="contact-icon">
                                        <i class="fas fa-envelope"></i>
                                    </div>
                                    <div class="contact-info">
                                        <span class="contact-label">Email</span>
                                        <a href="mailto:{{ $siteSettings->contact_email }}" class="contact-value">
                                            {{ $siteSettings->contact_email }}
                                        </a>
                                    </div>
                                </li>
                            @endif

                            @if($siteSettings && $siteSettings->contact_phone)
                                <li class="contact-item">
                                    <div class="contact-icon">
                                        <i class="fas fa-phone-alt"></i>
                                    </div>
                                    <div class="contact-info">
                                        <span class="contact-label">Phone</span>
                                        <a href="tel:{{ $siteSettings->contact_phone }}" class="contact-value">
                                            {{ $siteSettings->contact_phone }}
                                        </a>
                                    </div>
                                </li>
                            @endif

                            @if($siteSettings && $siteSettings->contact_phone_2)
                                <li class="contact-item">
                                    <div class="contact-icon">
                                        <i class="fas fa-mobile-alt"></i>
                                    </div>
                                    <div class="contact-info">
                                        <span class="contact-label">Phone 2</span>
                                        <a href="tel:{{ $siteSettings->contact_phone_2 }}" class="contact-value">
                                            {{ $siteSettings->contact_phone_2 }}
                                        </a>
                                    </div>
                                </li>
                            @endif

                            @if($siteSettings && $siteSettings->address)
                                <li class="contact-item">
                                    <div class="contact-icon">
                                        <i class="fas fa-map-marker-alt"></i>
                                    </div>
                                    <div class="contact-info">
                                        <span class="contact-label">Address</span>
                                        <span class="contact-value">{{ $siteSettings->address }}</span>
                                    </div>
                                </li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Footer Bottom --}}
    <div class="footer-bottom">
        <div class="container-fluid">
            <div class="row align-items-center py-4">
                <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                    <p class="copyright-text mb-0">
                        © {{ date('Y') }} {{ $siteSettings->site_name ?? 'MatchStore' }}.
                        {{ __('store.common.all_rights_reserved') }}
                    </p>
                </div>
                <div class="col-md-6 text-center text-md-end">
                    <p class="developer-credit mb-0">
                        {{ __('store.footer.developed_by') }}
                        <a href="https://matchprosys.com"
                           target="_blank"
                           rel="noopener noreferrer"
                           class="developer-link">
                            <i class="fas fa-code"></i> Match Systems
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</footer>

<style>
    /* Remove all bottom spacing */
    html, body {
        margin: 0 !important;
        padding: 0 !important;
        height: 100%;
    }

    body {
        display: flex;
        flex-direction: column;
    }

    main {
        flex: 1;
    }

    /* Modern Footer Styles */
    .modern-footer {
        margin-top: 4rem;
        margin-bottom: 0 !important;
        padding-bottom: 0 !important;
    }

    /* Newsletter Section */
    .footer-newsletter {
        background: linear-gradient(135deg, #1e293b 0%, #334155 100%);
        border-bottom: 1px solid rgba(132, 204, 22, 0.2);
    }

    .newsletter-content {
        color: #ffffff;
    }

    .newsletter-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: #ffffff;
        margin-bottom: 0.5rem;
        display: flex;
        align-items: center;
    }

    .newsletter-title i {
        color: var(--main-color);
    }

    /* RTL Support for Newsletter Title Icon */
    [dir="rtl"] .newsletter-title i,
    html[lang="ar"] .newsletter-title i {
        margin-left: 0.5rem;
        margin-right: 0;
    }

    .newsletter-text {
        color: #cbd5e1;
        font-size: 0.95rem;
    }

    .newsletter-form .input-group {
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
        display: flex;
        flex-direction: row;
    }

    /* Force RTL layout for Arabic */
    .newsletter-form .input-group.rtl-newsletter {
        direction: ltr !important;
    }

    .newsletter-form .form-control {
        padding: 0.875rem 1.25rem;
        font-size: 1rem;
        border: 2px solid transparent;
        background: #ffffff;
        transition: all 0.3s ease;
        flex: 1;
    }

    /* Border radius for input - first child gets left radius, last child gets right radius */
    .newsletter-form .form-control:first-child {
        border-radius: 12px 0 0 12px;
    }

    .newsletter-form .form-control:last-child {
        border-radius: 0 12px 12px 0;
    }

    .newsletter-form .form-control:focus {
        border-color: var(--main-color);
        box-shadow: 0 0 0 0.2rem rgba(132, 204, 22, 0.25);
        outline: none;
    }

    .newsletter-form .btn-newsletter {
        padding: 0.875rem 1.75rem;
        font-size: 1rem;
        font-weight: 600;
        background: linear-gradient(135deg, var(--main-color), var(--main-color-light));
        color: #ffffff;
        border: none;
        white-space: nowrap;
        transition: all 0.3s ease;
    }

    /* Border radius for button - first child gets left radius, last child gets right radius */
    .newsletter-form .btn-newsletter:first-child {
        border-radius: 12px 0 0 12px;
    }

    .newsletter-form .btn-newsletter:last-child {
        border-radius: 0 12px 12px 0;
    }

    .newsletter-form .btn-newsletter:hover {
        background: linear-gradient(135deg, var(--main-color-light), var(--main-color));
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(132, 204, 22, 0.4);
    }

    /* Footer Main */
    .footer-main {
        background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
        color: #e2e8f0;
        position: relative;
        overflow: hidden;
    }

    .footer-main::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 3px;
        background: linear-gradient(90deg, var(--main-color) 0%, var(--main-color-light) 50%, var(--main-color) 100%);
    }

    /* Footer Brand */
    .footer-brand {
        max-width: 400px;
    }

    .footer-logo {
        max-width: 180px;
        height: auto;
        filter: brightness(1.1);
    }

    .footer-logo-placeholder {
        width: 75px;
        height: 75px;
        background: linear-gradient(135deg, var(--main-color), var(--main-color-light));
        border-radius: 15px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        color: #ffffff;
        font-size: 2.25rem;
    }

    .footer-brand-name {
        font-size: 1.85rem;
        font-weight: 800;
        background: linear-gradient(135deg, var(--main-color) 0%, var(--main-color-light) 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin-bottom: 1rem;
    }

    .footer-tagline {
        color: #94a3b8;
        font-size: 0.95rem;
        line-height: 1.6;
        margin-bottom: 0;
    }

    /* Footer Sections */
    .footer-section h6,
    .footer-title {
        color: #ffffff;
        font-weight: 700;
        font-size: 1.1rem;
        margin-bottom: 1.5rem;
        position: relative;
        padding-bottom: 0.75rem;
    }

    .footer-title::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 40px;
        height: 3px;
        background: linear-gradient(90deg, var(--main-color), var(--main-color-light));
        border-radius: 3px;
    }

    /* RTL Support for Footer Title Underline */
    [dir="rtl"] .footer-title::after,
    html[lang="ar"] .footer-title::after {
        left: auto;
        right: 0;
    }

    /* Footer Menu */
    .footer-menu {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .footer-menu li {
        margin-bottom: 0.75rem;
    }

    .footer-link {
        color: #cbd5e1;
        text-decoration: none;
        font-size: 0.95rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.3s ease;
    }

    .footer-link i {
        font-size: 0.7rem;
        color: var(--main-color);
        transition: transform 0.3s ease;
    }

    .footer-link:hover {
        color: var(--main-color-light);
        padding-left: 0.5rem;
    }

    /* RTL Support for Footer Link Hover */
    [dir="rtl"] .footer-link:hover,
    html[lang="ar"] .footer-link:hover {
        padding-left: 0;
        padding-right: 0.5rem;
    }

    .footer-link:hover i {
        transform: translateX(3px);
    }

    /* RTL Support for Footer Link Icon Hover */
    [dir="rtl"] .footer-link:hover i,
    html[lang="ar"] .footer-link:hover i {
        transform: translateX(-3px);
    }

    /* Footer Contact */
    .footer-contact {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .contact-item {
        display: flex;
        gap: 1rem;
        margin-bottom: 1.25rem;
        padding: 1rem;
        background: rgba(255,255,255,0.03);
        border-radius: 12px;
        border: 1px solid rgba(132, 204, 22, 0.1);
        transition: all 0.3s ease;
    }

    .contact-item:hover {
        background: rgba(132, 204, 22, 0.05);
        border-color: rgba(132, 204, 22, 0.3);
        transform: translateX(5px);
    }

    /* RTL Support for Contact Item Hover */
    [dir="rtl"] .contact-item:hover,
    html[lang="ar"] .contact-item:hover {
        transform: translateX(-5px);
    }

    .contact-icon {
        width: 45px;
        height: 45px;
        background: linear-gradient(135deg, var(--main-color), var(--main-color-light));
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #ffffff;
        font-size: 1.1rem;
        flex-shrink: 0;
    }

    .contact-info {
        display: flex;
        flex-direction: column;
        gap: 0.25rem;
    }

    .contact-label {
        font-size: 0.8rem;
        color: #94a3b8;
        font-weight: 500;
        letter-spacing: 0.5px;
    }

    .contact-value {
        color: #e2e8f0;
        font-size: 0.95rem;
        text-decoration: none;
        transition: color 0.3s ease;
    }

    a.contact-value:hover {
        color: var(--main-color-light);
    }

    /* Footer Social */
    .footer-social h6 {
        color: #ffffff;
        font-size: 1rem;
        font-weight: 600;
    }

    .social-icons {
        display: flex;
        gap: 0.75rem;
        flex-wrap: wrap;
    }

    .social-link {
        width: 45px;
        height: 45px;
        background: rgba(255,255,255,0.05);
        border: 1px solid rgba(132, 204, 22, 0.2);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #cbd5e1;
        font-size: 1.1rem;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .social-link:hover {
        background: linear-gradient(135deg, var(--main-color), var(--main-color-light));
        border-color: transparent;
        color: #ffffff;
        transform: translateY(-3px) rotate(5deg);
        box-shadow: 0 5px 15px rgba(132, 204, 22, 0.3);
    }

    /* Footer Bottom */
    .footer-bottom {
        background: #0a0f1a;
        border-top: 1px solid rgba(132, 204, 22, 0.1);
        padding-bottom: 0 !important;
        margin-bottom: 0 !important;
    }

    .footer-bottom .row {
        margin-bottom: 0 !important;
    }

    .footer-bottom .py-4 {
        padding-bottom: 1.5rem !important;
    }

    .copyright-text,
    .developer-credit {
        color: #94a3b8;
        font-size: 0.9rem;
    }

    /* RTL Support for Footer Bottom Text Alignment */
    [dir="rtl"] .col-md-6.text-md-start,
    html[lang="ar"] .col-md-6.text-md-start {
        text-align: right !important;
    }

    [dir="rtl"] .col-md-6.text-md-end,
    html[lang="ar"] .col-md-6.text-md-end {
        text-align: left !important;
    }

    @media (max-width: 767px) {
        [dir="rtl"] .col-md-6.text-md-start,
        html[lang="ar"] .col-md-6.text-md-start,
        [dir="rtl"] .col-md-6.text-md-end,
        html[lang="ar"] .col-md-6.text-md-end {
            text-align: center !important;
        }
    }

    .developer-link {
        color: var(--main-color);
        text-decoration: none;
        font-weight: 600;
        margin-left: 0.5rem;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    /* RTL Support for Developer Link */
    [dir="rtl"] .developer-link,
    html[lang="ar"] .developer-link {
        margin-left: 0;
        margin-right: 0.5rem;
    }

    .developer-link:hover {
        color: var(--main-color-light);
        gap: 0.75rem;
    }

    .developer-link i {
        animation: pulse 2s ease-in-out infinite;
    }

    @keyframes pulse {
        0%, 100% {
            opacity: 1;
        }
        50% {
            opacity: 0.6;
        }
    }

    /* Responsive */
    @media (max-width: 991px) {
        .modern-footer {
            margin-top: 3rem;
        }

        .newsletter-title {
            font-size: 1.25rem;
        }

        .newsletter-text {
            font-size: 0.9rem;
        }

        .newsletter-form .btn-newsletter {
            padding: 0.875rem 1.25rem;
            font-size: 0.9rem;
        }

        .footer-brand {
            max-width: 100%;
            margin-bottom: 2rem;
        }

        .footer-logo {
            max-width: 160px;
        }

        .footer-logo-placeholder {
            width: 65px;
            height: 65px;
            font-size: 2rem;
        }

        .footer-brand-name {
            font-size: 1.6rem;
        }

        .footer-section {
            margin-bottom: 2rem;
        }

        .social-icons {
            justify-content: center;
        }

        .footer-bottom .col-md-6 {
            text-align: center !important;
        }
    }

    @media (max-width: 575px) {
        .newsletter-title {
            font-size: 1.1rem;
            text-align: center;
        }

        .newsletter-text {
            font-size: 0.85rem;
            text-align: center;
        }

        .newsletter-form .form-control,
        .newsletter-form .btn-newsletter {
            font-size: 0.85rem;
            padding: 0.75rem 1rem;
        }

        .footer-main .row {
            padding: 2rem 0;
        }

        .footer-title {
            font-size: 1rem;
        }

        .contact-item {
            padding: 0.75rem;
        }

        .contact-icon {
            width: 40px;
            height: 40px;
            font-size: 1rem;
        }

        .social-link {
            width: 40px;
            height: 40px;
            font-size: 1rem;
        }
    }

    /* ====================================
       COMPACT FOOTER OVERRIDES
       ==================================== */

    /* Reduce overall footer size */
    .modern-footer {
        margin-top: 2rem !important;
    }

    /* Compact Newsletter */
    .footer-newsletter .py-4 {
        padding-top: 1.5rem !important;
        padding-bottom: 1.5rem !important;
    }

    .newsletter-title {
        font-size: 1.2rem !important;
        margin-bottom: 0.35rem !important;
    }

    .newsletter-text {
        font-size: 0.85rem !important;
    }

    .newsletter-form .form-control {
        padding: 0.75rem 1rem !important;
        font-size: 0.9rem !important;
    }

    .newsletter-form .btn-newsletter {
        padding: 0.75rem 1.35rem !important;
        font-size: 0.9rem !important;
    }

    /* Compact Footer Main */
    .footer-main .py-5 {
        padding-top: 2rem !important;
        padding-bottom: 2rem !important;
    }

    .footer-main .g-4 {
        --bs-gutter-y: 1.5rem !important;
    }

    /* Compact Footer Brand */
    .footer-brand {
        max-width: 350px !important;
    }

    .footer-logo {
        max-width: 140px !important;
        margin-bottom: 0.75rem !important;
    }

    .footer-logo-placeholder {
        width: 60px !important;
        height: 60px !important;
        font-size: 1.75rem !important;
        margin-bottom: 0.75rem !important;
    }

    .footer-brand-name {
        font-size: 1.45rem !important;
        margin-bottom: 0.5rem !important;
    }

    .footer-tagline {
        font-size: 0.8rem !important;
        line-height: 1.5 !important;
    }

    /* Compact Footer Sections */
    .footer-section h6,
    .footer-title {
        font-size: 0.95rem !important;
        margin-bottom: 1rem !important;
        padding-bottom: 0.5rem !important;
    }

    .footer-title::after {
        width: 30px !important;
        height: 2px !important;
    }

    /* Compact Footer Menu */
    .footer-menu {
        margin: 0 !important;
    }

    .footer-menu li {
        margin-bottom: 0.5rem !important;
    }

    .footer-link {
        font-size: 0.8rem !important;
        padding: 0.3rem 0 !important;
    }

    .footer-link i {
        font-size: 0.65rem !important;
    }

    /* Compact Contact Info */
    .contact-item {
        padding: 0.75rem 1rem !important;
        gap: 0.85rem !important;
        margin-bottom: 0.85rem !important;
    }

    .contact-icon {
        width: 40px !important;
        height: 40px !important;
        font-size: 1rem !important;
        border-radius: 10px !important;
    }

    .contact-label {
        font-size: 0.7rem !important;
    }

    .contact-value {
        font-size: 0.85rem !important;
    }

    .contact-info h6 {
        font-size: 0.8rem !important;
        margin-bottom: 0.2rem !important;
    }

    .contact-info p {
        font-size: 0.75rem !important;
    }

    /* Compact Social Links */
    .footer-social h6 {
        font-size: 0.9rem !important;
        margin-bottom: 0.75rem !important;
    }

    .social-icons {
        gap: 0.5rem !important;
    }

    .social-link {
        width: 36px !important;
        height: 36px !important;
        font-size: 0.9rem !important;
    }

    /* Compact Newsletter */
    .newsletter-section {
        max-width: 400px !important;
    }

    .newsletter-section h5 {
        font-size: 0.95rem !important;
        margin-bottom: 0.75rem !important;
    }

    .newsletter-section p {
        font-size: 0.8rem !important;
        margin-bottom: 1rem !important;
    }

    .newsletter-form input {
        padding: 0.6rem 1rem !important;
        font-size: 0.8rem !important;
    }

    .newsletter-form button {
        padding: 0.6rem 1.25rem !important;
        font-size: 0.8rem !important;
    }

    /* Compact Footer Bottom */
    .footer-bottom {
        padding: 1rem 0 0 0 !important;
        margin-bottom: 0 !important;
    }

    .footer-bottom .py-4 {
        padding-top: 1rem !important;
        padding-bottom: 1rem !important;
    }

    .footer-bottom p {
        font-size: 0.75rem !important;
        margin: 0.25rem 0 !important;
    }

    .payment-methods {
        gap: 0.5rem !important;
    }

    .payment-icon {
        width: 35px !important;
        height: 24px !important;
        font-size: 0.85rem !important;
    }

    /* Collapsible Footer Sections */
    .toggle-icon {
        display: none;
        font-size: 0.7rem;
        transition: transform 0.3s ease;
        margin-left: auto;
    }

    .footer-toggle {
        cursor: default;
    }

    .footer-collapse {
        max-height: 1000px;
        overflow: hidden;
        transition: max-height 0.3s ease;
    }

    /* iPad Mini and Small Tablets (768px - 991px) */
    @media (min-width: 768px) and (max-width: 991px) {
        .modern-footer {
            margin-top: 2rem !important;
        }

        .footer-newsletter .py-4 {
            padding-top: 1.25rem !important;
            padding-bottom: 1.25rem !important;
        }

        .newsletter-title {
            font-size: 1.1rem !important;
        }

        .newsletter-text {
            font-size: 0.8rem !important;
        }

        .newsletter-form .form-control {
            padding: 0.7rem 1rem !important;
            font-size: 0.85rem !important;
        }

        .newsletter-form .btn-newsletter {
            padding: 0.7rem 1.25rem !important;
            font-size: 0.85rem !important;
        }

        .footer-main .py-5 {
            padding-top: 2.5rem !important;
            padding-bottom: 2.5rem !important;
        }

        .footer-logo {
            max-width: 120px !important;
        }

        .footer-brand-name {
            font-size: 1.3rem !important;
        }

        .footer-title {
            font-size: 0.9rem !important;
        }

        .footer-link {
            font-size: 0.75rem !important;
        }

        .contact-item {
            padding: 1.2rem 1.5rem !important;
            margin-bottom: 1rem !important;
        }

        .contact-icon {
            width: 50px !important;
            height: 50px !important;
            font-size: 1.2rem !important;
        }

        .contact-label {
            font-size: 0.8rem !important;
        }

        .contact-value {
            font-size: 0.95rem !important;
            word-break: break-word;
        }

        /* Social icons - left aligned */
        .social-icons {
            justify-content: flex-start !important;
        }

        .social-link {
            width: 44px !important;
            height: 44px !important;
            font-size: 1.1rem !important;
        }

        /* 2-column layout for iPad Mini */
        .footer-main .row.g-4 {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1.5rem;
        }

        .footer-main .col-lg-4:first-child {
            grid-column: 1 / -1;
        }

        /* Contact section - make it span full width */
        .footer-main .col-lg-4:last-child {
            grid-column: 1 / -1;
        }

        .footer-contact {
            display: flex;
            flex-direction: row;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .contact-item {
            flex: 1 1 calc(50% - 0.5rem);
            min-width: 200px;
        }

        .contact-info {
            flex: 1;
            min-width: 0;
        }
    }

    /* Mobile Compact Footer */
    @media (max-width: 767px) {
        /* Significantly reduce footer margin */
        .modern-footer {
            margin-top: 0.5rem !important;
        }

        /* Show toggle icons on mobile */
        .toggle-icon {
            display: inline-block !important;
        }

        .footer-toggle {
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: space-between;
            user-select: none;
            transition: color 0.3s ease;
        }

        .footer-toggle:hover {
            color: var(--main-color-light);
        }

        /* Expanded state - when NOT collapsed */
        .footer-toggle:not(.collapsed) {
            color: var(--main-color-light);
        }

        .footer-toggle:not(.collapsed) .toggle-icon {
            transform: rotate(0deg);
        }

        /* Collapsed state */
        .footer-collapse.collapsed {
            max-height: 0 !important;
            margin-top: 0 !important;
        }

        .footer-toggle.collapsed {
            color: rgba(255, 255, 255, 0.7);
        }

        .footer-toggle.collapsed .toggle-icon {
            transform: rotate(-90deg);
        }

        /* RTL support for collapsed icon */
        [dir="rtl"] .footer-toggle.collapsed .toggle-icon,
        html[lang="ar"] .footer-toggle.collapsed .toggle-icon {
            transform: rotate(90deg);
        }

        /* Compact Newsletter Section */
        .footer-newsletter {
            padding: 0 !important;
        }

        .footer-newsletter .py-4 {
            padding: 8px 12px !important;
        }

        .footer-newsletter .row {
            margin: 0 !important;
        }

        .newsletter-content {
            text-align: center;
            margin-bottom: 6px;
        }

        .newsletter-title {
            font-size: 0.75rem !important;
            justify-content: center;
            margin-bottom: 2px !important;
        }

        .newsletter-title i {
            font-size: 0.7rem;
        }

        .newsletter-text {
            font-size: 0.65rem !important;
            margin-bottom: 0 !important;
            display: none; /* Hide description to save space */
        }

        .newsletter-form .input-group {
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .newsletter-form .form-control {
            padding: 7px 10px !important;
            font-size: 0.7rem !important;
        }

        .newsletter-form .btn-newsletter {
            padding: 7px 12px !important;
            font-size: 0.7rem !important;
        }

        .newsletter-form .btn-newsletter i {
            display: none;
        }

        /* Compact Footer Main */
        .footer-main {
            padding: 0 !important;
        }

        .footer-main .py-5 {
            padding: 10px !important;
        }

        .footer-main .row.g-4 {
            --bs-gutter-x: 0 !important;
            --bs-gutter-y: 10px !important;
            margin: 0 !important;
        }

        .footer-main .col-lg-4,
        .footer-main .col-lg-2,
        .footer-main .col-md-6 {
            padding: 0 !important;
        }

        /* Compact Brand Section */
        .footer-brand {
            text-align: center;
            margin: 0 auto !important;
            padding-bottom: 8px;
            border-bottom: 1px solid rgba(255,255,255,0.08);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .footer-logo {
            max-width: 70px !important;
            margin: 0 auto 4px auto !important;
            display: block;
        }

        .footer-logo-placeholder {
            width: 35px !important;
            height: 35px !important;
            font-size: 1rem !important;
            margin: 0 auto 4px auto !important;
            border-radius: 8px !important;
        }

        .footer-brand-name {
            font-size: 0.9rem !important;
            margin: 0 auto 4px auto !important;
            text-align: center;
        }

        .footer-tagline {
            font-size: 0.65rem !important;
            line-height: 1.3 !important;
            margin: 0 !important;
            display: none; /* Hide tagline on mobile to save space */
        }

        /* Compact Social Section */
        .footer-social {
            margin-top: 6px !important;
            text-align: center;
        }

        .footer-social h6 {
            font-size: 0.65rem !important;
            margin-bottom: 4px !important;
            text-align: center;
        }

        .social-icons {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 6px !important;
            margin: 0 auto;
        }

        .social-link {
            width: 26px !important;
            height: 26px !important;
            font-size: 0.7rem !important;
            border-radius: 6px !important;
        }

        /* Compact Footer Sections - Show as 2 columns */
        .footer-section {
            margin-bottom: 0 !important;
            padding: 8px 0 !important;
            border-bottom: 1px solid rgba(255,255,255,0.04);
        }

        .footer-title {
            font-size: 0.7rem !important;
            margin-bottom: 6px !important;
            padding-bottom: 4px !important;
        }

        .footer-title::after {
            width: 20px !important;
            height: 1.5px !important;
        }

        .footer-menu li {
            margin-bottom: 3px !important;
        }

        .footer-link {
            font-size: 0.65rem !important;
            padding: 1px 0 !important;
            gap: 4px !important;
        }

        .footer-link i {
            font-size: 0.5rem !important;
        }

        /* Compact Contact Info */
        .footer-contact {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 6px;
        }

        .contact-item {
            padding: 6px !important;
            gap: 6px !important;
            margin-bottom: 0 !important;
            border-radius: 6px !important;
        }

        .contact-icon {
            width: 24px !important;
            height: 24px !important;
            font-size: 0.65rem !important;
            border-radius: 5px !important;
        }

        .contact-label {
            font-size: 0.55rem !important;
            display: none; /* Hide labels on mobile */
        }

        .contact-value {
            font-size: 0.6rem !important;
        }

        /* Compact Footer Bottom */
        .footer-bottom {
            padding: 0 !important;
            margin-bottom: 0 !important;
        }

        .footer-bottom .py-4 {
            padding: 6px 12px !important;
        }

        .footer-bottom .row {
            margin: 0 !important;
        }

        .footer-bottom .col-md-6 {
            padding: 0 !important;
        }

        .copyright-text,
        .developer-credit {
            font-size: 0.55rem !important;
            margin: 0 !important;
            line-height: 1.3 !important;
        }

        .developer-link {
            margin-left: 3px !important;
            gap: 3px !important;
        }

        .developer-link i {
            font-size: 0.5rem;
        }
    }

    /* Extra small mobile adjustments */
    @media (max-width: 380px) {
        .newsletter-title {
            font-size: 0.7rem !important;
        }

        .newsletter-form .form-control {
            padding: 6px 8px !important;
            font-size: 0.65rem !important;
        }

        .newsletter-form .btn-newsletter {
            padding: 6px 10px !important;
            font-size: 0.65rem !important;
        }

        .footer-brand-name {
            font-size: 0.85rem !important;
        }

        .footer-contact {
            grid-template-columns: 1fr;
        }

        .social-link {
            width: 24px !important;
            height: 24px !important;
            font-size: 0.65rem !important;
        }

        .footer-title {
            font-size: 0.65rem !important;
        }

        .footer-link {
            font-size: 0.6rem !important;
        }

        .contact-value {
            font-size: 0.55rem !important;
        }

        .copyright-text,
        .developer-credit {
            font-size: 0.5rem !important;
        }
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Footer Collapsible Sections (Mobile Only)
    function initFooterCollapse() {
        const toggles = document.querySelectorAll('.footer-toggle');

        // Only initialize on mobile
        if (window.innerWidth <= 768) {
            toggles.forEach(toggle => {
                const targetId = toggle.getAttribute('data-target');
                const targetMenu = document.getElementById(targetId);

                // Start with sections collapsed on mobile
                toggle.classList.add('collapsed');
                if (targetMenu) {
                    targetMenu.classList.add('collapsed');
                }

                toggle.addEventListener('click', function() {
                    this.classList.toggle('collapsed');
                    if (targetMenu) {
                        targetMenu.classList.toggle('collapsed');
                    }
                });
            });
        } else {
            // Remove collapsed state on desktop
            toggles.forEach(toggle => {
                const targetId = toggle.getAttribute('data-target');
                const targetMenu = document.getElementById(targetId);

                toggle.classList.remove('collapsed');
                if (targetMenu) {
                    targetMenu.classList.remove('collapsed');
                }
            });
        }
    }

    // Initialize on load
    initFooterCollapse();

    // Re-initialize on resize
    let resizeTimer;
    window.addEventListener('resize', function() {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(function() {
            initFooterCollapse();
        }, 250);
    });

    // Newsletter Form
    const newsletterForm = document.getElementById('footerNewsletterForm');
    if (newsletterForm) {
        newsletterForm.addEventListener('submit', async function(e) {
            e.preventDefault();

            const emailInput = this.querySelector('input[name="email"]');
            const submitButton = this.querySelector('button[type="submit"]');
            const email = emailInput.value;

            // Disable submit button during request
            submitButton.disabled = true;
            const originalButtonText = submitButton.innerHTML;
            submitButton.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>{{ __("store.footer.subscribe") }}';

            try {
                const response = await fetch('{{ route("newsletter.subscribe") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ email: email })
                });

                const data = await response.json();

                if (data.success) {
                    // Success - show success message
                    showNewsletterToast(data.message, 'success');
                    this.reset();
                } else {
                    // Error - show error message
                    showNewsletterToast(data.message, 'error');
                }
            } catch (error) {
                console.error('Newsletter subscription error:', error);
                showNewsletterToast('{{ __("store.newsletter.error") }}', 'error');
            } finally {
                // Re-enable submit button
                submitButton.disabled = false;
                submitButton.innerHTML = originalButtonText;
            }
        });
    }

    // Toast notification function
    function showNewsletterToast(message, type) {
        // Check if toast container exists, if not create it
        let toastContainer = document.getElementById('newsletterToastContainer');
        if (!toastContainer) {
            toastContainer = document.createElement('div');
            toastContainer.id = 'newsletterToastContainer';
            toastContainer.style.cssText = 'position: fixed; top: 20px; right: 20px; z-index: 9999;';
            document.body.appendChild(toastContainer);
        }

        // Create toast element
        const toast = document.createElement('div');
        toast.style.cssText = `
            padding: 16px 24px;
            margin-bottom: 10px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 14px;
            font-weight: 500;
            animation: slideIn 0.3s ease;
            max-width: 400px;
            ${type === 'success'
                ? 'background: #ecfdf5; color: #065f46; border-left: 4px solid var(--main-color);'
                : 'background: #fef2f2; color: #991b1b; border-left: 4px solid #ef4444;'}
        `;

        const icon = type === 'success' ? '<i class="fas fa-check-circle" style="font-size: 18px;"></i>' : '<i class="fas fa-exclamation-circle" style="font-size: 18px;"></i>';
        toast.innerHTML = `${icon}<span>${message}</span>`;

        toastContainer.appendChild(toast);

        // Remove toast after 5 seconds
        setTimeout(() => {
            toast.style.animation = 'slideOut 0.3s ease';
            setTimeout(() => toast.remove(), 300);
        }, 5000);
    }
});

// Add animation styles
const style = document.createElement('style');
style.textContent = `
    @keyframes slideIn {
        from {
            transform: translateX(400px);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }
    @keyframes slideOut {
        from {
            transform: translateX(0);
            opacity: 1;
        }
        to {
            transform: translateX(400px);
            opacity: 0;
        }
    }
`;
document.head.appendChild(style);
</script>
