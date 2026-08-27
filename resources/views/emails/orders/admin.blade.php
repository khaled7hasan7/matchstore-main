@php $isRtl = app()->getLocale() === 'ar'; @endphp
<div dir="{{ $isRtl ? 'rtl' : 'ltr' }}" style="font-family: Tahoma, 'Segoe UI', Arial, sans-serif; background: #f6f7f9; padding: 24px; margin: 0;">
    <div style="max-width: 640px; margin: 0 auto; background: #ffffff; border: 1px solid #e5e7eb; border-radius: 8px; padding: 28px;">
        <h2 style="margin: 0 0 4px; color: #111827;">{{ $storeName }}</h2>
        <p style="margin: 0 0 20px; color: #b91c1c; font-size: 14px; font-weight: bold;">{{ __('store.emails.admin_heading') }}</p>

        <p style="font-size: 15px; line-height: 1.7;">
            {{ __('store.emails.admin_intro', ['id' => $order->id]) }}
        </p>

        <div style="background: #f9fafb; border-radius: 6px; padding: 10px 16px; margin: 12px 0; font-size: 14px; line-height: 1.8;">
            <strong>{{ __('store.emails.customer') }}:</strong> {{ $order->first_name }} {{ $order->last_name }}
            ({{ $order->email }}@if($order->phone) · {{ $order->phone }}@endif)<br>
            <strong>{{ __('store.emails.order_date') }}:</strong> {{ $order->created_at?->format('Y-m-d H:i') }}<br>
            <strong>{{ __('store.emails.payment_method') }}:</strong>
            {{ $order->payment_method === 'cod' ? __('store.emails.cod') : $order->payment_method }}
        </div>

        @include('emails.orders._items', ['details' => $order->details])
        @include('emails.orders._totals')
        @include('emails.orders._address')
    </div>
</div>
