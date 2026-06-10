@php $currency = activeCurrency(); @endphp

<style>
/* Modern Product Card Styling */
.product-card-modern {
    background: white;
    border-radius: 16px;
    overflow: hidden;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    border: 1px solid #e9ecef;
    height: 100%;
    display: flex;
    flex-direction: column;
}

.product-card-modern:hover {
    transform: translateY(-8px);
    box-shadow: 0 12px 40px rgba(0, 0, 0, 0.12);
    border-color: var(--main-color);
}

.product-image-wrapper {
    position: relative;
    overflow: hidden;
    aspect-ratio: 1/1;
    background: #f8f9fa;
}

.product-image-wrapper img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s ease;
}

.product-card-modern:hover .product-image-wrapper img {
    transform: scale(1.1);
}

.product-badge {
    position: absolute;
    top: 1rem;
    left: 1rem;
    background: linear-gradient(135deg, #ff6b6b 0%, #ee5a6f 100%);
    color: white;
    padding: 0.4rem 0.8rem;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 700;
    z-index: 10;
}

.wishlist-btn-modern {
    position: absolute;
    top: 1rem;
    right: 1rem;
    width: 40px;
    height: 40px;
    background: white;
    border: none;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    z-index: 10;
    opacity: 0;
}

.product-card-modern:hover .wishlist-btn-modern {
    opacity: 1;
}

.wishlist-btn-modern:hover {
    transform: scale(1.1);
    background: var(--main-color);
}

.wishlist-btn-modern:hover i {
    color: white;
}

.wishlist-btn-modern i {
    font-size: 1.1rem;
    color: #64748b;
    transition: color 0.3s ease;
}

.product-details {
    padding: 1.25rem;
    flex: 1;
    display: flex;
    flex-direction: column;
}

.product-rating {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    margin-bottom: 0.75rem;
}

.rating-stars {
    display: flex;
    gap: 0.15rem;
}

.rating-stars i {
    color: #fbbf24;
    font-size: 0.9rem;
}

.rating-count {
    font-size: 0.85rem;
    color: #94a3b8;
    font-weight: 500;
}

.product-name {
    font-size: 1rem;
    font-weight: 600;
    color: #1e293b;
    margin-bottom: 0.75rem;
    line-height: 1.4;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.product-name a {
    color: inherit;
    text-decoration: none;
    transition: color 0.3s ease;
}

.product-name a:hover {
    color: var(--main-color);
}

.product-footer {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-top: auto;
    padding-top: 0.75rem;
}

.product-pricing {
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
}

.current-price {
    font-size: 1.5rem;
    font-weight: 800;
    color: var(--main-color);
    line-height: 1;
}

.old-price {
    font-size: 0.95rem;
    color: #94a3b8;
    text-decoration: line-through;
    font-weight: 500;
}

.add-to-cart-btn {
    width: 45px;
    height: 45px;
    background: var(--main-color);
    border: none;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.3s ease;
    flex-shrink: 0;
}

.add-to-cart-btn:hover {
    background: var(--main-color-light);
    transform: scale(1.1);
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
}

.add-to-cart-btn i {
    color: white;
    font-size: 1.1rem;
}

@media (max-width: 767px) {
    .product-name {
        font-size: 0.9rem;
    }

    .current-price {
        font-size: 1.25rem;
    }

    .add-to-cart-btn {
        width: 40px;
        height: 40px;
    }

    .product-details {
        padding: 1rem;
    }
}
</style>

@foreach($products as $product)
<div class="col-6 col-md-4 col-lg-4 mb-4">
    <div class="product-card-modern">
        <div class="product-image-wrapper">
            @php
                $imageUrl = optional($product->thumbnail)->image_url ?? 'default.jpg';
                $isExternal = str_starts_with($imageUrl, 'http://') || str_starts_with($imageUrl, 'https://');
                $finalImageUrl = $isExternal ? $imageUrl : asset('storage/' . $imageUrl);
            @endphp

            @if(optional($product->primaryVariant)->converted_discount_price)
                @php
                    $discount = round((($product->primaryVariant->price - $product->primaryVariant->discount_price) / $product->primaryVariant->price) * 100);
                @endphp
                <div class="product-badge">-{{ $discount }}%</div>
            @endif

            <button class="wishlist-btn-modern" onclick="toggleWishlist({{ $product->id }})">
                <i class="fa-regular fa-heart"></i>
            </button>

            <a href="{{ route('product.show', $product->slug) }}">
                <img src="{{ $finalImageUrl }}"
                     alt="{{ $product->translation->name ?? __('store.category.product_name_not_available') }}">
            </a>
        </div>

        <div class="product-details">
            <div class="product-rating">
                <div class="rating-stars">
                    @for($i = 1; $i <= 5; $i++)
                        <i class="fa-solid fa-star"></i>
                    @endfor
                </div>
                <span class="rating-count">({{ $product->reviews_count }})</span>
            </div>

            <h3 class="product-name">
                <a href="{{ route('product.show', $product->slug) }}">
                    {{ $product->translation->name ?? __('store.category.product_name_not_available') }}
                </a>
            </h3>

            <div class="product-footer">
                <div class="product-pricing">
                    <div class="current-price">
                        {{ $currency->symbol }}{{ optional($product->primaryVariant)->converted_discount_price ?? optional($product->primaryVariant)->converted_price ?? 'N/A' }}
                    </div>
                    @if(optional($product->primaryVariant)->converted_discount_price)
                        <div class="old-price">
                            {{ $currency->symbol }}{{ $product->primaryVariant->converted_price }}
                        </div>
                    @endif
                </div>

                <button class="add-to-cart-btn" onclick="addToCart({{ $product->id }})">
                    <i class="fa fa-shopping-bag"></i>
                </button>
            </div>
        </div>
    </div>
</div>
@endforeach

<script>
function toggleWishlist(productId) {
    // Add wishlist functionality here
    console.log('Toggle wishlist for product:', productId);
}
</script>
