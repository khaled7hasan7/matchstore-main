@extends('themes.xylo.layouts.master')

@section('css')
<style>
/* Desktop/Mobile visibility */
.desktop-only {
    display: block;
}

.mobile-only {
    display: none;
}

@media (max-width: 768px) {
    .desktop-only {
        display: none !important;
    }

    .mobile-only {
        display: block !important;
    }
}

/* Mobile Responsive Wishlist */
@media (max-width: 768px) {
    .container.py-5 {
        padding-top: 1.5rem !important;
        padding-bottom: 2rem !important;
    }

    .sec-heading {
        font-size: 1.5rem;
        margin-bottom: 1.5rem !important;
    }

    .col-md-3 {
        width: 50%;
        padding: 0.5rem;
    }

    .product-card {
        border-radius: 10px;
        padding: 0.75rem;
    }

    .product-img img {
        height: 150px !important;
        border-radius: 8px;
    }

    .wishlist-btn {
        width: 30px;
        height: 30px;
        top: 0.5rem;
        right: 0.5rem;
    }

    .wishlist-btn i {
        font-size: 0.9rem;
    }

    .product-info {
        margin-top: 0.75rem !important;
    }

    .product-title {
        font-size: 0.85rem;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .reviews {
        font-size: 0.75rem;
    }

    .price {
        font-size: 0.9rem;
    }

    .price .original {
        font-size: 0.75rem;
    }

    .cart-btn {
        width: 36px;
        height: 36px;
        font-size: 0.85rem;
    }
}

/* Small Mobile */
@media (max-width: 480px) {
    .container.py-5 {
        padding-top: 1rem !important;
        padding-bottom: 1.5rem !important;
    }

    .sec-heading {
        font-size: 1.25rem;
        margin-bottom: 1rem !important;
    }

    .col-md-3 {
        padding: 0.35rem;
    }

    .product-card {
        padding: 0.5rem;
        border-radius: 8px;
    }

    .product-img img {
        height: 120px !important;
    }

    .wishlist-btn {
        width: 26px;
        height: 26px;
        top: 0.35rem;
        right: 0.35rem;
    }

    .wishlist-btn i {
        font-size: 0.75rem;
    }

    .product-info {
        margin-top: 0.5rem !important;
    }

    .product-title {
        font-size: 0.75rem;
    }

    .reviews {
        font-size: 0.65rem;
    }

    .price {
        font-size: 0.8rem;
    }

    .price .original {
        font-size: 0.65rem;
    }

    .cart-btn {
        width: 30px;
        height: 30px;
        font-size: 0.75rem;
    }

    .bottom-info {
        flex-direction: column;
        gap: 0.5rem;
    }
}

/* ================================
   Mobile Wishlist Styles
   ================================ */

/* Mobile Wishlist Header */
.mobile-wishlist-header {
    background: #fff;
    padding: 16px;
    border-bottom: 1px solid #eee;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.mobile-wishlist-header h1 {
    font-size: 18px;
    font-weight: 700;
    margin: 0;
    color: #212529;
}

.mobile-wishlist-count {
    font-size: 13px;
    color: #6c757d;
}

/* Mobile Empty Wishlist */
.mobile-empty-wishlist {
    text-align: center;
    padding: 60px 20px;
    background: #fff;
}

.mobile-empty-wishlist i {
    font-size: 60px;
    color: #dee2e6;
    margin-bottom: 16px;
}

.mobile-empty-wishlist h2 {
    font-size: 18px;
    font-weight: 600;
    margin-bottom: 8px;
}

.mobile-empty-wishlist p {
    color: #6c757d;
    font-size: 14px;
    margin-bottom: 20px;
}

.mobile-empty-wishlist a {
    display: inline-block;
    background: var(--main-color);
    color: white;
    padding: 12px 24px;
    border-radius: 8px;
    text-decoration: none;
    font-weight: 600;
}

/* Mobile Wishlist Grid */
.mobile-wishlist-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 12px;
    padding: 12px;
    background: #f8f9fa;
}

/* Mobile Wishlist Card */
.mobile-wishlist-card {
    background: #fff;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 1px 3px rgba(0,0,0,0.05);
}

.mobile-wishlist-image-wrapper {
    position: relative;
    padding-top: 100%;
    overflow: hidden;
}

.mobile-wishlist-image {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.mobile-wishlist-remove {
    position: absolute;
    top: 8px;
    right: 8px;
    width: 32px;
    height: 32px;
    background: white;
    border: none;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    box-shadow: 0 2px 6px rgba(0,0,0,0.1);
    color: #dc3545;
}

.mobile-wishlist-info {
    padding: 12px;
}

.mobile-wishlist-title {
    font-size: 13px;
    font-weight: 600;
    color: #212529;
    margin-bottom: 6px;
    line-height: 1.3;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    text-decoration: none;
}

.mobile-wishlist-title:hover {
    color: var(--main-color);
}

.mobile-wishlist-rating {
    display: flex;
    align-items: center;
    gap: 4px;
    font-size: 11px;
    color: #6c757d;
    margin-bottom: 8px;
}

.mobile-wishlist-rating i {
    color: #ffc107;
}

.mobile-wishlist-footer {
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.mobile-wishlist-price {
    font-size: 15px;
    font-weight: 700;
    color: var(--main-color);
}

.mobile-wishlist-original-price {
    font-size: 11px;
    color: #6c757d;
    text-decoration: line-through;
    margin-left: 4px;
}

.mobile-wishlist-add-cart {
    width: 36px;
    height: 36px;
    background: var(--main-color);
    border: none;
    border-radius: 8px;
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
}

/* Small Mobile */
@media (max-width: 480px) {
    .mobile-wishlist-grid {
        gap: 10px;
        padding: 10px;
    }

    .mobile-wishlist-info {
        padding: 10px;
    }

    .mobile-wishlist-title {
        font-size: 12px;
    }

    .mobile-wishlist-price {
        font-size: 13px;
    }

    .mobile-wishlist-add-cart {
        width: 32px;
        height: 32px;
    }
}
</style>
@endsection

@section('content')
@php $currency = activeCurrency(); @endphp

{{-- ================================
    DESKTOP VERSION
    ================================ --}}
<div class="desktop-only">
<div class="container py-5">
    <h1 class="sec-heading mb-5">{{ __('store.wishlist.title') }}</h1>

    @if($products->isEmpty())
        <div class="alert alert-info">{{ __('store.wishlist.empty') }}</div>
    @else
        <div class="row">
            @foreach ($products as $product)
                <div class="col-md-3 mb-4">
                    <div class="product-card">

                        <div class="product-img position-relative">
                            @php
                                $imageUrl = optional($product->thumbnail)->image_url ?? 'default.jpg';
                                $isExternal = str_starts_with($imageUrl, 'http://') || str_starts_with($imageUrl, 'https://');
                                $finalImageUrl = $isExternal ? $imageUrl : asset('storage/' . $imageUrl);
                            @endphp
                            <img src="{{ $finalImageUrl }}"
                                 alt="{{ $product->translation->name }}" style="object-fit: contain; width: 100%; height: 250px;">

                            <!-- Same wishlist heart like homepage -->
                            <button class="wishlist-btn border-0 bg-transparent"
                                    data-product-id="{{ $product->id }}">
                                <i class="fa-solid fa-heart text-danger"></i>
                            </button>
                        </div>

                        <div class="product-info mt-4">
                            <div class="top-info">
                                <div class="reviews">
                                    <i class="fa-solid fa-star"></i> ({{ $product->reviews_count }} {{ __('store.wishlist.reviews') }})
                                </div>
                            </div>

                            <div class="bottom-info">
                                <div class="left">
                                    <h3>
                                        <a href="{{ route('product.show', $product->slug) }}" class="product-title">
                                            {{ $product->translation->name }}
                                        </a>
                                    </h3>

                                    <p class="price">
                                        <span class="original {{ optional($product->primaryVariant)->converted_discount_price ? 'has-discount' : '' }}">
                                            {{ $currency->symbol }}{{ optional($product->primaryVariant)->converted_price ?? 'N/A' }}
                                        </span>

                                        @if(optional($product->primaryVariant)->converted_discount_price)
                                            <span class="discount">
                                                {{ $currency->symbol }}{{ $product->primaryVariant->converted_discount_price }}
                                            </span>
                                        @endif
                                    </p>
                                </div>

                                <!--  Same Add to Cart button -->
                                <button class="cart-btn" onclick="addToCart({{ $product->id }})">
                                    <i class="fa fa-shopping-bag"></i>
                                </button>
                            </div>
                        </div>

                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
</div>
{{-- END DESKTOP VERSION --}}

{{-- ================================
    MOBILE VERSION
    ================================ --}}
<div class="mobile-only">

    {{-- Mobile Wishlist Header --}}
    <div class="mobile-wishlist-header">
        <h1>{{ __('store.wishlist.title') }}</h1>
        <span class="mobile-wishlist-count">{{ $products->count() }} {{ $products->count() == 1 ? 'item' : 'items' }}</span>
    </div>

    @if($products->isEmpty())
        {{-- Mobile Empty Wishlist --}}
        <div class="mobile-empty-wishlist">
            <i class="fas fa-heart"></i>
            <h2>{{ __('store.wishlist.empty') ?? 'Your wishlist is empty' }}</h2>
            <p>{{ __('store.wishlist.empty_message') ?? 'Save items you love by clicking the heart icon.' }}</p>
            <a href="{{ route('xylo.home') }}">{{ __('store.wishlist.start_shopping') ?? 'Start Shopping' }}</a>
        </div>
    @else
        {{-- Mobile Wishlist Grid --}}
        <div class="mobile-wishlist-grid">
            @foreach ($products as $product)
                @php
                    $imageUrl = optional($product->thumbnail)->image_url ?? 'default.jpg';
                    $isExternal = str_starts_with($imageUrl, 'http://') || str_starts_with($imageUrl, 'https://');
                    $finalImageUrl = $isExternal ? $imageUrl : asset('storage/' . $imageUrl);
                @endphp

                <div class="mobile-wishlist-card" data-product-id="{{ $product->id }}">
                    <div class="mobile-wishlist-image-wrapper">
                        <a href="{{ route('product.show', $product->slug) }}">
                            <img src="{{ $finalImageUrl }}"
                                 alt="{{ $product->translation->name }}"
                                 class="mobile-wishlist-image"
                                 onerror="this.src='{{ asset('images/default-product.png') }}'">
                        </a>
                        <button class="mobile-wishlist-remove mobile-remove-wishlist" data-product-id="{{ $product->id }}">
                            <i class="fas fa-heart"></i>
                        </button>
                    </div>

                    <div class="mobile-wishlist-info">
                        <a href="{{ route('product.show', $product->slug) }}" class="mobile-wishlist-title">
                            {{ $product->translation->name }}
                        </a>

                        <div class="mobile-wishlist-rating">
                            <i class="fa-solid fa-star"></i>
                            <span>({{ $product->reviews_count }} {{ __('store.wishlist.reviews') }})</span>
                        </div>

                        <div class="mobile-wishlist-footer">
                            <div>
                                @if(optional($product->primaryVariant)->converted_discount_price)
                                    <span class="mobile-wishlist-price">{{ $currency->symbol }}{{ $product->primaryVariant->converted_discount_price }}</span>
                                    <span class="mobile-wishlist-original-price">{{ $currency->symbol }}{{ $product->primaryVariant->converted_price }}</span>
                                @else
                                    <span class="mobile-wishlist-price">{{ $currency->symbol }}{{ optional($product->primaryVariant)->converted_price ?? 'N/A' }}</span>
                                @endif
                            </div>
                            <button class="mobile-wishlist-add-cart" onclick="addToCart({{ $product->id }})">
                                <i class="fa fa-shopping-bag"></i>
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

</div>
{{-- END MOBILE VERSION --}}

@endsection

@section('js')
<script>
$(document).on('click', '.wishlist-btn', function () {
    let button = $(this);
    let productId = button.data('product-id');

    $.post('{{ route("customer.wishlist.toggle") }}', {
        _token: '{{ csrf_token() }}',
        product_id: productId
    }, function(res) {
        if (res.status === 'removed') {
            button.closest('.col-md-3').fadeOut();
        }
    });
});
//  Add to Cart
function addToCart(productId) {
    $.ajax({
        url: "{{ route('cart.add') }}",
        method: "POST",
        data: {
            _token: "{{ csrf_token() }}",
            product_id: productId,
            quantity: 1
        },
        success: function(res) {
            if (res.status === 'success') {
                toastr.success(res.message);
            } else {
                toastr.success(res.message);
            }
            // Update cart count badge
            if (res.cart && res.cart_count !== undefined) {
                updateCartCount(res.cart, res.cart_count);
            }
        },
        error: function() {
            toastr.error("Error adding to cart");
        }
    });
}

// Mobile Remove from Wishlist
$(document).on('click', '.mobile-remove-wishlist', function() {
    let button = $(this);
    let productId = button.data('product-id');

    $.post('{{ route("customer.wishlist.toggle") }}', {
        _token: '{{ csrf_token() }}',
        product_id: productId
    }, function(res) {
        if (res.status === 'removed') {
            button.closest('.mobile-wishlist-card').fadeOut(300, function() {
                $(this).remove();
                // Update count
                let count = $('.mobile-wishlist-card:visible').length;
                $('.mobile-wishlist-count').text(count + (count == 1 ? ' item' : ' items'));

                // Show empty state if no items left
                if (count === 0) {
                    location.reload();
                }
            });
            toastr.info('{{ __("store.wishlist.removed") ?? "Removed from wishlist" }}', '', {
                positionClass: "toast-top-center"
            });
        }
    });
});
</script>
@endsection
