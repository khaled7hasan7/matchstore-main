<div class="product-card-modern">
    <div class="product-image-wrapper">
        <a href="{{ route('product.show', $product->slug) }}">
            @php
                $productImage = $product->images->first();
                if ($productImage) {
                    $finalImageUrl = store_image($productImage->image_url);
                } else {
                    $finalImageUrl = 'https://via.placeholder.com/400x400?text=No+Image';
                }
            @endphp
            <img src="{{ $finalImageUrl }}"
                 alt="{{ $product->translation->name ?? 'Product' }}"
                 class="product-image"
                 loading="lazy"
                 onerror="this.onerror=null; this.src='https://via.placeholder.com/400x400?text=No+Image';">
        </a>

        {{-- Badges --}}
        <div class="product-badges">
            @if(optional($product->primaryVariant)->converted_discount_price)
            <span class="badge badge-sale">{{ __('store.product.sale') }}</span>
            @endif
        </div>

        {{-- Quick Actions --}}
        <button class="action-btn wishlist-btn" data-product-id="{{ $product->id }}" title="{{ __('store.product.add_to_wishlist') }}">
            <i class="far fa-heart"></i>
        </button>
        <a href="{{ route('product.show', $product->slug) }}" class="action-btn quick-view-btn" title="{{ __('store.product.quick_view') }}">
            <i class="far fa-eye"></i>
        </a>
    </div>

    <div class="product-info-wrapper">
        {{-- Rating --}}
        <div class="product-rating">
            <div class="stars">
                @for($i = 1; $i <= 5; $i++)
                    @if($i <= 4)
                        <i class="fas fa-star"></i>
                    @else
                        <i class="far fa-star"></i>
                    @endif
                @endfor
            </div>
            <span class="reviews-count">({{ $product->reviews_count ?? 0 }})</span>
        </div>

        {{-- Product Name --}}
        <h5 class="product-name">
            <a href="{{ route('product.show', $product->slug) }}">
                {{ Str::limit($product->translation->name ?? 'Product Name', 50) }}
            </a>
        </h5>

        {{-- Price --}}
        <div class="product-price-wrapper">
            @if(optional($product->primaryVariant)->converted_discount_price)
                <span class="price-original">
                    {{ $currency->symbol }}{{ optional($product->primaryVariant)->converted_price }}
                </span>
                <span class="price-discount">
                    {{ $currency->symbol }}{{ $product->primaryVariant->converted_discount_price }}
                </span>
            @else
                <span class="price-current">
                    {{ $currency->symbol }}{{ optional($product->primaryVariant)->converted_price ?? 'N/A' }}
                </span>
            @endif
        </div>

        {{-- Add to Cart Button --}}
        <button class="btn-add-to-cart" onclick="addToCart({{ $product->id }})">
            <i class="fas fa-shopping-cart me-2"></i>{{ __('store.product.add_to_cart') }}
        </button>
    </div>
</div>

<style>
.product-card-modern {
    background: var(--light-color);
    border-radius: 15px;
    overflow: hidden;
    transition: all 0.3s ease;
    border: 1px solid var(--border-color);
    height: 100%;
    display: flex;
    flex-direction: column;
}

.product-card-modern:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
}

.product-image-wrapper {
    position: relative;
    overflow: hidden;
    background: transparent;
    height: 200px;
}

.product-image-wrapper > a {
    display: block;
    width: 100%;
    height: 100%;
}

.product-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    object-position: center;
    transition: transform 0.3s ease;
}

.product-card-modern:hover .product-image {
    transform: none;
}

.product-badges {
    position: absolute;
    top: 15px;
    left: 15px;
    z-index: 5;
    display: flex;
    flex-direction: column;
    gap: 5px;
}

.badge {
    padding: 5px 12px;
    border-radius: 50px;
    font-size: 0.75rem;
    font-weight: 600;
}

.badge-sale {
    background: #ff4444;
    color: white;
}

.action-btn {
    position: absolute;
    width: 42px;
    height: 42px;
    background: white;
    border: none;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.3s ease;
    color: #1e293b;
    text-decoration: none;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    z-index: 20;
    opacity: 0;
    pointer-events: none;
}

.product-card-modern:hover .action-btn {
    opacity: 1;
    pointer-events: auto;
}

.action-btn:hover {
    background: linear-gradient(135deg, var(--main-color), var(--main-color-light));
    color: white;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
}

/* Wishlist button - top right */
.wishlist-btn {
    top: 15px;
    right: 15px;
    transform: translateX(10px);
}

.product-card-modern:hover .wishlist-btn {
    transform: translateX(0);
}

.wishlist-btn:hover {
    transform: translateX(0) scale(1.1);
}

/* Quick view button - bottom of image */
.quick-view-btn {
    bottom: 15px;
    right: 15px;
    transform: translateY(10px);
}

.product-card-modern:hover .quick-view-btn {
    transform: translateY(0);
}

.quick-view-btn:hover {
    transform: translateY(0) scale(1.1);
}

.product-info-wrapper {
    padding: 15px;
    flex-grow: 1;
    display: flex;
    flex-direction: column;
}

.product-rating {
    display: flex;
    align-items: center;
    gap: 4px;
    margin-bottom: 8px;
}

.stars {
    color: var(--main-color);
    font-size: 0.7rem;
}

.reviews-count {
    font-size: 0.65rem;
    color: var(--text-muted);
}

.product-name {
    margin: 0 0 12px;
    font-size: 0.95rem;
    font-weight: 600;
    line-height: 1.4;
}

.product-name a {
    color: var(--dark-color);
    text-decoration: none;
    transition: color 0.3s ease;
}

.product-name a:hover {
    color: var(--main-color);
}

.product-price-wrapper {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 12px;
}

.price-original {
    font-size: 0.85rem;
    color: var(--text-muted);
    text-decoration: line-through;
}

.price-discount,
.price-current {
    font-size: 1.1rem;
    font-weight: 700;
    color: var(--dark-color);
}

.price-discount {
    color: #ff4444;
}

.btn-add-to-cart {
    width: 100%;
    padding: 10px;
    background: linear-gradient(135deg, var(--main-color), var(--main-color-light));
    color: white;
    border: none;
    border-radius: 8px;
    font-weight: 600;
    font-size: 0.9rem;
    cursor: pointer;
    transition: all 0.3s ease;
    margin-top: auto;
}

.btn-add-to-cart:hover {
    background: linear-gradient(135deg, var(--grid-color-1), var(--main-color));
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(0,0,0, 0.2);
}

.wishlist-btn.active i {
    font-weight: 900;
    color: #ff4444;
}

/* Desktop - hide action buttons */
@media (min-width: 992px) {
    .action-btn,
    .wishlist-btn,
    .quick-view-btn {
        display: none !important;
    }
}

/* iPad Mini and Small Tablets (768px - 991px) */
@media (min-width: 768px) and (max-width: 991px) {
    .product-card-modern {
        border-radius: 12px;
        max-width: 100%;
    }

    .product-image-wrapper {
        height: 180px;
    }

    .product-info-wrapper {
        padding: 10px;
    }

    .product-rating .stars {
        font-size: 0.65rem;
    }

    .product-rating .reviews-count {
        font-size: 0.6rem;
    }

    .product-name {
        font-size: 0.85rem;
        margin-bottom: 6px;
    }

    .product-price-wrapper {
        margin-bottom: 8px;
    }

    .price-original {
        font-size: 0.8rem;
    }

    .price-discount,
    .price-current {
        font-size: 0.95rem;
    }

    .btn-add-to-cart {
        padding: 8px;
        font-size: 0.8rem;
    }

    .btn-add-to-cart i {
        font-size: 0.7rem;
    }

    .action-btn {
        width: 38px;
        height: 38px;
    }

    .badge {
        padding: 4px 10px;
        font-size: 0.7rem;
    }
}

/* Tablet Responsive */
@media (max-width: 991px) {
    .product-card-modern {
        border-radius: 12px;
    }

    .product-info-wrapper {
        padding: 12px;
    }

    .product-name {
        font-size: 0.9rem;
        margin-bottom: 8px;
    }

    .price-discount,
    .price-current {
        font-size: 1rem;
    }

    .btn-add-to-cart {
        padding: 8px;
        font-size: 0.85rem;
    }
}

/* Mobile - Complete Redesign */
@media (max-width: 768px) {
    .product-card-modern {
        border-radius: 8px;
        display: flex;
        flex-direction: column;
        height: auto;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        overflow: hidden;
        gap: 0 !important;
    }

    .product-card-modern:hover {
        transform: none;
    }

    /* Mobile image container */
    .product-image-wrapper {
        height: 220px;
        background: #f8f9fa;
        flex-shrink: 0;
        position: relative;
        overflow: hidden;
        margin: 0 !important;
        padding: 0 !important;
    }

    .product-image-wrapper > a {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        display: block;
        margin: 0 !important;
        padding: 0 !important;
    }

    .product-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: center;
        position: absolute;
        top: 0;
        left: 0;
        margin: 0 !important;
        padding: 0 !important;
    }

    .action-btn {
        display: none !important;
    }

    .wishlist-btn,
    .quick-view-btn {
        display: none !important;
    }

    .product-badges {
        top: 6px;
        left: 6px;
        z-index: 10;
    }

    .badge {
        padding: 3px 6px;
        font-size: 0.6rem;
        font-weight: 700;
    }

    /* Mobile info section */
    .product-info-wrapper {
        padding: 6px;
        flex-grow: 0;
        background: white;
        margin: 0 !important;
        line-height: 1 !important;
    }

    .product-rating {
        margin-bottom: 2px;
        line-height: 1;
    }

    .product-rating .stars {
        font-size: 0.45rem;
    }

    .product-rating .reviews-count {
        font-size: 0.4rem;
    }

    .product-name {
        font-size: 0.7rem;
        margin-bottom: 3px;
        line-height: 1.15;
        min-height: auto;
        max-height: 2.3em;
        overflow: hidden;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        font-weight: 600;
    }

    .product-price-wrapper {
        gap: 4px;
        margin-bottom: 4px;
        align-items: baseline;
        line-height: 1;
    }

    .price-original {
        font-size: 0.6rem;
    }

    .price-discount,
    .price-current {
        font-size: 0.85rem;
        font-weight: 700;
    }

    .btn-add-to-cart {
        padding: 6px;
        font-size: 0.65rem;
        border-radius: 4px;
        font-weight: 700;
        line-height: 1;
    }

    .btn-add-to-cart i {
        margin-right: 2px !important;
        font-size: 0.6rem;
    }
}

/* Small Mobile - Refined compact design */
@media (max-width: 480px) {
    .product-card-modern {
        border-radius: 6px;
    }

    .action-btn,
    .wishlist-btn,
    .quick-view-btn {
        display: none !important;
    }

    .product-badges {
        top: 5px;
        left: 5px;
    }

    .badge {
        padding: 2px 5px;
        font-size: 0.55rem;
    }

    .product-image-wrapper {
        height: 190px;
    }

    .product-info-wrapper {
        padding: 5px;
        line-height: 1 !important;
    }

    .product-rating {
        margin-bottom: 1px;
        line-height: 1;
    }

    .product-rating .stars {
        font-size: 0.4rem;
    }

    .product-rating .reviews-count {
        font-size: 0.35rem;
    }

    .product-name {
        font-size: 0.65rem;
        margin-bottom: 2px;
        line-height: 1.1;
    }

    .product-price-wrapper {
        gap: 3px;
        margin-bottom: 3px;
        line-height: 1;
    }

    .price-original {
        font-size: 0.55rem;
    }

    .price-discount,
    .price-current {
        font-size: 0.75rem;
    }

    .btn-add-to-cart {
        padding: 5px;
        font-size: 0.6rem;
        border-radius: 3px;
        line-height: 1;
    }

    .btn-add-to-cart i {
        font-size: 0.55rem;
        margin-right: 2px !important;
    }
}

/* RTL Support */
[dir="rtl"] .wishlist-btn,
html[dir="rtl"] .wishlist-btn,
body[dir="rtl"] .wishlist-btn {
    right: auto;
    left: 15px;
    transform: translateX(-10px);
}

[dir="rtl"] .product-card-modern:hover .wishlist-btn,
html[dir="rtl"] .product-card-modern:hover .wishlist-btn,
body[dir="rtl"] .product-card-modern:hover .wishlist-btn {
    transform: translateX(0);
}

[dir="rtl"] .quick-view-btn,
html[dir="rtl"] .quick-view-btn,
body[dir="rtl"] .quick-view-btn {
    right: auto;
    left: 15px;
}

[dir="rtl"] .product-card-modern:hover .quick-view-btn,
html[dir="rtl"] .product-card-modern:hover .quick-view-btn,
body[dir="rtl"] .product-card-modern:hover .quick-view-btn {
    transform: translateY(0);
}
</style>
