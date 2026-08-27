@php $isRtl = app()->getLocale() === 'ar'; @endphp
<div dir="{{ $isRtl ? 'rtl' : 'ltr' }}" style="font-family: Tahoma, 'Segoe UI', Arial, sans-serif; background: #f6f7f9; padding: 24px; margin: 0;">
    <div style="max-width: 640px; margin: 0 auto; background: #ffffff; border: 1px solid #e5e7eb; border-radius: 8px; padding: 28px;">
        <h2 style="margin: 0 0 4px; color: #111827;">{{ $storeName }}</h2>
        <p style="margin: 0 0 20px; color: #6b7280; font-size: 14px;">{{ __('store.emails.contact_heading') }}</p>

        <div style="background: #f9fafb; border-radius: 6px; padding: 12px 16px; margin: 12px 0; font-size: 14px; line-height: 1.9;">
            <strong>{{ __('store.emails.contact_name') }}:</strong> {{ $contact->name }}<br>
            <strong>{{ __('store.emails.contact_email') }}:</strong> {{ $contact->email }}<br>
            @if($contact->phone)
                <strong>{{ __('store.emails.contact_phone') }}:</strong> {{ $contact->phone }}<br>
            @endif
            <strong>{{ __('store.emails.contact_subject_label') }}:</strong> {{ $contact->subject }}
        </div>

        <div style="border: 1px solid #e5e7eb; border-radius: 6px; padding: 16px; font-size: 14px; line-height: 1.8; white-space: pre-line;">{{ $contact->message }}</div>

        <p style="font-size: 13px; color: #6b7280; margin-top: 20px;">
            {{ __('store.emails.contact_footer') }}
        </p>
    </div>
</div>
