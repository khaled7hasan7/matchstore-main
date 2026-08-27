@php
    $locale = app()->getLocale();
    $regionName = $order->region
        ? ($locale === 'ar' ? $order->region->name_ar : $order->region->name)
        : null;
@endphp
<div style="background: #f9fafb; border-radius: 6px; padding: 12px 16px; margin: 12px 0; font-size: 14px; line-height: 1.8;">
    <strong>{{ __('store.emails.shipping_address') }}</strong><br>
    {{ $order->first_name }} {{ $order->last_name }}<br>
    {{ $order->address }}@if($order->suite)، {{ $order->suite }}@endif<br>
    {{ $order->city }}@if($regionName && $regionName !== $order->city) — {{ $regionName }}@endif — {{ __('store.checkout.'.$order->country) !== 'store.checkout.'.$order->country ? __('store.checkout.'.$order->country) : $order->country }}<br>
    @if($order->zipcode){{ $order->zipcode }}<br>@endif
    {{ $order->phone }} · {{ $order->email }}
    @if($order->region && $order->region->delivery_days)
        <br>{{ __('store.emails.estimated_delivery', ['days' => $order->region->delivery_days]) }}
    @endif
</div>
