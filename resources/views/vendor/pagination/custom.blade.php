@if ($paginator->hasPages())
    <div class="modern-pagination-wrapper">
        {{-- Results Info --}}
        <div class="pagination-info">
            <span class="text-muted">
                {{ __('pagination.showing') }} <strong>{{ $paginator->firstItem() }}</strong> {{ __('pagination.to') }} <strong>{{ $paginator->lastItem() }}</strong> {{ __('pagination.of') }} <strong>{{ $paginator->total() }}</strong> {{ __('pagination.results') }}
            </span>
        </div>

        {{-- Pagination Links --}}
        <nav aria-label="{{ __('pagination.navigation') }}">
            <ul class="modern-pagination">
                {{-- Previous Page Link --}}
                @if ($paginator->onFirstPage())
                    <li class="page-item disabled">
                        <span class="page-link">
                            <i class="fas fa-chevron-left"></i>
                            <span class="d-none d-sm-inline ms-1">{{ __('pagination.previous') }}</span>
                        </span>
                    </li>
                @else
                    <li class="page-item">
                        <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev">
                            <i class="fas fa-chevron-left"></i>
                            <span class="d-none d-sm-inline ms-1">{{ __('pagination.previous') }}</span>
                        </a>
                    </li>
                @endif

                {{-- Pagination Elements --}}
                @foreach ($elements as $element)
                    {{-- "Three Dots" Separator --}}
                    @if (is_string($element))
                        <li class="page-item disabled">
                            <span class="page-link dots">{{ $element }}</span>
                        </li>
                    @endif

                    {{-- Array Of Links --}}
                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <li class="page-item active" aria-current="page">
                                    <span class="page-link">{{ $page }}</span>
                                </li>
                            @else
                                <li class="page-item">
                                    <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                </li>
                            @endif
                        @endforeach
                    @endif
                @endforeach

                {{-- Next Page Link --}}
                @if ($paginator->hasMorePages())
                    <li class="page-item">
                        <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next">
                            <span class="d-none d-sm-inline me-1">{{ __('pagination.next') }}</span>
                            <i class="fas fa-chevron-right"></i>
                        </a>
                    </li>
                @else
                    <li class="page-item disabled">
                        <span class="page-link">
                            <span class="d-none d-sm-inline me-1">{{ __('pagination.next') }}</span>
                            <i class="fas fa-chevron-right"></i>
                        </span>
                    </li>
                @endif
            </ul>
        </nav>
    </div>

    <style>
        .modern-pagination-wrapper {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 1.5rem;
            margin: 3rem 0;
        }

        .pagination-info {
            font-size: 0.9rem;
            color: var(--dark-color);
        }

        .pagination-info strong {
            color: var(--main-color);
            font-weight: 600;
        }

        .modern-pagination {
            display: flex;
            list-style: none;
            padding: 0;
            margin: 0;
            gap: 0.5rem;
            flex-wrap: wrap;
            justify-content: center;
        }

        .modern-pagination .page-item {
            margin: 0;
        }

        .modern-pagination .page-link {
            display: flex;
            align-items: center;
            justify-content: center;
            min-width: 42px;
            height: 42px;
            padding: 0 16px;
            border: 2px solid var(--grid-color-2);
            border-radius: 10px;
            background: var(--white);
            color: var(--dark-color);
            font-weight: 600;
            font-size: 0.95rem;
            text-decoration: none;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .modern-pagination .page-link i {
            font-size: 0.85rem;
        }

        .modern-pagination .page-item:not(.disabled) .page-link:hover {
            background: linear-gradient(135deg, var(--main-color), var(--main-color-light));
            color: var(--white);
            border-color: var(--main-color);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .modern-pagination .page-item.active .page-link {
            background: linear-gradient(135deg, var(--main-color), var(--main-color-light));
            color: var(--white);
            border-color: var(--main-color);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
            cursor: default;
        }

        .modern-pagination .page-item.disabled .page-link {
            background: var(--cardbg);
            color: var(--grid-color-2);
            border-color: var(--grid-color-2);
            opacity: 0.6;
            cursor: not-allowed;
        }

        .modern-pagination .page-link.dots {
            border: none;
            background: transparent;
            cursor: default;
        }

        /* Directional border radius for Previous/Next buttons in LTR */
        .modern-pagination .page-item:first-child .page-link {
            border-radius: 10px 0 0 10px;
        }

        .modern-pagination .page-item:last-child .page-link {
            border-radius: 0 10px 10px 0;
        }

        /* Mobile responsive */
        @media (max-width: 576px) {
            .modern-pagination .page-link {
                min-width: 38px;
                height: 38px;
                padding: 0 12px;
                font-size: 0.85rem;
            }

            .pagination-info {
                font-size: 0.85rem;
                text-align: center;
            }
        }

        /* RTL Support */
        [dir="rtl"] .modern-pagination,
        html[dir="rtl"] .modern-pagination,
        body[dir="rtl"] .modern-pagination {
            direction: rtl;
        }

        [dir="rtl"] .modern-pagination .page-link,
        html[dir="rtl"] .modern-pagination .page-link,
        body[dir="rtl"] .modern-pagination .page-link {
            direction: rtl;
        }

        /* Flip chevrons for RTL */
        [dir="rtl"] .modern-pagination .fa-chevron-left,
        html[dir="rtl"] .modern-pagination .fa-chevron-left,
        body[dir="rtl"] .modern-pagination .fa-chevron-left {
            transform: scaleX(-1);
        }

        [dir="rtl"] .modern-pagination .fa-chevron-right,
        html[dir="rtl"] .modern-pagination .fa-chevron-right,
        body[dir="rtl"] .modern-pagination .fa-chevron-right {
            transform: scaleX(-1);
        }

        /* RTL spacing adjustments */
        [dir="rtl"] .modern-pagination .page-link .ms-1,
        html[dir="rtl"] .modern-pagination .page-link .ms-1,
        body[dir="rtl"] .modern-pagination .page-link .ms-1 {
            margin-right: 0.25rem;
            margin-left: 0;
        }

        [dir="rtl"] .modern-pagination .page-link .me-1,
        html[dir="rtl"] .modern-pagination .page-link .me-1,
        body[dir="rtl"] .modern-pagination .page-link .me-1 {
            margin-left: 0.25rem;
            margin-right: 0;
        }

        /* RTL pagination info text alignment */
        [dir="rtl"] .pagination-info,
        html[dir="rtl"] .pagination-info,
        body[dir="rtl"] .pagination-info {
            direction: rtl;
            text-align: center;
        }

        /* RTL directional border radius for Previous/Next buttons */
        [dir="rtl"] .modern-pagination .page-item:first-child .page-link,
        html[dir="rtl"] .modern-pagination .page-item:first-child .page-link,
        body[dir="rtl"] .modern-pagination .page-item:first-child .page-link {
            border-radius: 0 10px 10px 0;
        }

        [dir="rtl"] .modern-pagination .page-item:last-child .page-link,
        html[dir="rtl"] .modern-pagination .page-item:last-child .page-link,
        body[dir="rtl"] .modern-pagination .page-item:last-child .page-link {
            border-radius: 10px 0 0 10px;
        }
    </style>
@endif
