@extends('admin.layouts.admin')

@section('title', __('cms.newsletter.compose'))

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">{{ __('cms.newsletter.compose_newsletter') }}</h1>
            <p class="text-muted mb-0">{{ __('cms.newsletter.manage_subscribers') }}</p>
        </div>
        <div>
            <a href="{{ route('admin.subscribers.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>{{ __('cms.newsletter.back_to_subscribers') }}
            </a>
        </div>
    </div>

    <!-- Subscriber Count Card -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="alert alert-info d-flex align-items-center" role="alert">
                <i class="fas fa-info-circle fa-2x me-3"></i>
                <div>
                    {{ __('cms.newsletter.recipients_info', ['count' => number_format($activeSubscribersCount)]) }}
                </div>
            </div>
        </div>
    </div>

    @if($activeSubscribersCount == 0)
        <div class="alert alert-warning">
            <i class="fas fa-exclamation-triangle me-2"></i>
            {{ __('cms.newsletter.error_no_subscribers') }}
        </div>
    @endif

    <!-- Compose Form -->
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <form action="{{ route('admin.subscribers.send') }}" method="POST" id="newsletterForm">
                @csrf

                <!-- Subject -->
                <div class="mb-4">
                    <label for="subject" class="form-label fw-bold">
                        <i class="fas fa-heading me-2"></i>{{ __('cms.newsletter.email_subject') }}
                        <span class="text-danger">*</span>
                    </label>
                    <input type="text"
                           class="form-control @error('subject') is-invalid @enderror"
                           id="subject"
                           name="subject"
                           placeholder="{{ __('cms.newsletter.subject_placeholder') }}"
                           value="{{ old('subject') }}"
                           required
                           maxlength="255">
                    @error('subject')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Content -->
                <div class="mb-4">
                    <label for="content" class="form-label fw-bold">
                        <i class="fas fa-envelope-open-text me-2"></i>{{ __('cms.newsletter.email_content') }}
                        <span class="text-danger">*</span>
                    </label>
                    <textarea class="form-control @error('content') is-invalid @enderror"
                              id="content"
                              name="content"
                              rows="12"
                              placeholder="{{ __('cms.newsletter.content_placeholder') }}"
                              required>{{ old('content') }}</textarea>
                    @error('content')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror>
                </div>

                <!-- Preview Box -->
                <div class="mb-4">
                    <label class="form-label fw-bold">
                        <i class="fas fa-eye me-2"></i>{{ __('cms.newsletter.preview') }}
                    </label>
                    <div class="card bg-light">
                        <div class="card-body">
                            <div id="previewSubject" class="mb-3">
                                <strong>{{ __('cms.newsletter.email_subject') }}:</strong> <span class="text-muted">{{ __('cms.newsletter.subject_placeholder') }}</span>
                            </div>
                            <div id="previewContent" class="border-top pt-3">
                                <span class="text-muted">{{ __('cms.newsletter.content_placeholder') }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <button type="button" class="btn btn-outline-secondary" onclick="window.history.back()">
                        <i class="fas fa-times me-2"></i>{{ __('general.cancel') }}
                    </button>
                    <button type="submit" class="btn btn-primary" {{ $activeSubscribersCount == 0 ? 'disabled' : '' }}>
                        <i class="fas fa-paper-plane me-2"></i>{{ __('cms.newsletter.send_newsletter_button') }}
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>

<style>
    #previewSubject strong {
        color: #84cc16;
    }

    #previewContent {
        white-space: pre-wrap;
        font-family: Arial, sans-serif;
        line-height: 1.6;
    }

    .form-control:focus {
        border-color: #84cc16;
        box-shadow: 0 0 0 0.2rem rgba(132, 204, 22, 0.25);
    }

    .btn-primary {
        background: linear-gradient(135deg, #84cc16, #65a30d);
        border: none;
    }

    .btn-primary:hover {
        background: linear-gradient(135deg, #65a30d, #4d7c0f);
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const subjectInput = document.getElementById('subject');
    const contentInput = document.getElementById('content');
    const previewSubject = document.getElementById('previewSubject');
    const previewContent = document.getElementById('previewContent');

    // Update preview on input
    subjectInput.addEventListener('input', function() {
        if (this.value.trim()) {
            previewSubject.innerHTML = '<strong>{{ __('cms.newsletter.email_subject') }}:</strong> ' + escapeHtml(this.value);
        } else {
            previewSubject.innerHTML = '<strong>{{ __('cms.newsletter.email_subject') }}:</strong> <span class="text-muted">{{ __('cms.newsletter.subject_placeholder') }}</span>';
        }
    });

    contentInput.addEventListener('input', function() {
        if (this.value.trim()) {
            previewContent.textContent = this.value;
        } else {
            previewContent.innerHTML = '<span class="text-muted">{{ __('cms.newsletter.content_placeholder') }}</span>';
        }
    });

    // Escape HTML to prevent XSS
    function escapeHtml(text) {
        const map = {
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            '"': '&quot;',
            "'": '&#039;'
        };
        return text.replace(/[&<>"']/g, m => map[m]);
    }

    // Confirm before sending
    document.getElementById('newsletterForm').addEventListener('submit', function(e) {
        if (!confirm('{{ __('cms.newsletter.send_confirm') }}')) {
            e.preventDefault();
        }
    });
});
</script>
@endsection
