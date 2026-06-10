/* ============================================
   ULTRA MODERN SEARCH BAR - COMPLETELY REDESIGNED
   ============================================ */

.ultra-modern-search {
    position: relative;
    max-width: 750px;
    margin: 0 auto;
}

.search-wrapper {
    position: relative;
    display: flex;
    align-items: center;
    background: linear-gradient(145deg, #ffffff 0%, #f8fafc 100%);
    border: 2px solid transparent;
    border-radius: 50px;
    padding: 8px;
    gap: 12px;
    box-shadow:
        0 10px 40px rgba(0, 0, 0, 0.08),
        inset 0 1px 0 rgba(255, 255, 255, 0.8);
    transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
}

.search-wrapper:hover {
    box-shadow:
        0 15px 50px rgba(0, 0, 0, 0.12),
        inset 0 1px 0 rgba(255, 255, 255, 0.9),
        0 0 0 4px color-mix(in srgb, var(--main-color) 10%, transparent);
    border-color: color-mix(in srgb, var(--main-color) 30%, transparent);
}

.search-wrapper:focus-within {
    background: #ffffff;
    box-shadow:
        0 20px 60px color-mix(in srgb, var(--main-color) 20%, transparent),
        0 0 0 4px color-mix(in srgb, var(--main-color) 15%, transparent);
    border-color: var(--main-color);
    transform: translateY(-2px) scale(1.01);
}

/* Animated Search Icon */
.search-icon-animated {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 44px;
    height: 44px;
    border-radius: 50%;
    background: linear-gradient(135deg, var(--main-color), var(--main-color-light));
    box-shadow: 0 4px 15px color-mix(in srgb, var(--main-color) 25%, transparent);
    transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
    flex-shrink: 0;
}

.search-svg {
    width: 20px;
    height: 20px;
    color: #ffffff;
    transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
}

.search-wrapper:focus-within .search-icon-animated {
    transform: rotate(90deg) scale(1.1);
    box-shadow: 0 6px 20px color-mix(in srgb, var(--main-color) 35%, transparent);
}

.search-wrapper:focus-within .search-svg {
    transform: scale(1.15);
}

/* Input Group with Floating Label */
.input-group-modern {
    position: relative;
    flex: 1;
    display: flex;
    align-items: center;
    background: linear-gradient(145deg, #ffffff 0%, #fafbfc 100%);
    border-radius: 100px !important;
    padding: 4px 24px;
    border: 2px solid #e2e8f0;
    margin: 0 12px;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    box-shadow:
        0 2px 8px rgba(0, 0, 0, 0.06),
        inset 0 1px 3px rgba(0, 0, 0, 0.04),
        inset 0 -1px 0 rgba(255, 255, 255, 0.8);
    overflow: visible;
    min-height: 54px;
}

.input-group-modern:hover {
    border-color: #cbd5e0;
    background: linear-gradient(145deg, #ffffff 0%, #f7f9fb 100%);
    box-shadow:
        0 4px 12px rgba(0, 0, 0, 0.08),
        inset 0 1px 3px rgba(0, 0, 0, 0.05),
        inset 0 -1px 0 rgba(255, 255, 255, 0.9);
    transform: translateY(-1px);
}

.input-group-modern:focus-within {
    border-color: var(--main-color);
    background: linear-gradient(145deg, #ffffff 0%, #fdfeff 100%);
    box-shadow:
        0 6px 20px color-mix(in srgb, var(--main-color) 18%, transparent),
        0 0 0 4px color-mix(in srgb, var(--main-color) 12%, transparent),
        inset 0 1px 3px rgba(0, 0, 0, 0.03);
    transform: translateY(-2px);
}

.search-input-ultra {
    width: 100%;
    border: none !important;
    background: transparent !important;
    padding: 16px 12px !important;
    font-size: 15px !important;
    color: #1e293b !important;
    outline: none !important;
    font-weight: 500 !important;
    transition: all 0.3s ease !important;
    box-shadow: none !important;
    border-radius: 0 !important;
    -webkit-appearance: none !important;
    -moz-appearance: none !important;
    appearance: none !important;
    white-space: nowrap !important;
}

.search-input-ultra:focus {
    outline: none !important;
    border: none !important;
    box-shadow: none !important;
    background: transparent !important;
}

/* Floating Label */
.floating-label {
    position: absolute;
    left: 8px;
    top: 50%;
    transform: translateY(-50%);
    color: #94a3b8;
    font-size: 15px;
    font-weight: 400;
    pointer-events: none;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    background: transparent;
    padding: 0 6px;
    letter-spacing: 0.2px;
    white-space: nowrap;
}

.search-input-ultra:focus + .floating-label,
.search-input-ultra:not(:placeholder-shown) + .floating-label {
    top: -12px;
    left: 12px;
    font-size: 11px;
    color: var(--main-color);
    font-weight: 600;
    background: #ffffff;
    padding: 2px 8px;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
}

/* Clear Button */
.clear-search-btn {
    position: absolute;
    right: 16px;
    top: 50%;
    transform: translateY(-50%);
    width: 28px;
    height: 28px;
    border-radius: 50%;
    border: none;
    background: linear-gradient(135deg, #e2e8f0, #cbd5e1);
    color: #64748b;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    font-size: 12px;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.12);
    z-index: 10;
}

.clear-search-btn:hover {
    background: linear-gradient(135deg, #f43f5e, #dc2626);
    color: #ffffff;
    transform: translateY(-50%) rotate(90deg) scale(1.15);
    box-shadow: 0 4px 12px rgba(244, 63, 94, 0.35);
}

/* Category Selector */
.category-selector-modern {
    position: relative;
    flex-shrink: 0;
}

.category-trigger {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 10px 16px;
    background: linear-gradient(135deg, #f1f5f9, #e2e8f0);
    border-radius: 25px;
    cursor: pointer;
    transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
    border: 1px solid transparent;
    min-width: 120px;
    justify-content: space-between;
}

.category-trigger:hover {
    background: linear-gradient(135deg, var(--main-color), var(--main-color-light));
    color: #ffffff;
    border-color: var(--main-color);
    transform: translateY(-2px);
    box-shadow: 0 6px 20px color-mix(in srgb, var(--main-color) 25%, transparent);
}

.selected-category-text {
    font-size: 13px;
    font-weight: 600;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    max-width: 100px;
}

.category-trigger i {
    font-size: 10px;
    transition: transform 0.3s ease;
}

.category-selector-modern.active .category-trigger i {
    transform: rotate(180deg);
}

.category-select-hidden {
    position: absolute;
    opacity: 0;
    pointer-events: none;
}

/* Category Dropdown */
.category-dropdown-modern {
    position: absolute;
    top: calc(100% + 8px);
    right: 0;
    min-width: 220px;
    background: #ffffff;
    border-radius: 16px;
    box-shadow:
        0 20px 60px rgba(0, 0, 0, 0.15),
        0 0 0 1px rgba(0, 0, 0, 0.05);
    opacity: 0;
    visibility: hidden;
    transform: translateY(-10px) scale(0.95);
    transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
    z-index: 1000;
    max-height: 320px;
    overflow-y: auto;
    padding: 8px;
}

.category-selector-modern.active .category-dropdown-modern {
    opacity: 1;
    visibility: visible;
    transform: translateY(0) scale(1);
}

.category-option {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 12px 14px;
    border-radius: 10px;
    cursor: pointer;
    transition: all 0.2s ease;
    position: relative;
}

.category-option i:first-child {
    width: 20px;
    font-size: 14px;
    color: #64748b;
    transition: all 0.2s ease;
}

.category-option span {
    flex: 1;
    font-size: 14px;
    font-weight: 500;
    color: #1e293b;
}

.category-option .check-icon {
    opacity: 0;
    color: var(--main-color);
    font-size: 12px;
    transform: scale(0.8);
    transition: all 0.2s ease;
}

.category-option:hover {
    background: linear-gradient(135deg, #f8fafc, #f1f5f9);
    transform: translateX(4px);
}

.category-option.selected {
    background: linear-gradient(135deg, var(--main-color), var(--main-color-light));
    color: #ffffff;
}

.category-option.selected span,
.category-option.selected i:first-child {
    color: #ffffff;
}

.category-option.selected .check-icon {
    opacity: 1;
    transform: scale(1);
}

/* Search Button */
.search-btn-ultra {
    position: relative;
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 14px 28px;
    background: linear-gradient(135deg, var(--main-color), var(--main-color-light));
    border: none;
    border-radius: 35px;
    color: #ffffff;
    font-size: 15px;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
    overflow: hidden;
    box-shadow: 0 6px 25px color-mix(in srgb, var(--main-color) 30%, transparent);
    flex-shrink: 0;
}

.btn-bg-effect {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg, var(--grid-color-1), var(--main-color));
    opacity: 0;
    transition: opacity 0.3s ease;
}

.search-btn-ultra:hover .btn-bg-effect {
    opacity: 1;
}

.btn-content {
    position: relative;
    z-index: 1;
    display: flex;
    align-items: center;
    gap: 8px;
}

.search-btn-ultra:hover {
    transform: translateY(-2px) scale(1.05);
    box-shadow: 0 10px 35px color-mix(in srgb, var(--main-color) 40%, transparent);
}

.search-btn-ultra:active {
    transform: translateY(0) scale(0.98);
}

.btn-text-ultra {
    font-weight: 700;
    letter-spacing: 0.3px;
}

/* Live Search Suggestions */
.search-suggestions-ultra {
    position: absolute;
    top: calc(100% + 12px);
    left: 0;
    right: 0;
    background: #ffffff;
    border-radius: 24px;
    box-shadow:
        0 25px 70px rgba(0, 0, 0, 0.15),
        0 0 0 1px rgba(0, 0, 0, 0.05);
    max-height: 480px;
    overflow-y: auto;
    z-index: 999;
    opacity: 0;
    visibility: hidden;
    transform: translateY(-10px) scale(0.98);
    transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
    padding: 0;
}

.search-suggestions-ultra.show {
    opacity: 1;
    visibility: visible;
    transform: translateY(0) scale(1);
}

.suggestions-list {
    padding: 12px;
}

.suggestion-item {
    display: flex;
    align-items: center;
    gap: 14px;
    padding: 12px 16px;
    border-radius: 14px;
    transition: all 0.2s ease;
    cursor: pointer;
    text-decoration: none;
    color: inherit;
    margin-bottom: 6px;
    background: #ffffff;
    border: 1px solid transparent;
}

.suggestion-item:hover {
    background: linear-gradient(135deg, color-mix(in srgb, var(--main-color) 8%, transparent), color-mix(in srgb, var(--main-color-light) 8%, transparent));
    border-color: color-mix(in srgb, var(--main-color) 30%, transparent);
    transform: translateX(6px);
    box-shadow: 0 4px 12px color-mix(in srgb, var(--main-color) 15%, transparent);
}

.suggestion-image {
    width: 50px;
    height: 50px;
    border-radius: 12px;
    overflow: hidden;
    flex-shrink: 0;
    background: #f1f5f9;
    display: flex;
    align-items: center;
    justify-content: center;
}

.suggestion-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.suggestion-details {
    flex: 1;
    min-width: 0;
}

.suggestion-name {
    font-size: 14px;
    font-weight: 600;
    color: #1e293b;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    margin-bottom: 2px;
}

.suggestion-arrow {
    flex-shrink: 0;
    width: 24px;
    height: 24px;
    border-radius: 50%;
    background: linear-gradient(135deg, #f1f5f9, #e2e8f0);
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
}

.suggestion-arrow i {
    font-size: 11px;
    color: #64748b;
    transition: all 0.3s ease;
}

.suggestion-item:hover .suggestion-arrow {
    background: linear-gradient(135deg, var(--main-color), var(--main-color-light));
    transform: scale(1.1);
}

.suggestion-item:hover .suggestion-arrow i {
    color: #ffffff;
    transform: translateX(2px);
}

.no-suggestions {
    text-align: center;
    padding: 32px 20px;
    color: #94a3b8;
}

.no-suggestions i {
    font-size: 40px;
    margin-bottom: 12px;
    opacity: 0.5;
}

.no-suggestions p {
    font-size: 14px;
    font-weight: 500;
    margin: 0;
}

/* Scrollbar Styling */
.search-suggestions-ultra::-webkit-scrollbar,
.category-dropdown-modern::-webkit-scrollbar {
    width: 6px;
}

.search-suggestions-ultra::-webkit-scrollbar-track,
.category-dropdown-modern::-webkit-scrollbar-track {
    background: #f1f5f9;
    border-radius: 10px;
}

.search-suggestions-ultra::-webkit-scrollbar-thumb,
.category-dropdown-modern::-webkit-scrollbar-thumb {
    background: linear-gradient(135deg, var(--main-color), var(--main-color-light));
    border-radius: 10px;
}

/* RTL Support */
[dir="rtl"] .search-wrapper,
html[dir="rtl"] .search-wrapper,
body[dir="rtl"] .search-wrapper {
    direction: rtl;
}

[dir="rtl"] .floating-label,
html[dir="rtl"] .floating-label,
body[dir="rtl"] .floating-label {
    left: auto;
    right: 8px;
}

[dir="rtl"] .search-input-ultra:focus + .floating-label,
[dir="rtl"] .search-input-ultra:not(:placeholder-shown) + .floating-label,
html[dir="rtl"] .search-input-ultra:focus + .floating-label,
html[dir="rtl"] .search-input-ultra:not(:placeholder-shown) + .floating-label,
body[dir="rtl"] .search-input-ultra:focus + .floating-label,
body[dir="rtl"] .search-input-ultra:not(:placeholder-shown) + .floating-label {
    right: 12px;
    left: auto;
}

[dir="rtl"] .clear-search-btn,
html[dir="rtl"] .clear-search-btn,
body[dir="rtl"] .clear-search-btn {
    right: auto;
    left: 12px;
}

[dir="rtl"] .category-dropdown-modern,
html[dir="rtl"] .category-dropdown-modern,
body[dir="rtl"] .category-dropdown-modern {
    right: auto;
    left: 0;
}

[dir="rtl"] .category-option:hover,
html[dir="rtl"] .category-option:hover,
body[dir="rtl"] .category-option:hover {
    transform: translateX(-4px);
}

[dir="rtl"] .suggestion-item:hover,
html[dir="rtl"] .suggestion-item:hover,
body[dir="rtl"] .suggestion-item:hover {
    transform: translateX(-6px);
}

[dir="rtl"] .suggestion-item:hover .suggestion-arrow i,
html[dir="rtl"] .suggestion-item:hover .suggestion-arrow i,
body[dir="rtl"] .suggestion-item:hover .suggestion-arrow i {
    transform: translateX(-2px);
}

/* iPad Pro and medium tablets */
@media (max-width: 1199px) {
    .search-wrapper {
        padding: 6px;
        gap: 8px;
    }

    .search-icon-animated {
        width: 40px;
        height: 40px;
    }

    .search-svg {
        width: 18px;
        height: 18px;
    }

    .input-group-modern {
        padding: 4px 16px;
        min-height: 48px;
    }

    .search-input-ultra {
        font-size: 13px !important;
        padding: 12px 10px !important;
    }

    .floating-label {
        font-size: 13px;
    }

    .category-trigger {
        padding: 8px 12px;
        min-width: 95px;
    }

    .selected-category-text {
        font-size: 12px;
        max-width: 75px;
    }

    .search-btn-ultra {
        padding: 11px 22px;
        font-size: 13px;
    }

    .btn-text-ultra {
        font-size: 13px;
    }
}

/* iPad Mini and Small Tablets (768px - 991px) */
@media (min-width: 768px) and (max-width: 991px) {
    .search-wrapper {
        padding: 5px;
        gap: 6px;
    }

    .search-icon-animated {
        width: 38px;
        height: 38px;
    }

    .search-svg {
        width: 16px;
        height: 16px;
    }

    .input-group-modern {
        padding: 4px 14px;
        min-height: 45px;
        margin: 0;
    }

    .search-input-ultra {
        font-size: 13px !important;
        padding: 10px 8px !important;
    }

    .floating-label {
        font-size: 13px;
    }

    .category-trigger {
        padding: 6px 10px;
        min-width: 90px;
    }

    .selected-category-text {
        font-size: 11px;
        max-width: 70px;
    }

    .search-btn-ultra {
        padding: 9px 18px;
        font-size: 12px;
    }

    .btn-text-ultra {
        font-size: 12px;
    }
}

/* Mobile Responsive */
@media (max-width: 992px) {
    .search-wrapper {
        padding: 6px;
        gap: 8px;
    }

    .search-icon-animated {
        width: 38px;
        height: 38px;
    }

    .search-svg {
        width: 18px;
        height: 18px;
    }

    .search-input-ultra {
        font-size: 14px;
        padding: 12px 14px 12px 0;
    }

    .category-trigger {
        padding: 8px 12px;
        min-width: 100px;
    }

    .selected-category-text {
        font-size: 12px;
        max-width: 70px;
    }

    .search-btn-ultra {
        padding: 12px 20px;
        font-size: 14px;
    }

    .btn-text-ultra {
        display: none;
    }
}

@media (max-width: 767px) {
    .category-selector-modern {
        display: none;
    }

    .search-input-ultra {
        padding-right: 40px;
    }
}
