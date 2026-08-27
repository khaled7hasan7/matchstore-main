@php
    $locale = app()->getLocale();
    $align = $locale === 'ar' ? 'right' : 'left';
    $alignEnd = $locale === 'ar' ? 'left' : 'right';
@endphp
<table width="100%" cellpadding="0" cellspacing="0" style="border-collapse: collapse; margin: 16px 0;">
    <thead>
        <tr>
            <th style="text-align: {{ $align }}; padding: 8px; border-bottom: 2px solid #e5e7eb; font-size: 13px; color: #6b7280;">{{ __('store.emails.item') }}</th>
            <th style="text-align: center; padding: 8px; border-bottom: 2px solid #e5e7eb; font-size: 13px; color: #6b7280;">{{ __('store.emails.qty') }}</th>
            <th style="text-align: {{ $alignEnd }}; padding: 8px; border-bottom: 2px solid #e5e7eb; font-size: 13px; color: #6b7280;">{{ __('store.emails.price') }}</th>
            <th style="text-align: {{ $alignEnd }}; padding: 8px; border-bottom: 2px solid #e5e7eb; font-size: 13px; color: #6b7280;">{{ __('store.emails.line_total') }}</th>
        </tr>
    </thead>
    <tbody>
        @foreach($details as $detail)
            @php
                $translations = $detail->product?->translations;
                $name = $translations?->firstWhere('language_code', $locale)?->name
                    ?? $translations?->first()?->name
                    ?? '#'.$detail->product_id;
            @endphp
            <tr>
                <td style="text-align: {{ $align }}; padding: 10px 8px; border-bottom: 1px solid #f3f4f6; font-size: 14px;">{{ $name }}</td>
                <td style="text-align: center; padding: 10px 8px; border-bottom: 1px solid #f3f4f6; font-size: 14px;">{{ $detail->quantity }}</td>
                <td style="text-align: {{ $alignEnd }}; padding: 10px 8px; border-bottom: 1px solid #f3f4f6; font-size: 14px;">{{ $currencySymbol }}{{ number_format($detail->price, 2) }}</td>
                <td style="text-align: {{ $alignEnd }}; padding: 10px 8px; border-bottom: 1px solid #f3f4f6; font-size: 14px;">{{ $currencySymbol }}{{ number_format($detail->price * $detail->quantity, 2) }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
