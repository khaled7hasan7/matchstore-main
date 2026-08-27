@php
    $alignEnd = app()->getLocale() === 'ar' ? 'left' : 'right';
@endphp
<table width="100%" cellpadding="0" cellspacing="0" style="border-collapse: collapse; margin: 8px 0 16px;">
    @if(! is_null($order->subtotal))
        <tr>
            <td style="padding: 4px 8px; font-size: 14px; color: #6b7280;">{{ __('store.emails.subtotal') }}</td>
            <td style="padding: 4px 8px; font-size: 14px; text-align: {{ $alignEnd }};">{{ $currencySymbol }}{{ number_format($order->subtotal, 2) }}</td>
        </tr>
        @if($order->discount > 0)
            <tr>
                <td style="padding: 4px 8px; font-size: 14px; color: #16a34a;">{{ __('store.emails.discount') }}@if($order->coupon_code) ({{ $order->coupon_code }})@endif</td>
                <td style="padding: 4px 8px; font-size: 14px; color: #16a34a; text-align: {{ $alignEnd }};">-{{ $currencySymbol }}{{ number_format($order->discount, 2) }}</td>
            </tr>
        @endif
        <tr>
            <td style="padding: 4px 8px; font-size: 14px; color: #6b7280;">{{ __('store.emails.shipping') }}</td>
            <td style="padding: 4px 8px; font-size: 14px; text-align: {{ $alignEnd }};">{{ $currencySymbol }}{{ number_format($order->shipping_cost, 2) }}</td>
        </tr>
    @endif
    <tr>
        <td style="padding: 8px; font-size: 16px; font-weight: bold; border-top: 2px solid #e5e7eb;">{{ __('store.emails.total') }}</td>
        <td style="padding: 8px; font-size: 16px; font-weight: bold; border-top: 2px solid #e5e7eb; text-align: {{ $alignEnd }};">{{ $currencySymbol }}{{ number_format($order->total, 2) }}</td>
    </tr>
</table>
