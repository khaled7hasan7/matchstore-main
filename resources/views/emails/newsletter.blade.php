<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $emailSubject }}</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
        }
        .email-container {
            max-width: 600px;
            margin: 30px auto;
            background: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
        .email-header {
            background: #ffffff;
            padding: 40px 30px 30px;
            text-align: center;
            border-bottom: 3px solid #f3f4f6;
        }
        .logo-container {
            margin-bottom: 20px;
        }
        .logo {
            max-width: 180px;
            max-height: 70px;
            object-fit: contain;
            padding: 10px;
        }
        .store-name {
            font-size: 24px;
            font-weight: 700;
            margin-top: 15px;
            color: #111827;
        }
        .email-subject {
            font-size: 22px;
            font-weight: 700;
            margin-top: 25px;
            padding-top: 20px;
            border-top: 2px solid #e5e7eb;
            color: #111827;
        }
        .email-body {
            padding: 40px 30px;
            background: #ffffff;
        }
        .email-content {
            font-size: 15px;
            line-height: 1.8;
            color: #4b5563;
            white-space: pre-wrap;
        }
        .email-content p {
            margin: 0 0 15px 0;
        }
        .email-content a {
            color: #111827;
            text-decoration: underline;
            font-weight: 600;
        }
        .email-content a:hover {
            color: #374151;
        }
        .divider {
            height: 2px;
            background: #e5e7eb;
            margin: 30px 0;
        }
        .email-footer {
            background: #f9fafb;
            padding: 30px 20px;
            text-align: center;
            font-size: 13px;
            color: #6b7280;
            border-top: 1px solid #e5e7eb;
        }
        .footer-logo {
            max-width: 100px;
            max-height: 40px;
            object-fit: contain;
            margin-bottom: 10px;
            opacity: 0.7;
        }
        .footer-store-name {
            font-weight: 600;
            color: #111827;
            font-size: 14px;
            margin-bottom: 8px;
        }
        .footer-contact {
            color: #9ca3af;
            margin-top: 10px;
        }
        .email-footer a {
            color: #111827;
            text-decoration: none;
            font-weight: 600;
        }
        .email-footer a:hover {
            text-decoration: underline;
        }
        .unsubscribe-section {
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #e5e7eb;
        }
        .unsubscribe-button {
            display: inline-block;
            padding: 10px 24px;
            background: #111827;
            color: #ffffff;
            text-decoration: none;
            border-radius: 6px;
            font-size: 13px;
            margin-top: 10px;
            font-weight: 600;
        }
        .unsubscribe-button:hover {
            background: #1f2937;
        }
        @media only screen and (max-width: 600px) {
            .email-container {
                margin: 10px;
                border-radius: 8px;
            }
            .email-header {
                padding: 30px 20px;
            }
            .email-body {
                padding: 30px 20px;
            }
            .logo {
                max-width: 150px;
            }
        }
    </style>
</head>
<body>
    <div class="email-container">
        <!-- Header with Logo and Store Name -->
        <div class="email-header">
            <div class="logo-container">
                @if($siteSettings && $siteSettings->logo)
                    <img src="{{ store_image($siteSettings->logo) }}" alt="{{ $siteSettings->site_name ?? config('app.name') }}" class="logo">
                @endif
            </div>
            <div class="store-name">{{ $siteSettings->site_name ?? config('app.name') }}</div>
            <div class="email-subject">{{ $emailSubject }}</div>
        </div>

        <!-- Body -->
        <div class="email-body">
            <div class="email-content">
                {!! nl2br(e($emailContent)) !!}
            </div>
            <div class="divider"></div>
            <p style="color: #9ca3af; font-size: 14px; text-align: center;">
                Thank you for being a valued subscriber!
            </p>
        </div>

        <!-- Footer -->
        <div class="email-footer">
            @if($siteSettings && $siteSettings->logo)
                <img src="{{ store_image($siteSettings->logo) }}" alt="{{ $siteSettings->site_name ?? config('app.name') }}" class="footer-logo">
            @endif
            <div class="footer-store-name">{{ $siteSettings->site_name ?? config('app.name') }}</div>
            <p>&copy; {{ date('Y') }} {{ $siteSettings->site_name ?? config('app.name') }}. All rights reserved.</p>

            @if($siteSettings && $siteSettings->contact_email)
                <p class="footer-contact">
                    Contact us: <a href="mailto:{{ $siteSettings->contact_email }}">{{ $siteSettings->contact_email }}</a>
                </p>
            @endif

            @if($siteSettings && $siteSettings->contact_phone)
                <p class="footer-contact">
                    Phone: {{ $siteSettings->contact_phone }}
                </p>
            @endif

            <!-- Unsubscribe Section -->
            <div class="unsubscribe-section">
                <p style="color: #9ca3af;">Don't want to receive these emails anymore?</p>
                <a href="{{ $unsubscribeUrl }}" class="unsubscribe-button">Unsubscribe</a>
            </div>
        </div>
    </div>
</body>
</html>
