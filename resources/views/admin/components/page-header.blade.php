{{-- Page Header Component --}}
{{-- Usage: @include('admin.components.page-header', ['title' => 'Page Title', 'subtitle' => 'Optional subtitle', 'actions' => view or html]) --}}

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="mb-1">{{ $title }}</h2>
        @if(isset($subtitle))
            <p class="text-muted mb-0">{{ $subtitle }}</p>
        @endif
    </div>
    @if(isset($actions))
        <div>
            {!! $actions !!}
        </div>
    @endif
</div>
