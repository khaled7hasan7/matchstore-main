@php
    $isRtl = app()->getLocale() === 'ar';
    $vendorSubtotal = $details->sum(fn ($d) => $d->price * $d->quantity);
    $alignEnd = $isRtl ? 'left' : 'right';
@endphp
<div dir="{{ $isRtl ? 'rtl' : 'ltr' }}" style="font-family: Tahoma, 'Segoe UI', Arial, sans-serif; background: #f6f7f9; padding: 24px; margin: 0;">
    <div style="max-width: 640px; margin: 0 auto; background: #ffffff; border: 1px solid #e5e7eb; border-radius: 8px; padding: 28px;">
        <h2 style="margin: 0 0 4px; color: #111827;">{{ $storeName }}</h2>
        <p style="margin: 0 0 20px; color: #1d4ed8; font-size: 14px; font-weight: bold;">{{ __('store.emails.vendor_heading') }}</p>

        <p style="font-size: 15px; line-height: 1.7;">
            {{ __('store.emails.greeting', ['name' => $vendor->name]) }}<br>
            {{ __('store.emails.vendor_intro', ['id' => $order->id]) }}
        </p>

        {{-- Only this vendor's items — never the whole order --}}
        @include('emails.orders._items')

        <table width="100%" cellpadding="0" cellspacing="0" style="border-collapse: collapse; margin: 8px 0 16px;">
            <tr>
                <td style="padding: 8px; font-size: 15px; font-weight: bold; border-top: 2px solid #e5e7eb;">{{ __('store.emails.vendor_items_total') }}</td>
                <td style="padding: 8px; font-size: 15px; font-weight: bold; border-top: 2px solid #e5e7eb; text-align: {{ $alignEnd }};">{{ $currencySymbol }}{{ number_format($vendorSubtotal, 2) }}</td>
            </tr>
        </table>

        @include('emails.orders._address')

        <p style="font-size: 13px; color: #6b7280; line-height: 1.7; margin-top: 20px;">
            {{ __('store.emails.vendor_footer') }}
        </p>
    </div>
</div>
