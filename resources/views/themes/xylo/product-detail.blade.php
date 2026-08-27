@extends('themes.xylo.layouts.master')

@section('css')
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
<style>
/* Product Detail Page - Simple & Clean */
.modern-breadcrumb {
    padding: 1rem 0;
    background: #f8f9fa;
    border-bottom: 1px solid #dee2e6;
}

.breadcrumb-list {
    list-style: none;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    margin: 0;
    padding: 0;
    flex-wrap: wrap;
}

.breadcrumb-list li {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.breadcrumb-list a {
    color: #6c757d;
    text-decoration: none;
    font-size: 0.9rem;
}

.breadcrumb-list a:hover {
    color: var(--main-color);
}

.breadcrumb-list span {
    color: var(--main-color);
    font-weight: 600;
    font-size: 0.9rem;
}

.breadcrumb-list i {
    font-size: 0.7rem;
    color: #adb5bd;
}

.product-detail-modern {
    padding: 2rem 0;
}

.product-gallery-wrapper {
    position: sticky;
    top: 100px;
}

.main-image-container {
    position: relative;
    background: #f8f9fa;
    border-radius: 12px;
    overflow: hidden;
    margin-bottom: 1rem;
    border: 1px solid #dee2e6;
}

.main-product-image {
    width: 100%;
    height: auto;
    display: block;
}

.image-badge {
    position: absolute;
    top: 1rem;
    left: 1rem;
    background: #dc3545;
    color: white;
    padding: 0.4rem 0.8rem;
    border-radius: 4px;
    font-size: 0.85rem;
    font-weight: 600;
    z-index: 10;
}

.wishlist-btn-modern {
    position: absolute;
    top: 1rem;
    right: 1rem;
    width: 40px;
    height: 40px;
    background: white;
    border: 1px solid #dee2e6;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.2s;
    z-index: 10;
}

.wishlist-btn-modern:hover {
    background: #f8f9fa;
    transform: scale(1.05);
}

.thumbnail-gallery {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(80px, 1fr));
    gap: 0.5rem;
}

.thumbnail-item {
    border: 2px solid transparent;
    border-radius: 8px;
    overflow: hidden;
    cursor: pointer;
    transition: all 0.2s;
}

.thumbnail-item:hover,
.thumbnail-item.active {
    border-color: var(--main-color);
}

.thumbnail-item img {
    width: 100%;
    height: auto;
    display: block;
}

.product-info-modern {
    padding-left: 1.5rem;
}

.stock-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
    padding: 0.4rem 1rem;
    border-radius: 20px;
    font-size: 0.85rem;
    font-weight: 600;
    margin-bottom: 1rem;
}

.stock-badge.in-stock {
    background: #d1f4e0;
    color: #198754;
}

.stock-badge.out-of-stock {
    background: #f8d7da;
    color: #dc3545;
}

.rating-display {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    margin-bottom: 1rem;
}

.stars-wrapper {
    display: flex;
    gap: 0.2rem;
}

.rating-count {
    font-size: 0.9rem;
    color: #6c757d;
}

.product-title-wrapper {
    margin-bottom: 1.5rem;
}

.product-title-modern {
    font-size: 1.75rem;
    font-weight: 700;
    color: #212529;
    margin: 0;
}

.price-section-modern {
    margin-bottom: 1.5rem;
}

.price-wrapper-modern {
    display: flex;
    align-items: center;
    gap: 1rem;
    flex-wrap: wrap;
}

.current-price {
    font-size: 2rem;
    font-weight: 700;
    color: var(--main-color);
}

.original-price {
    font-size: 1.25rem;
    color: #6c757d;
    text-decoration: line-through;
}

.discount-percentage {
    background: #dc3545;
    color: white;
    padding: 0.3rem 0.6rem;
    border-radius: 4px;
    font-size: 0.85rem;
    font-weight: 600;
}

.product-short-description {
    color: #6c757d;
    margin-bottom: 1.5rem;
    line-height: 1.6;
}

.variants-section-modern {
    margin-bottom: 1.5rem;
}

.variant-group {
    margin-bottom: 1.25rem;
}

.variant-label {
    display: block;
    font-weight: 600;
    margin-bottom: 0.75rem;
    color: #212529;
}

.variant-options {
    display: flex;
    gap: 0.75rem;
    flex-wrap: wrap;
}

.color-option input[type="radio"] {
    display: none;
}

.color-option label {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    cursor: pointer;
    border: 2px solid #dee2e6;
    transition: all 0.2s;
    display: block;
}

.color-option input[type="radio"]:checked + label {
    border-color: var(--main-color);
    box-shadow: 0 0 0 3px rgba(0, 0, 0, 0.1);
}

.size-option input[type="radio"] {
    display: none;
}

.size-option label {
    padding: 0.5rem 1.25rem;
    border: 2px solid #dee2e6;
    border-radius: 6px;
    cursor: pointer;
    font-weight: 500;
    transition: all 0.2s;
    display: block;
}

.size-option input[type="radio"]:checked + label {
    background: var(--main-color);
    border-color: var(--main-color);
    color: white;
}

.size-option label:hover {
    border-color: var(--main-color);
}

.quantity-section-modern {
    margin-bottom: 1.5rem;
}

.quantity-label {
    display: block;
    font-weight: 600;
    margin-bottom: 0.75rem;
    color: #212529;
}

.quantity-selector-modern {
    display: inline-flex;
    align-items: center;
    border: 1px solid #dee2e6;
    border-radius: 6px;
    overflow: hidden;
}

.quantity-btn {
    width: 40px;
    height: 40px;
    background: #f8f9fa;
    border: none;
    cursor: pointer;
    font-size: 1.1rem;
    transition: all 0.2s;
}

.quantity-btn:hover {
    background: #e9ecef;
}

.quantity-input {
    width: 50px;
    height: 40px;
    border: none;
    border-left: 1px solid #dee2e6;
    border-right: 1px solid #dee2e6;
    text-align: center;
    font-weight: 600;
}

.action-buttons-modern {
    margin-bottom: 1.5rem;
}

.btn-add-to-cart-modern {
    width: 100%;
    padding: 1rem;
    background: var(--main-color);
    color: white;
    border: none;
    border-radius: 6px;
    font-size: 1rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
}

.btn-add-to-cart-modern:hover {
    opacity: 0.9;
    transform: translateY(-1px);
}

.product-features-modern {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 1rem;
    padding: 1.5rem;
    background: #f8f9fa;
    border-radius: 8px;
}

.product-features-modern .feature-item {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    font-size: 0.9rem;
}

.product-features-modern .feature-item i {
    color: var(--main-color);
}

.product-tabs-modern {
    margin-top: 3rem;
}

.tabs-header-modern {
    display: flex;
    gap: 0.5rem;
    border-bottom: 2px solid #dee2e6;
    margin-bottom: 2rem;
}

.tab-btn-modern {
    padding: 1rem 1.5rem;
    background: none;
    border: none;
    border-bottom: 2px solid transparent;
    cursor: pointer;
    font-weight: 600;
    color: #6c757d;
    transition: all 0.2s;
}

.tab-btn-modern.active {
    color: var(--main-color);
    border-bottom-color: var(--main-color);
}

.tab-pane-modern {
    display: none;
}

.tab-pane-modern.active {
    display: block;
}

.product-description-content {
    line-height: 1.8;
}

.review-summary-modern {
    background: #f8f9fa;
    padding: 2rem;
    border-radius: 8px;
    margin-bottom: 2rem;
}

.review-score-box {
    text-align: center;
    margin-bottom: 1.5rem;
}

.review-score-number {
    font-size: 3rem;
    font-weight: 700;
    color: var(--main-color);
}

.review-score-stars {
    color: #ffc107;
    margin: 0.5rem 0;
}

.review-score-count {
    color: #6c757d;
}

.review-bar-item {
    display: flex;
    align-items: center;
    gap: 1rem;
    margin-bottom: 0.5rem;
}

.review-bar-label {
    min-width: 60px;
    font-size: 0.9rem;
}

.review-bar-track {
    flex: 1;
    height: 8px;
    background: #e9ecef;
    border-radius: 4px;
    overflow: hidden;
}

.review-bar-fill {
    height: 100%;
    background: #ffc107;
}

.review-bar-count {
    min-width: 40px;
    text-align: right;
    font-size: 0.9rem;
    color: #6c757d;
}

.review-form-modern {
    background: #f8f9fa;
    padding: 2rem;
    border-radius: 8px;
    margin-bottom: 2rem;
}

.review-form-title {
    font-size: 1.25rem;
    font-weight: 700;
    margin-bottom: 1.5rem;
}

.star-rating-input {
    display: flex;
    gap: 0.5rem;
    margin-bottom: 1rem;
    font-size: 2rem;
}

.star-rating-input .star {
    color: #dee2e6;
    cursor: pointer;
    transition: color 0.2s;
}

.star-rating-input .star:hover,
.star-rating-input .star.active {
    color: #ffc107;
}

.review-textarea {
    width: 100%;
    padding: 0.75rem;
    border: 1px solid #dee2e6;
    border-radius: 6px;
    margin-bottom: 1rem;
    font-family: inherit;
}

.btn-submit-review {
    padding: 0.75rem 2rem;
    background: var(--main-color);
    color: white;
    border: none;
    border-radius: 6px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s;
}

.btn-submit-review:hover {
    opacity: 0.9;
}

.review-list-modern {
    margin-top: 2rem;
}

.review-item-modern {
    background: #f8f9fa;
    padding: 1.5rem;
    border-radius: 8px;
    margin-bottom: 1rem;
}

.review-header {
    display: flex;
    align-items: center;
    gap: 1rem;
    margin-bottom: 1rem;
}

.review-avatar {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    object-fit: cover;
}

.review-user-info {
    flex: 1;
}

.review-user-name {
    font-weight: 600;
    margin-bottom: 0.25rem;
}

.review-rating-stars {
    color: #ffc107;
    font-size: 0.9rem;
}

.review-date {
    font-size: 0.85rem;
    color: #6c757d;
}

.review-text {
    line-height: 1.6;
    margin: 0;
}

.empty-reviews {
    text-align: center;
    padding: 3rem 1rem;
    color: #6c757d;
}

.empty-reviews i {
    font-size: 3rem;
    margin-bottom: 1rem;
    opacity: 0.5;
}

@media (max-width: 991px) {
    .product-info-modern {
        padding-left: 0;
        margin-top: 2rem;
    }

    .product-gallery-wrapper {
        position: relative;
        top: 0;
    }
}

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

@media (max-width: 767px) {
    .product-title-modern {
        font-size: 1.5rem;
    }

    .current-price {
        font-size: 1.5rem;
    }

    .product-features-modern {
        grid-template-columns: 1fr;
    }

    .tabs-header-modern {
        flex-wrap: wrap;
    }

    .modern-breadcrumb {
        padding: 0.75rem 0;
    }

    .breadcrumb-list {
        gap: 0.35rem;
    }

    .breadcrumb-list a,
    .breadcrumb-list span {
        font-size: 0.8rem;
    }

    .breadcrumb-list i {
        font-size: 0.6rem;
    }

    .product-detail-modern {
        padding: 1.5rem 0;
    }

    .main-image-container {
        border-radius: 10px;
        margin-bottom: 0.75rem;
    }

    .image-badge {
        top: 0.75rem;
        left: 0.75rem;
        padding: 0.3rem 0.6rem;
        font-size: 0.75rem;
    }

    .wishlist-btn-modern {
        width: 36px;
        height: 36px;
        top: 0.75rem;
        right: 0.75rem;
    }

    .thumbnail-gallery {
        grid-template-columns: repeat(auto-fill, minmax(60px, 1fr));
        gap: 0.4rem;
    }

    .thumbnail-item {
        border-radius: 6px;
    }

    .stock-badge {
        padding: 0.3rem 0.75rem;
        font-size: 0.75rem;
        margin-bottom: 0.75rem;
    }

    .rating-display {
        margin-bottom: 0.75rem;
    }

    .stars-wrapper i {
        font-size: 0.9rem;
    }

    .rating-count {
        font-size: 0.8rem;
    }

    .product-title-wrapper {
        margin-bottom: 1rem;
    }

    .price-section-modern {
        margin-bottom: 1rem;
    }

    .original-price {
        font-size: 1rem;
    }

    .discount-percentage {
        padding: 0.2rem 0.5rem;
        font-size: 0.75rem;
    }

    .product-short-description {
        font-size: 0.9rem;
        margin-bottom: 1rem;
    }

    .variants-section-modern {
        margin-bottom: 1rem;
    }

    .variant-label {
        font-size: 0.9rem;
        margin-bottom: 0.5rem;
    }

    .variant-options {
        gap: 0.5rem;
    }

    .color-option label {
        width: 32px;
        height: 32px;
    }

    .size-option label {
        padding: 0.4rem 1rem;
        font-size: 0.85rem;
    }

    .quantity-section-modern {
        margin-bottom: 1rem;
    }

    .quantity-label {
        font-size: 0.9rem;
        margin-bottom: 0.5rem;
    }

    .quantity-btn {
        width: 36px;
        height: 36px;
    }

    .quantity-input {
        width: 45px;
        height: 36px;
    }

    .action-buttons-modern {
        margin-bottom: 1rem;
    }

    .btn-add-to-cart-modern {
        padding: 0.85rem;
        font-size: 0.9rem;
    }

    .product-features-modern {
        padding: 1rem;
        gap: 0.75rem;
    }

    .product-features-modern .feature-item {
        font-size: 0.8rem;
        gap: 0.5rem;
    }

    .product-tabs-modern {
        margin-top: 2rem;
    }

    .tabs-header-modern {
        gap: 0.25rem;
        margin-bottom: 1.5rem;
    }

    .tab-btn-modern {
        padding: 0.75rem 1rem;
        font-size: 0.85rem;
    }

    .review-summary-modern {
        padding: 1.25rem;
        margin-bottom: 1.5rem;
    }

    .review-score-number {
        font-size: 2.5rem;
    }

    .review-form-modern {
        padding: 1.25rem;
    }

    .review-form-title {
        font-size: 1.1rem;
        margin-bottom: 1rem;
    }

    .star-rating-input {
        font-size: 1.5rem;
    }

    .review-item-modern {
        padding: 1rem;
    }

    .review-avatar {
        width: 40px;
        height: 40px;
    }

    .review-user-name {
        font-size: 0.9rem;
    }

    .review-rating-stars {
        font-size: 0.8rem;
    }

    .review-date {
        font-size: 0.75rem;
    }

    .review-text {
        font-size: 0.9rem;
    }
}

/* Small Mobile */
@media (max-width: 480px) {
    .modern-breadcrumb {
        padding: 0.5rem 0;
    }

    .breadcrumb-list a,
    .breadcrumb-list span {
        font-size: 0.7rem;
    }

    .product-detail-modern {
        padding: 1rem 0;
    }

    .product-title-modern {
        font-size: 1.25rem;
    }

    .current-price {
        font-size: 1.25rem;
    }

    .original-price {
        font-size: 0.85rem;
    }

    .thumbnail-gallery {
        grid-template-columns: repeat(5, 1fr);
        gap: 0.3rem;
    }

    .color-option label {
        width: 28px;
        height: 28px;
    }

    .size-option label {
        padding: 0.35rem 0.75rem;
        font-size: 0.8rem;
    }

    .btn-add-to-cart-modern {
        padding: 0.75rem;
        font-size: 0.85rem;
    }

    .product-features-modern {
        padding: 0.75rem;
    }

    .product-features-modern .feature-item {
        font-size: 0.75rem;
    }

    .tabs-header-modern {
        border-bottom-width: 1px;
    }

    .tab-btn-modern {
        padding: 0.6rem 0.75rem;
        font-size: 0.75rem;
        border-bottom-width: 1px;
    }

    .tab-btn-modern i {
        display: none;
    }

    .product-description-content {
        font-size: 0.9rem;
    }

    .review-score-number {
        font-size: 2rem;
    }

    .review-form-modern {
        padding: 1rem;
    }

    .review-form-title {
        font-size: 1rem;
    }

    .star-rating-input {
        font-size: 1.25rem;
    }

    .review-textarea {
        font-size: 0.9rem;
    }

    .btn-submit-review {
        padding: 0.6rem 1.5rem;
        font-size: 0.85rem;
    }

    .review-item-modern {
        padding: 0.75rem;
    }

    .review-header {
        flex-wrap: wrap;
        gap: 0.75rem;
    }

    .review-avatar {
        width: 36px;
        height: 36px;
    }

    .review-text {
        font-size: 0.85rem;
    }

    .empty-reviews {
        padding: 2rem 1rem;
    }

    .empty-reviews i {
        font-size: 2rem;
    }

    .empty-reviews p {
        font-size: 0.9rem;
    }
}

/* ================================
   Mobile Product Detail Styles
   ================================ */

/* Mobile Gallery */
.mobile-gallery-wrapper {
    position: relative;
    background: #fff;
}

.mobile-gallery-slider {
    position: relative;
    overflow: hidden;
}

.mobile-gallery-track {
    display: flex;
    transition: transform 0.3s ease;
}

.mobile-gallery-slide {
    flex: 0 0 100%;
    min-width: 100%;
}

.mobile-gallery-slide img {
    width: 100%;
    height: auto;
    display: block;
}

.mobile-gallery-badges {
    position: absolute;
    top: 12px;
    left: 12px;
    right: 12px;
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    z-index: 10;
}

.mobile-discount-badge {
    background: #dc3545;
    color: white;
    padding: 6px 12px;
    border-radius: 6px;
    font-size: 13px;
    font-weight: 600;
}

.mobile-wishlist-btn {
    width: 40px;
    height: 40px;
    background: white;
    border: none;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    cursor: pointer;
}

.mobile-gallery-dots {
    display: flex;
    justify-content: center;
    gap: 6px;
    padding: 12px 0;
}

.mobile-gallery-dot {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background: #dee2e6;
    cursor: pointer;
    transition: all 0.2s;
}

.mobile-gallery-dot.active {
    background: var(--main-color);
    width: 24px;
    border-radius: 4px;
}

/* Mobile Product Info */
.mobile-product-info {
    padding: 16px;
    background: #fff;
}

.mobile-product-header {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: 12px;
    margin-bottom: 12px;
}

.mobile-product-title {
    font-size: 18px;
    font-weight: 700;
    color: #212529;
    margin: 0;
    line-height: 1.3;
    flex: 1;
}

.mobile-stock-badge {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    padding: 4px 10px;
    border-radius: 20px;
    font-size: 11px;
    font-weight: 600;
    white-space: nowrap;
}

.mobile-stock-badge.in-stock {
    background: #d1f4e0;
    color: #198754;
}

.mobile-stock-badge.out-of-stock {
    background: #f8d7da;
    color: #dc3545;
}

.mobile-price-rating {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 16px;
    flex-wrap: wrap;
    gap: 8px;
}

.mobile-price-wrapper {
    display: flex;
    align-items: baseline;
    gap: 8px;
    flex-wrap: wrap;
}

.mobile-current-price {
    font-size: 24px;
    font-weight: 700;
    color: var(--main-color);
}

.mobile-original-price {
    font-size: 14px;
    color: #6c757d;
    text-decoration: line-through;
}

.mobile-rating {
    display: flex;
    align-items: center;
    gap: 6px;
}

.mobile-rating .stars {
    display: flex;
    gap: 2px;
    color: #ffc107;
    font-size: 12px;
}

.mobile-rating .count {
    font-size: 12px;
    color: #6c757d;
}

.mobile-short-desc {
    font-size: 14px;
    color: #6c757d;
    line-height: 1.5;
    margin-bottom: 16px;
}

/* Mobile Variants */
.mobile-variants-section {
    margin-bottom: 16px;
}

.mobile-variant-group {
    margin-bottom: 12px;
}

.mobile-variant-label {
    display: block;
    font-size: 13px;
    font-weight: 600;
    color: #212529;
    margin-bottom: 8px;
}

.mobile-variant-options {
    display: flex;
    gap: 8px;
    flex-wrap: wrap;
}

.mobile-color-option input[type="radio"] {
    display: none;
}

.mobile-color-option label {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    cursor: pointer;
    border: 2px solid #dee2e6;
    transition: all 0.2s;
    display: block;
}

.mobile-color-option input[type="radio"]:checked + label {
    border-color: var(--main-color);
    box-shadow: 0 0 0 3px rgba(0, 0, 0, 0.1);
}

.mobile-size-option input[type="radio"] {
    display: none;
}

.mobile-size-option label {
    padding: 8px 16px;
    border: 2px solid #dee2e6;
    border-radius: 8px;
    cursor: pointer;
    font-size: 13px;
    font-weight: 500;
    transition: all 0.2s;
    display: block;
}

.mobile-size-option input[type="radio"]:checked + label {
    background: var(--main-color);
    border-color: var(--main-color);
    color: white;
}

/* Mobile Quantity */
.mobile-quantity-section {
    margin-bottom: 16px;
}

.mobile-quantity-selector {
    display: inline-flex;
    align-items: center;
    border: 1px solid #dee2e6;
    border-radius: 8px;
    overflow: hidden;
}

.mobile-qty-btn {
    width: 40px;
    height: 40px;
    background: #f8f9fa;
    border: none;
    cursor: pointer;
    font-size: 18px;
    font-weight: 500;
}

.mobile-qty-input {
    width: 50px;
    height: 40px;
    border: none;
    border-left: 1px solid #dee2e6;
    border-right: 1px solid #dee2e6;
    text-align: center;
    font-weight: 600;
    font-size: 14px;
}

/* Mobile Features */
.mobile-features-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 12px;
    padding: 16px;
    background: #f8f9fa;
    border-radius: 12px;
    margin-bottom: 16px;
}

.mobile-feature-item {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 12px;
    color: #495057;
}

.mobile-feature-item i {
    color: var(--main-color);
    font-size: 14px;
}

/* Mobile Accordion Tabs */
.mobile-accordion-tabs {
    border-top: 1px solid #dee2e6;
}

.mobile-accordion-item {
    border-bottom: 1px solid #dee2e6;
}

.mobile-accordion-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 16px;
    background: #fff;
    cursor: pointer;
}

.mobile-accordion-header h3 {
    font-size: 15px;
    font-weight: 600;
    color: #212529;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 10px;
}

.mobile-accordion-header h3 i {
    color: var(--main-color);
    font-size: 14px;
}

.mobile-accordion-header .toggle-icon {
    transition: transform 0.3s;
}

.mobile-accordion-item.open .mobile-accordion-header .toggle-icon {
    transform: rotate(180deg);
}

.mobile-accordion-content {
    max-height: 0;
    overflow: hidden;
    transition: max-height 0.3s ease;
}

.mobile-accordion-item.open .mobile-accordion-content {
    max-height: 2000px;
}

.mobile-accordion-inner {
    padding: 0 16px 16px;
}

.mobile-description-content {
    font-size: 14px;
    line-height: 1.7;
    color: #495057;
}

/* Mobile Reviews */
.mobile-review-summary {
    background: #f8f9fa;
    border-radius: 12px;
    padding: 16px;
    margin-bottom: 16px;
    text-align: center;
}

.mobile-review-score {
    font-size: 48px;
    font-weight: 700;
    color: var(--main-color);
    line-height: 1;
}

.mobile-review-stars {
    display: flex;
    justify-content: center;
    gap: 4px;
    color: #ffc107;
    margin: 8px 0;
}

.mobile-review-count {
    font-size: 13px;
    color: #6c757d;
}

.mobile-review-bars {
    margin-top: 16px;
}

.mobile-review-bar {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 6px;
    font-size: 12px;
}

.mobile-review-bar-label {
    width: 50px;
    color: #6c757d;
}

.mobile-review-bar-track {
    flex: 1;
    height: 6px;
    background: #e9ecef;
    border-radius: 3px;
    overflow: hidden;
}

.mobile-review-bar-fill {
    height: 100%;
    background: #ffc107;
}

.mobile-review-bar-count {
    width: 30px;
    text-align: right;
    color: #6c757d;
}

.mobile-review-form {
    background: #f8f9fa;
    border-radius: 12px;
    padding: 16px;
    margin-bottom: 16px;
}

.mobile-review-form-title {
    font-size: 15px;
    font-weight: 600;
    margin-bottom: 12px;
}

.mobile-star-rating {
    display: flex;
    gap: 8px;
    margin-bottom: 12px;
    font-size: 28px;
}

.mobile-star-rating .star {
    color: #dee2e6;
    cursor: pointer;
    transition: color 0.2s;
}

.mobile-star-rating .star:hover,
.mobile-star-rating .star.active {
    color: #ffc107;
}

.mobile-review-textarea {
    width: 100%;
    padding: 12px;
    border: 1px solid #dee2e6;
    border-radius: 8px;
    font-size: 14px;
    font-family: inherit;
    margin-bottom: 12px;
    resize: vertical;
}

.mobile-review-submit {
    background: var(--main-color);
    color: white;
    border: none;
    padding: 12px 24px;
    border-radius: 8px;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
}

.mobile-review-list {
    margin-top: 16px;
}

.mobile-review-item {
    background: #f8f9fa;
    border-radius: 12px;
    padding: 14px;
    margin-bottom: 12px;
}

.mobile-review-header {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 10px;
}

.mobile-review-avatar {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    object-fit: cover;
}

.mobile-review-user-info {
    flex: 1;
}

.mobile-review-user-name {
    font-size: 14px;
    font-weight: 600;
    margin-bottom: 2px;
}

.mobile-review-rating {
    display: flex;
    gap: 2px;
    color: #ffc107;
    font-size: 11px;
}

.mobile-review-date {
    font-size: 11px;
    color: #6c757d;
}

.mobile-review-text {
    font-size: 13px;
    line-height: 1.5;
    color: #495057;
    margin: 0;
}

.mobile-empty-reviews {
    text-align: center;
    padding: 24px;
    color: #6c757d;
}

.mobile-empty-reviews i {
    font-size: 32px;
    margin-bottom: 8px;
    opacity: 0.5;
}

.mobile-empty-reviews p {
    font-size: 13px;
    margin: 0;
}

.mobile-login-prompt {
    background: #f8f9fa;
    border-radius: 12px;
    padding: 16px;
    text-align: center;
    font-size: 13px;
}

.mobile-login-prompt a {
    color: var(--main-color);
    font-weight: 600;
    text-decoration: none;
}

/* Sticky Add to Cart Bar */
.mobile-sticky-cart {
    position: fixed;
    bottom: 0;
    left: 0;
    right: 0;
    background: #fff;
    padding: 12px 16px;
    box-shadow: 0 -2px 10px rgba(0,0,0,0.1);
    z-index: 100;
    display: none;
}

@media (max-width: 768px) {
    .mobile-sticky-cart {
        display: flex;
        align-items: center;
        gap: 12px;
    }
}

.mobile-sticky-price {
    flex: 1;
}

.mobile-sticky-price .price {
    font-size: 18px;
    font-weight: 700;
    color: var(--main-color);
}

.mobile-sticky-price .stock {
    font-size: 11px;
    color: #198754;
}

.mobile-sticky-cart-btn {
    flex: 2;
    background: var(--main-color);
    color: white;
    border: none;
    padding: 14px 24px;
    border-radius: 10px;
    font-size: 15px;
    font-weight: 600;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
}

/* Add padding at bottom to account for sticky cart */
.mobile-only.mobile-product-page {
    padding-bottom: 80px;
}

/* Small Mobile Adjustments */
@media (max-width: 480px) {
    .mobile-product-title {
        font-size: 16px;
    }

    .mobile-current-price {
        font-size: 20px;
    }

    .mobile-features-grid {
        gap: 10px;
        padding: 12px;
    }

    .mobile-feature-item {
        font-size: 11px;
    }

    .mobile-accordion-header h3 {
        font-size: 14px;
    }

    .mobile-review-score {
        font-size: 40px;
    }

    .mobile-star-rating {
        font-size: 24px;
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

<!-- Breadcrumb -->
<section class="modern-breadcrumb">
    <div class="container">
        <ul class="breadcrumb-list">
            <li><a href="{{ url('/') }}">{{ __('store.product_detail.home') }}</a></li>
            <li><i class="fas fa-chevron-right"></i></li>
            @foreach($breadcrumbs as $category)
                <li><a href="{{ url('category/' . $category->slug) }}">{{ $category->translation->name ?? $category->slug }}</a></li>
                <li><i class="fas fa-chevron-right"></i></li>
            @endforeach
            <li><span>{{ $product->translation->name }}</span></li>
        </ul>
    </div>
</section>

<!-- Product Detail Section -->
<section class="product-detail-modern">
    <div class="container">
        <div class="row">
            <!-- Product Gallery -->
            <div class="col-lg-6">
                <div class="product-gallery-wrapper">
                    <div class="main-image-container">
                        @if($product->primaryVariant && $product->primaryVariant->discount_price)
                            @php
                                $discount = round((($product->primaryVariant->price - $product->primaryVariant->discount_price) / $product->primaryVariant->price) * 100);
                            @endphp
                            <div class="image-badge">-{{ $discount }}%</div>
                        @endif

                        @auth('customer')
                            @php
                                $isFavorite = auth('customer')->user()->wishlistProducts()->where('product_id', $product->id)->exists();
                            @endphp
                        @else
                            @php $isFavorite = false; @endphp
                        @endauth

                        <button id="test-heart" class="wishlist-btn-modern">
                            <i class="{{ $isFavorite ? 'fa-solid fa-heart text-danger' : 'fa-regular fa-heart text-secondary' }}"></i>
                        </button>

                        @if($product->images->isNotEmpty())
                            @php
                                $firstImage = $product->images->first();
                                $imageUrl = $firstImage->image_url;
                                $isExternal = str_starts_with($imageUrl, 'http://') || str_starts_with($imageUrl, 'https://');
                                $finalImageUrl = $isExternal ? $imageUrl : asset('storage/' . $imageUrl);
                            @endphp
                            <img src="{{ $finalImageUrl }}"
                                 alt="{{ $product->translation->name }}"
                                 class="main-product-image"
                                 id="mainProductImage"
                                 onerror="this.src='https://via.placeholder.com/600x600?text=No+Image';">
                        @else
                            <img src="https://via.placeholder.com/600x600?text=No+Image"
                                 alt="{{ $product->translation->name }}"
                                 class="main-product-image"
                                 id="mainProductImage">
                        @endif
                    </div>

                    @if($product->images->count() > 1)
                        <div class="thumbnail-gallery">
                            @foreach($product->images as $index => $image)
                                @php
                                    $imageUrl = $image->image_url;
                                    $isExternal = str_starts_with($imageUrl, 'http://') || str_starts_with($imageUrl, 'https://');
                                    $finalImageUrl = $isExternal ? $imageUrl : asset('storage/' . $imageUrl);
                                @endphp
                                <div class="thumbnail-item {{ $index === 0 ? 'active' : '' }}"
                                     onclick="changeMainImage('{{ $finalImageUrl }}', this)">
                                    <img src="{{ $finalImageUrl }}"
                                         alt="{{ $product->translation->name }}"
                                         onerror="this.src='https://via.placeholder.com/100x100?text=No+Image';">
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            <!-- Product Info -->
            <div class="col-lg-6">
                <div class="product-info-modern">
                    <!-- Stock Badge -->
                    @if($inStock)
                        <div id="product-stock" class="stock-badge in-stock">
                            <i class="fas fa-check-circle"></i>
                            {{ __('store.product_detail.in_stock') }}
                        </div>
                    @else
                        <div id="product-stock" class="stock-badge out-of-stock">
                            <i class="fas fa-times-circle"></i>
                            OUT OF STOCK
                        </div>
                    @endif

                    <!-- Rating -->
                    @php $averageRating = round($product->reviews_avg_rating, 1); @endphp
                    <div class="rating-display">
                        <div class="stars-wrapper">
                            @for ($i = 1; $i <= 5; $i++)
                                @if ($i <= floor($averageRating))
                                    <i class="fa-solid fa-star" style="color: #ffc107;"></i>
                                @elseif ($i - 0.5 == $averageRating)
                                    <i class="fa-solid fa-star-half-alt" style="color: #ffc107;"></i>
                                @else
                                    <i class="fa-regular fa-star" style="color: #dee2e6;"></i>
                                @endif
                            @endfor
                        </div>
                        <span class="rating-count">({{ $product->reviews_count }} {{ __('store.product_detail.customer_reviews') }})</span>
                    </div>

                    <!-- Title -->
                    <div class="product-title-wrapper">
                        <h1 class="product-title-modern">{{ $product->translation->name }}</h1>
                    </div>

                    <!-- Price -->
                    <div class="price-section-modern">
                        <div class="price-wrapper-modern">
                            <span class="current-price">
                                <span id="currency-symbol">{{ $currency->symbol }}</span><span id="variant-price">{{ number_format($product->primaryVariant->converted_price ?? 0, 2) }}</span>
                            </span>
                            @if($product->primaryVariant && $product->primaryVariant->discount_price)
                                <span class="original-price">{{ $currency->symbol }}{{ number_format($product->primaryVariant->converted_price, 2) }}</span>
                                @php
                                    $discount = round((($product->primaryVariant->price - $product->primaryVariant->discount_price) / $product->primaryVariant->price) * 100);
                                @endphp
                                <span class="discount-percentage">-{{ $discount }}%</span>
                            @endif
                        </div>
                    </div>

                    <!-- Short Description -->
                    @if($product->translation->short_description)
                        <div class="product-short-description">
                            {{ $product->translation->short_description }}
                        </div>
                    @endif

                    <!-- Variants -->
                    @if($product->attributeValues->isNotEmpty())
                        <div class="variants-section-modern" id="product-attributes">
                            @php
                                $groupedAttributes = $product->attributeValues->groupBy(fn($item) => $item->attribute->id);
                            @endphp

                            @foreach ($groupedAttributes as $attributeId => $values)
                                <div class="variant-group">
                                    <label class="variant-label">
                                        {{ __('store.product_detail.' . strtolower($values->first()->attribute->name)) }}
                                    </label>
                                    <div class="variant-options">
                                        @foreach ($values as $index => $value)
                                            @php
                                                $inputId = strtolower($values->first()->attribute->name) . '-' . $index;
                                                $attributeName = strtolower($values->first()->attribute->name);
                                            @endphp

                                            @if($attributeName === 'color')
                                                <div class="color-option">
                                                    <input type="radio"
                                                           name="attribute_{{ $attributeId }}"
                                                           id="{{ $inputId }}"
                                                           value="{{ $value->id }}"
                                                           {{ $index === 0 ? 'checked' : '' }}>
                                                    <label for="{{ $inputId }}"
                                                           style="background-color: {{ strtolower($value->value) }};"></label>
                                                </div>
                                            @else
                                                <div class="size-option">
                                                    <input type="radio"
                                                           name="attribute_{{ $attributeId }}"
                                                           id="{{ $inputId }}"
                                                           value="{{ $value->id }}"
                                                           {{ $index === 0 ? 'checked' : '' }}>
                                                    <label for="{{ $inputId }}">{{ $value->translated_value }}</label>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    <!-- Quantity -->
                    <div class="quantity-section-modern">
                        <label class="quantity-label">{{ __('store.product_detail.quantity') ?? 'Quantity' }}</label>
                        <div class="quantity-selector-modern">
                            <button class="quantity-btn" onclick="changeQty(-1)">−</button>
                            <input type="number" id="qty" value="1" min="1" class="quantity-input" readonly>
                            <button class="quantity-btn" onclick="changeQty(1)">+</button>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="action-buttons-modern">
                        <button class="btn-add-to-cart-modern" onclick="addToCart({{ $product->id }}, '{{ $product->product_type }}')">
                            <i class="fas fa-shopping-cart"></i>
                            {{ __('store.product_detail.add_to_cart') }}
                        </button>
                    </div>

                    <!-- Product Features -->
                    <div class="product-features-modern">
                        <div class="feature-item">
                            <i class="fas fa-shipping-fast"></i>
                            <span>{{ __('store.product_detail.free_shipping') ?? 'Free Shipping' }}</span>
                        </div>
                        <div class="feature-item">
                            <i class="fas fa-undo-alt"></i>
                            <span>{{ __('store.product_detail.easy_returns') ?? 'Easy Returns' }}</span>
                        </div>
                        <div class="feature-item">
                            <i class="fas fa-shield-alt"></i>
                            <span>{{ __('store.product_detail.secure_payment') ?? 'Secure Payment' }}</span>
                        </div>
                        <div class="feature-item">
                            <i class="fas fa-headset"></i>
                            <span>{{ __('store.product_detail.support') ?? '24/7 Support' }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Product Tabs -->
        <div class="product-tabs-modern">
            <div class="tabs-header-modern">
                <button class="tab-btn-modern active" onclick="switchTab('description')">
                    <i class="fas fa-align-left me-2"></i>{{ __('store.product_detail.description') }}
                </button>
                <button class="tab-btn-modern" onclick="switchTab('reviews')">
                    <i class="fas fa-star me-2"></i>{{ __('store.product_detail.reviews') }} ({{ $product->reviews_count }})
                </button>
            </div>

            <div class="tab-content-modern">
                <!-- Description Tab -->
                <div class="tab-pane-modern active" id="description-pane">
                    <div class="product-description-content">
                        {!! \App\Support\HtmlSanitizer::clean($product->translation->description) !!}
                    </div>
                </div>

                <!-- Reviews Tab -->
                <div class="tab-pane-modern" id="reviews-pane">
                    @if($product->reviews_count > 0)
                        <!-- Review Summary -->
                        <div class="review-summary-modern">
                            <div class="review-score-box">
                                <div class="review-score-number">{{ number_format($averageRating, 1) }}</div>
                                <div class="review-score-stars">
                                    @for ($i = 1; $i <= 5; $i++)
                                        @if ($i <= floor($averageRating))
                                            <i class="fa-solid fa-star"></i>
                                        @elseif ($i - 0.5 == $averageRating)
                                            <i class="fa-solid fa-star-half-alt"></i>
                                        @else
                                            <i class="fa-regular fa-star"></i>
                                        @endif
                                    @endfor
                                </div>
                                <div class="review-score-count">{{ $product->reviews_count }} {{ __('store.product_detail.customer_reviews') }}</div>
                            </div>

                            <div class="review-bars-section">
                                @php
                                    $ratingCounts = [5 => 0, 4 => 0, 3 => 0, 2 => 0, 1 => 0];
                                    foreach($product->reviews as $review) {
                                        if($review->is_approved && isset($ratingCounts[$review->rating])) {
                                            $ratingCounts[$review->rating]++;
                                        }
                                    }
                                @endphp
                                @for($i = 5; $i >= 1; $i--)
                                    @php
                                        $percentage = $product->reviews_count > 0 ? ($ratingCounts[$i] / $product->reviews_count) * 100 : 0;
                                    @endphp
                                    <div class="review-bar-item">
                                        <span class="review-bar-label">{{ $i }} {{ __('store.product_detail.star') ?? 'Star' }}</span>
                                        <div class="review-bar-track">
                                            <div class="review-bar-fill" style="width: {{ $percentage }}%;"></div>
                                        </div>
                                        <span class="review-bar-count">{{ $ratingCounts[$i] }}</span>
                                    </div>
                                @endfor
                            </div>
                        </div>
                    @endif

                    <!-- Review Form -->
                    @auth('customer')
                        <div class="review-form-modern">
                            <h3 class="review-form-title">{{ __('store.product_detail.submit_review_title') }}</h3>
                            <form action="{{ route('review.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <input type="hidden" name="rating" id="rating-value" required>

                                <div class="star-rating-input" id="starWrapper">
                                    <span class="star" data-value="1">★</span>
                                    <span class="star" data-value="2">★</span>
                                    <span class="star" data-value="3">★</span>
                                    <span class="star" data-value="4">★</span>
                                    <span class="star" data-value="5">★</span>
                                </div>

                                <textarea name="review"
                                          class="review-textarea"
                                          placeholder="{{ __('store.product_detail.review_optional') }}"
                                          rows="4"></textarea>

                                <button type="submit" class="btn-submit-review">
                                    {{ __('store.product_detail.submit_review_btn') }}
                                </button>
                            </form>
                        </div>
                    @else
                        <div class="review-form-modern">
                            <p>{{ __('store.product_detail.please') }} <a href="{{ route('customer.login') }}" style="color: var(--main-color); font-weight: 600;">{{ __('store.product_detail.login') }}</a> {{ __('store.product_detail.submit') }}</p>
                        </div>
                    @endauth

                    <!-- Review List -->
                    @if($product->reviews->where('is_approved', true)->isNotEmpty())
                        <div class="review-list-modern">
                            @foreach($product->reviews as $review)
                                @if($review->is_approved)
                                    <div class="review-item-modern">
                                        <div class="review-header">
                                            <img src="{{ $review->customer->profile_image ? asset('storage/' . $review->customer->profile_image) : 'https://ui-avatars.com/api/?name=' . urlencode($review->customer->name) . '&background=0D8ABC&color=fff&size=70' }}"
                                                 alt="{{ $review->customer->name }}"
                                                 class="review-avatar">
                                            <div class="review-user-info">
                                                <div class="review-user-name">{{ ucwords($review->customer->name) }}</div>
                                                <div class="review-rating-stars">
                                                    @for($i = 1; $i <= 5; $i++)
                                                        <i class="fa{{ $i <= $review->rating ? 's' : 'r' }} fa-star"></i>
                                                    @endfor
                                                </div>
                                            </div>
                                            <span class="review-date">
                                                @php
                                                    $diffInDays = \Carbon\Carbon::parse($review->created_at)->diffInDays(\Carbon\Carbon::now());
                                                @endphp
                                                {{ $diffInDays }} {{ $diffInDays == 1 ? __('store.product_detail.day') : __('store.product_detail.days') }} {{ __('store.product_detail.ago') }}
                                            </span>
                                        </div>
                                        @if($review->review)
                                            <p class="review-text">{{ $review->review }}</p>
                                        @else
                                            <p class="review-text" style="color: #adb5bd; font-style: italic;">{{ __('store.product_detail.no_review_text') }}</p>
                                        @endif
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    @else
                        <div class="empty-reviews">
                            <i class="fas fa-comments"></i>
                            <p>{{ __('store.product_detail.no_reviews_yet') }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>

</div>
{{-- END DESKTOP VERSION --}}

{{-- ================================
    MOBILE VERSION
    ================================ --}}
<div class="mobile-only mobile-product-page">

    {{-- Mobile Gallery --}}
    <div class="mobile-gallery-wrapper">
        <div class="mobile-gallery-slider">
            <div class="mobile-gallery-badges">
                @if($product->primaryVariant && $product->primaryVariant->discount_price)
                    @php
                        $discount = round((($product->primaryVariant->price - $product->primaryVariant->discount_price) / $product->primaryVariant->price) * 100);
                    @endphp
                    <span class="mobile-discount-badge">-{{ $discount }}%</span>
                @else
                    <span></span>
                @endif

                @auth('customer')
                    @php
                        $isFavorite = auth('customer')->user()->wishlistProducts()->where('product_id', $product->id)->exists();
                    @endphp
                @else
                    @php $isFavorite = false; @endphp
                @endauth

                <button class="mobile-wishlist-btn" id="mobile-wishlist-btn">
                    <i class="{{ $isFavorite ? 'fa-solid fa-heart text-danger' : 'fa-regular fa-heart text-secondary' }}"></i>
                </button>
            </div>

            <div class="mobile-gallery-track" id="mobileGalleryTrack">
                @if($product->images->isNotEmpty())
                    @foreach($product->images as $image)
                        @php
                            $imageUrl = $image->image_url;
                            $isExternal = str_starts_with($imageUrl, 'http://') || str_starts_with($imageUrl, 'https://');
                            $finalImageUrl = $isExternal ? $imageUrl : asset('storage/' . $imageUrl);
                        @endphp
                        <div class="mobile-gallery-slide">
                            <img src="{{ $finalImageUrl }}"
                                 alt="{{ $product->translation->name }}"
                                 onerror="this.src='https://via.placeholder.com/600x600?text=No+Image';">
                        </div>
                    @endforeach
                @else
                    <div class="mobile-gallery-slide">
                        <img src="https://via.placeholder.com/600x600?text=No+Image"
                             alt="{{ $product->translation->name }}">
                    </div>
                @endif
            </div>
        </div>

        @if($product->images->count() > 1)
            <div class="mobile-gallery-dots" id="mobileGalleryDots">
                @foreach($product->images as $index => $image)
                    <span class="mobile-gallery-dot {{ $index === 0 ? 'active' : '' }}" data-index="{{ $index }}"></span>
                @endforeach
            </div>
        @endif
    </div>

    {{-- Mobile Product Info --}}
    <div class="mobile-product-info">
        <div class="mobile-product-header">
            <h1 class="mobile-product-title">{{ $product->translation->name }}</h1>
            @if($inStock)
                <span id="mobile-product-stock" class="mobile-stock-badge in-stock">
                    <i class="fas fa-check"></i> {{ __('store.product_detail.in_stock') }}
                </span>
            @else
                <span id="mobile-product-stock" class="mobile-stock-badge out-of-stock">
                    <i class="fas fa-times"></i> {{ __('store.product_detail.out_of_stock') ?? 'Out of Stock' }}
                </span>
            @endif
        </div>

        <div class="mobile-price-rating">
            <div class="mobile-price-wrapper">
                <span class="mobile-current-price">
                    <span id="mobile-currency-symbol">{{ $currency->symbol }}</span><span id="mobile-variant-price">{{ number_format($product->primaryVariant->converted_price ?? 0, 2) }}</span>
                </span>
                @if($product->primaryVariant && $product->primaryVariant->discount_price)
                    <span class="mobile-original-price">{{ $currency->symbol }}{{ number_format($product->primaryVariant->converted_price, 2) }}</span>
                @endif
            </div>
            <div class="mobile-rating">
                @php $averageRating = round($product->reviews_avg_rating, 1); @endphp
                <div class="stars">
                    @for ($i = 1; $i <= 5; $i++)
                        @if ($i <= floor($averageRating))
                            <i class="fa-solid fa-star"></i>
                        @elseif ($i - 0.5 == $averageRating)
                            <i class="fa-solid fa-star-half-alt"></i>
                        @else
                            <i class="fa-regular fa-star"></i>
                        @endif
                    @endfor
                </div>
                <span class="count">({{ $product->reviews_count }})</span>
            </div>
        </div>

        @if($product->translation->short_description)
            <p class="mobile-short-desc">{{ $product->translation->short_description }}</p>
        @endif

        {{-- Mobile Variants --}}
        @if($product->attributeValues->isNotEmpty())
            <div class="mobile-variants-section" id="mobile-product-attributes">
                @php
                    $groupedAttributes = $product->attributeValues->groupBy(fn($item) => $item->attribute->id);
                @endphp

                @foreach ($groupedAttributes as $attributeId => $values)
                    <div class="mobile-variant-group">
                        <label class="mobile-variant-label">
                            {{ __('store.product_detail.' . strtolower($values->first()->attribute->name)) }}
                        </label>
                        <div class="mobile-variant-options">
                            @foreach ($values as $index => $value)
                                @php
                                    $inputId = 'mobile-' . strtolower($values->first()->attribute->name) . '-' . $index;
                                    $attributeName = strtolower($values->first()->attribute->name);
                                @endphp

                                @if($attributeName === 'color')
                                    <div class="mobile-color-option">
                                        <input type="radio"
                                               name="mobile_attribute_{{ $attributeId }}"
                                               id="{{ $inputId }}"
                                               value="{{ $value->id }}"
                                               {{ $index === 0 ? 'checked' : '' }}>
                                        <label for="{{ $inputId }}"
                                               style="background-color: {{ strtolower($value->value) }};"></label>
                                    </div>
                                @else
                                    <div class="mobile-size-option">
                                        <input type="radio"
                                               name="mobile_attribute_{{ $attributeId }}"
                                               id="{{ $inputId }}"
                                               value="{{ $value->id }}"
                                               {{ $index === 0 ? 'checked' : '' }}>
                                        <label for="{{ $inputId }}">{{ $value->translated_value }}</label>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        {{-- Mobile Quantity --}}
        <div class="mobile-quantity-section">
            <label class="mobile-variant-label">{{ __('store.product_detail.quantity') ?? 'Quantity' }}</label>
            <div class="mobile-quantity-selector">
                <button class="mobile-qty-btn" onclick="mobileChangeQty(-1)">−</button>
                <input type="number" id="mobile-qty" value="1" min="1" class="mobile-qty-input" readonly>
                <button class="mobile-qty-btn" onclick="mobileChangeQty(1)">+</button>
            </div>
        </div>

        {{-- Mobile Features --}}
        <div class="mobile-features-grid">
            <div class="mobile-feature-item">
                <i class="fas fa-shipping-fast"></i>
                <span>{{ __('store.product_detail.free_shipping') ?? 'Free Shipping' }}</span>
            </div>
            <div class="mobile-feature-item">
                <i class="fas fa-undo-alt"></i>
                <span>{{ __('store.product_detail.easy_returns') ?? 'Easy Returns' }}</span>
            </div>
            <div class="mobile-feature-item">
                <i class="fas fa-shield-alt"></i>
                <span>{{ __('store.product_detail.secure_payment') ?? 'Secure Payment' }}</span>
            </div>
            <div class="mobile-feature-item">
                <i class="fas fa-headset"></i>
                <span>{{ __('store.product_detail.support') ?? '24/7 Support' }}</span>
            </div>
        </div>
    </div>

    {{-- Mobile Accordion Tabs --}}
    <div class="mobile-accordion-tabs">
        {{-- Description --}}
        <div class="mobile-accordion-item open">
            <div class="mobile-accordion-header" onclick="toggleMobileAccordion(this)">
                <h3><i class="fas fa-align-left"></i> {{ __('store.product_detail.description') }}</h3>
                <i class="fas fa-chevron-down toggle-icon"></i>
            </div>
            <div class="mobile-accordion-content">
                <div class="mobile-accordion-inner">
                    <div class="mobile-description-content">
                        {!! \App\Support\HtmlSanitizer::clean($product->translation->description) !!}
                    </div>
                </div>
            </div>
        </div>

        {{-- Reviews --}}
        <div class="mobile-accordion-item">
            <div class="mobile-accordion-header" onclick="toggleMobileAccordion(this)">
                <h3><i class="fas fa-star"></i> {{ __('store.product_detail.reviews') }} ({{ $product->reviews_count }})</h3>
                <i class="fas fa-chevron-down toggle-icon"></i>
            </div>
            <div class="mobile-accordion-content">
                <div class="mobile-accordion-inner">
                    @if($product->reviews_count > 0)
                        {{-- Review Summary --}}
                        <div class="mobile-review-summary">
                            <div class="mobile-review-score">{{ number_format($averageRating, 1) }}</div>
                            <div class="mobile-review-stars">
                                @for ($i = 1; $i <= 5; $i++)
                                    @if ($i <= floor($averageRating))
                                        <i class="fa-solid fa-star"></i>
                                    @elseif ($i - 0.5 == $averageRating)
                                        <i class="fa-solid fa-star-half-alt"></i>
                                    @else
                                        <i class="fa-regular fa-star"></i>
                                    @endif
                                @endfor
                            </div>
                            <div class="mobile-review-count">{{ $product->reviews_count }} {{ __('store.product_detail.customer_reviews') }}</div>

                            <div class="mobile-review-bars">
                                @php
                                    $ratingCounts = [5 => 0, 4 => 0, 3 => 0, 2 => 0, 1 => 0];
                                    foreach($product->reviews as $review) {
                                        if($review->is_approved && isset($ratingCounts[$review->rating])) {
                                            $ratingCounts[$review->rating]++;
                                        }
                                    }
                                @endphp
                                @for($i = 5; $i >= 1; $i--)
                                    @php
                                        $percentage = $product->reviews_count > 0 ? ($ratingCounts[$i] / $product->reviews_count) * 100 : 0;
                                    @endphp
                                    <div class="mobile-review-bar">
                                        <span class="mobile-review-bar-label">{{ $i }} {{ __('store.product_detail.star') ?? 'Star' }}</span>
                                        <div class="mobile-review-bar-track">
                                            <div class="mobile-review-bar-fill" style="width: {{ $percentage }}%;"></div>
                                        </div>
                                        <span class="mobile-review-bar-count">{{ $ratingCounts[$i] }}</span>
                                    </div>
                                @endfor
                            </div>
                        </div>
                    @endif

                    {{-- Review Form --}}
                    @auth('customer')
                        <div class="mobile-review-form">
                            <h4 class="mobile-review-form-title">{{ __('store.product_detail.submit_review_title') }}</h4>
                            <form action="{{ route('review.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <input type="hidden" name="rating" id="mobile-rating-value" required>

                                <div class="mobile-star-rating" id="mobileStarWrapper">
                                    <span class="star" data-value="1">★</span>
                                    <span class="star" data-value="2">★</span>
                                    <span class="star" data-value="3">★</span>
                                    <span class="star" data-value="4">★</span>
                                    <span class="star" data-value="5">★</span>
                                </div>

                                <textarea name="review"
                                          class="mobile-review-textarea"
                                          placeholder="{{ __('store.product_detail.review_optional') }}"
                                          rows="3"></textarea>

                                <button type="submit" class="mobile-review-submit">
                                    {{ __('store.product_detail.submit_review_btn') }}
                                </button>
                            </form>
                        </div>
                    @else
                        <div class="mobile-login-prompt">
                            <p>{{ __('store.product_detail.please') }} <a href="{{ route('customer.login') }}">{{ __('store.product_detail.login') }}</a> {{ __('store.product_detail.submit') }}</p>
                        </div>
                    @endauth

                    {{-- Review List --}}
                    @if($product->reviews->where('is_approved', true)->isNotEmpty())
                        <div class="mobile-review-list">
                            @foreach($product->reviews as $review)
                                @if($review->is_approved)
                                    <div class="mobile-review-item">
                                        <div class="mobile-review-header">
                                            <img src="{{ $review->customer->profile_image ? asset('storage/' . $review->customer->profile_image) : 'https://ui-avatars.com/api/?name=' . urlencode($review->customer->name) . '&background=0D8ABC&color=fff&size=70' }}"
                                                 alt="{{ $review->customer->name }}"
                                                 class="mobile-review-avatar">
                                            <div class="mobile-review-user-info">
                                                <div class="mobile-review-user-name">{{ ucwords($review->customer->name) }}</div>
                                                <div class="mobile-review-rating">
                                                    @for($i = 1; $i <= 5; $i++)
                                                        <i class="fa{{ $i <= $review->rating ? 's' : 'r' }} fa-star"></i>
                                                    @endfor
                                                </div>
                                            </div>
                                            <span class="mobile-review-date">
                                                @php
                                                    $diffInDays = \Carbon\Carbon::parse($review->created_at)->diffInDays(\Carbon\Carbon::now());
                                                @endphp
                                                {{ $diffInDays }}{{ $diffInDays == 1 ? 'd' : 'd' }}
                                            </span>
                                        </div>
                                        @if($review->review)
                                            <p class="mobile-review-text">{{ $review->review }}</p>
                                        @else
                                            <p class="mobile-review-text" style="color: #adb5bd; font-style: italic;">{{ __('store.product_detail.no_review_text') }}</p>
                                        @endif
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    @else
                        <div class="mobile-empty-reviews">
                            <i class="fas fa-comments"></i>
                            <p>{{ __('store.product_detail.no_reviews_yet') }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

</div>
{{-- END MOBILE VERSION --}}

{{-- Mobile Sticky Add to Cart --}}
<div class="mobile-sticky-cart">
    <div class="mobile-sticky-price">
        <div class="price">
            <span id="mobile-sticky-currency">{{ $currency->symbol }}</span><span id="mobile-sticky-price">{{ number_format($product->primaryVariant->converted_price ?? 0, 2) }}</span>
        </div>
        @if($inStock)
            <div class="stock" id="mobile-sticky-stock">{{ __('store.product_detail.in_stock') }}</div>
        @else
            <div class="stock" id="mobile-sticky-stock" style="color: #dc3545;">{{ __('store.product_detail.out_of_stock') ?? 'Out of Stock' }}</div>
        @endif
    </div>
    <button class="mobile-sticky-cart-btn" onclick="mobileAddToCart({{ $product->id }}, '{{ $product->product_type }}')">
        <i class="fas fa-shopping-cart"></i>
        {{ __('store.product_detail.add_to_cart') }}
    </button>
</div>

@endsection

@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script>
// Change Main Image
function changeMainImage(imageUrl, thumbnail) {
    document.getElementById('mainProductImage').src = imageUrl;

    // Remove active class from all thumbnails
    document.querySelectorAll('.thumbnail-item').forEach(item => {
        item.classList.remove('active');
    });

    // Add active class to clicked thumbnail
    thumbnail.classList.add('active');
}

// Switch Tabs
function switchTab(tabName) {
    // Remove active class from all buttons and panes
    document.querySelectorAll('.tab-btn-modern').forEach(btn => btn.classList.remove('active'));
    document.querySelectorAll('.tab-pane-modern').forEach(pane => pane.classList.remove('active'));

    // Add active class to clicked button and corresponding pane
    event.target.closest('.tab-btn-modern').classList.add('active');
    document.getElementById(tabName + '-pane').classList.add('active');
}

// Quantity Functions
function changeQty(amount) {
    let qtyInput = document.getElementById("qty");
    let currentQty = parseInt(qtyInput.value);
    let newQty = currentQty + amount;

    if (newQty < 1) newQty = 1;
    qtyInput.value = newQty;
}

// Wishlist Toggle
$(document).ready(function() {
    $('#test-heart').on('click', function() {
        var button = $(this);
        var icon = button.find('i');
        var productId = {{ $product->id }};

        $.ajax({
            url: '{{ route("customer.wishlist.toggle") }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                product_id: productId
            },
            success: function(response) {
                if(response.status === 'added') {
                    icon.removeClass('fa-regular text-secondary').addClass('fa-solid text-danger');
                    toastr.success(response.message || 'Added to favorites ❤️');
                } else if(response.status === 'removed') {
                    icon.removeClass('fa-solid text-danger').addClass('fa-regular text-secondary');
                    toastr.info(response.message || 'Removed from favorites 💔');
                }
            },
            error: function(xhr) {
                if(xhr.status === 401) {
                    toastr.warning('{{ __('store.product_detail.login_to_wishlist') }}');
                } else {
                    toastr.error('Something went wrong.');
                }
            }
        });
    });
});

// Star Rating Input
document.addEventListener('DOMContentLoaded', function () {
    const stars = document.querySelectorAll('#starWrapper .star');
    const ratingInput = document.getElementById('rating-value');

    stars.forEach(star => {
        star.addEventListener('mouseover', function () {
            const val = parseInt(this.dataset.value);
            stars.forEach(s => {
                if(parseInt(s.dataset.value) <= val) {
                    s.classList.add('active');
                } else {
                    s.classList.remove('active');
                }
            });
        });

        star.addEventListener('mouseout', function () {
            const currentRating = parseInt(ratingInput.value) || 0;
            stars.forEach(s => {
                if(parseInt(s.dataset.value) <= currentRating) {
                    s.classList.add('active');
                } else {
                    s.classList.remove('active');
                }
            });
        });

        star.addEventListener('click', function () {
            const val = parseInt(this.dataset.value);
            ratingInput.value = val;
            stars.forEach(s => {
                if(parseInt(s.dataset.value) <= val) {
                    s.classList.add('active');
                } else {
                    s.classList.remove('active');
                }
            });
        });
    });
});

// Toastr Messages
@if(Session::has('success'))
    toastr.success("{{ session('success') }}");
@endif

@if(Session::has('error'))
    toastr.error("{{ session('error') }}");
@endif

// Variant Selection
const variantMap = @json($variantMap);

$(document).ready(function () {
    const productId = {{ $product->id }};

    function getSelectedAttributeValueIds() {
        let selected = [];
        $('#product-attributes input[type="radio"]:checked').each(function () {
            selected.push(parseInt($(this).val()));
        });
        return selected.sort((a, b) => a - b);
    }

    function findMatchingVariantId(selectedAttrIds) {
        for (const variant of variantMap) {
            const variantAttrIds = variant.attributes.slice().sort((a, b) => a - b);
            if (JSON.stringify(variantAttrIds) === JSON.stringify(selectedAttrIds)) {
                return variant.id;
            }
        }
        return null;
    }

    $('input[type="radio"]').on('change', function () {
        const selectedAttrIds = getSelectedAttributeValueIds();
        const variantId = findMatchingVariantId(selectedAttrIds);

        if (!variantId) {
            toastr.warning('Selected variant not available.');
            return;
        }

        $.ajax({
            url: '/get-variant-price',
            type: 'GET',
            data: {
                variant_id: variantId,
                product_id: productId
            },
            success: function (response) {
                if (response.success) {
                    $('#variant-price').text(response.price);
                    $('#product-stock').text(response.stock);
                    $('#currency-symbol').text(response.currency_symbol);

                    if (response.is_out_of_stock) {
                        $('#product-stock').removeClass('stock-badge in-stock').addClass('stock-badge out-of-stock');
                    } else {
                        $('#product-stock').removeClass('stock-badge out-of-stock').addClass('stock-badge in-stock');
                    }
                }
            },
            error: function () {
                toastr.error('Something went wrong. Please try again.');
            }
        });
    });

    // Trigger change on load to set default variant
    $('input[type="radio"]:checked').trigger('change');
});

// Add to Cart
function addToCart(productId, product_type) {
    const quantity = parseInt(document.getElementById("qty").value);
    const attributeInputs = document.querySelectorAll('#product-attributes input[type="radio"]:checked');

    let selectedAttributes = [];
    attributeInputs.forEach(input => {
        selectedAttributes.push(parseInt(input.value));
    });

    fetch("{{ route('cart.add') }}", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": "{{ csrf_token() }}"
        },
        body: JSON.stringify({
            product_id: productId,
            quantity: quantity,
            attribute_value_ids: selectedAttributes,
            product_type: product_type
        })
    })
    .then(response => response.json())
    .then(data => {
        toastr.success(data.message);
        updateCartCount(data.cart, data.cart_count);
    })
    .catch(error => {
        console.error("Error:", error);
        toastr.error('Failed to add to cart');
    });
}

function updateCartCount(cart) {
    let totalCount = Object.values(cart).reduce((sum, item) => sum + item.quantity, 0);
    const cartCountEl = document.getElementById("cart-count");
    if(cartCountEl) {
        cartCountEl.textContent = totalCount;
    }
}

// ================================
// MOBILE SPECIFIC FUNCTIONS
// ================================

// Mobile Gallery Slider
let mobileCurrentSlide = 0;
const mobileGalleryTrack = document.getElementById('mobileGalleryTrack');
const mobileGalleryDots = document.querySelectorAll('.mobile-gallery-dot');
const totalSlides = document.querySelectorAll('.mobile-gallery-slide').length;

function updateMobileGallery(index) {
    if (mobileGalleryTrack) {
        mobileGalleryTrack.style.transform = `translateX(-${index * 100}%)`;
    }
    mobileGalleryDots.forEach((dot, i) => {
        dot.classList.toggle('active', i === index);
    });
    mobileCurrentSlide = index;
}

// Touch swipe for gallery
if (mobileGalleryTrack) {
    let touchStartX = 0;
    let touchEndX = 0;

    mobileGalleryTrack.addEventListener('touchstart', (e) => {
        touchStartX = e.changedTouches[0].screenX;
    }, { passive: true });

    mobileGalleryTrack.addEventListener('touchend', (e) => {
        touchEndX = e.changedTouches[0].screenX;
        handleSwipe();
    }, { passive: true });

    function handleSwipe() {
        const swipeThreshold = 50;
        const diff = touchStartX - touchEndX;

        if (Math.abs(diff) > swipeThreshold) {
            if (diff > 0 && mobileCurrentSlide < totalSlides - 1) {
                updateMobileGallery(mobileCurrentSlide + 1);
            } else if (diff < 0 && mobileCurrentSlide > 0) {
                updateMobileGallery(mobileCurrentSlide - 1);
            }
        }
    }
}

// Dot click handlers
mobileGalleryDots.forEach((dot, index) => {
    dot.addEventListener('click', () => {
        updateMobileGallery(index);
    });
});

// Mobile Quantity
function mobileChangeQty(amount) {
    let qtyInput = document.getElementById("mobile-qty");
    let currentQty = parseInt(qtyInput.value);
    let newQty = currentQty + amount;

    if (newQty < 1) newQty = 1;
    qtyInput.value = newQty;
}

// Mobile Accordion
function toggleMobileAccordion(header) {
    const item = header.parentElement;
    item.classList.toggle('open');
}

// Mobile Wishlist
$('#mobile-wishlist-btn').on('click', function() {
    var button = $(this);
    var icon = button.find('i');
    var productId = {{ $product->id }};

    $.ajax({
        url: '{{ route("customer.wishlist.toggle") }}',
        method: 'POST',
        data: {
            _token: '{{ csrf_token() }}',
            product_id: productId
        },
        success: function(response) {
            if(response.status === 'added') {
                icon.removeClass('fa-regular text-secondary').addClass('fa-solid text-danger');
                toastr.success(response.message || 'Added to favorites ❤️');
            } else if(response.status === 'removed') {
                icon.removeClass('fa-solid text-danger').addClass('fa-regular text-secondary');
                toastr.info(response.message || 'Removed from favorites 💔');
            }
        },
        error: function(xhr) {
            if(xhr.status === 401) {
                toastr.warning('{{ __('store.product_detail.login_to_wishlist') }}');
            } else {
                toastr.error('Something went wrong.');
            }
        }
    });
});

// Mobile Star Rating
const mobileStars = document.querySelectorAll('#mobileStarWrapper .star');
const mobileRatingInput = document.getElementById('mobile-rating-value');

if (mobileStars.length > 0 && mobileRatingInput) {
    mobileStars.forEach(star => {
        star.addEventListener('click', function() {
            const val = parseInt(this.dataset.value);
            mobileRatingInput.value = val;
            mobileStars.forEach(s => {
                s.classList.toggle('active', parseInt(s.dataset.value) <= val);
            });
        });
    });
}

// Mobile Variant Selection
$('#mobile-product-attributes input[type="radio"]').on('change', function() {
    const selectedAttrIds = getMobileSelectedAttributeValueIds();
    const variantId = findMatchingVariantId(selectedAttrIds);

    if (!variantId) {
        toastr.warning('Selected variant not available.');
        return;
    }

    $.ajax({
        url: '/get-variant-price',
        type: 'GET',
        data: {
            variant_id: variantId,
            product_id: {{ $product->id }}
        },
        success: function(response) {
            if (response.success) {
                // Update mobile price displays
                $('#mobile-variant-price').text(response.price);
                $('#mobile-sticky-price').text(response.price);
                $('#mobile-currency-symbol').text(response.currency_symbol);
                $('#mobile-sticky-currency').text(response.currency_symbol);

                // Update mobile stock badge
                if (response.is_out_of_stock) {
                    $('#mobile-product-stock').removeClass('in-stock').addClass('out-of-stock')
                        .html('<i class="fas fa-times"></i> Out of Stock');
                    $('#mobile-sticky-stock').css('color', '#dc3545').text('Out of Stock');
                } else {
                    $('#mobile-product-stock').removeClass('out-of-stock').addClass('in-stock')
                        .html('<i class="fas fa-check"></i> ' + response.stock);
                    $('#mobile-sticky-stock').css('color', '#198754').text(response.stock);
                }
            }
        },
        error: function() {
            toastr.error('Something went wrong. Please try again.');
        }
    });
});

function getMobileSelectedAttributeValueIds() {
    let selected = [];
    $('#mobile-product-attributes input[type="radio"]:checked').each(function() {
        selected.push(parseInt($(this).val()));
    });
    return selected.sort((a, b) => a - b);
}

// Mobile Add to Cart
function mobileAddToCart(productId, product_type) {
    const quantity = parseInt(document.getElementById("mobile-qty").value);
    const attributeInputs = document.querySelectorAll('#mobile-product-attributes input[type="radio"]:checked');

    let selectedAttributes = [];
    attributeInputs.forEach(input => {
        selectedAttributes.push(parseInt(input.value));
    });

    fetch("{{ route('cart.add') }}", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": "{{ csrf_token() }}"
        },
        body: JSON.stringify({
            product_id: productId,
            quantity: quantity,
            attribute_value_ids: selectedAttributes,
            product_type: product_type
        })
    })
    .then(response => response.json())
    .then(data => {
        toastr.success(data.message);
        updateCartCount(data.cart, data.cart_count);
    })
    .catch(error => {
        console.error("Error:", error);
        toastr.error('Failed to add to cart');
    });
}

// Trigger mobile variant change on load
$('#mobile-product-attributes input[type="radio"]:checked').first().trigger('change');
</script>
@endsection
