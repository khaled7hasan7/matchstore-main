<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Unsubscribed - {{ $siteSettings->site_name ?? config('app.name') }}</title>
    @if($siteSettings && $siteSettings->favicon)
        <link rel="icon" type="image/x-icon" href="{{ store_image($siteSettings->favicon) }}">
        <link rel="shortcut icon" type="image/x-icon" href="{{ store_image($siteSettings->favicon) }}">
    @endif
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f8f9fa;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .container {
            max-width: 650px;
            background: white;
            border-radius: 20px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            overflow: hidden;
            border: 1px solid #e5e7eb;
        }

        .header {
            background: white;
            padding: 40px 30px;
            text-align: center;
            border-bottom: 2px solid #f3f4f6;
        }

        .logo-container {
            margin-bottom: 20px;
        }

        .logo {
            max-width: 180px;
            max-height: 80px;
            object-fit: contain;
            padding: 10px;
        }

        .store-name {
            font-size: 28px;
            font-weight: 700;
            color: #111827;
            margin-top: 15px;
        }

        .content {
            padding: 50px 40px;
            text-align: center;
        }

        .status-icon {
            width: 100px;
            height: 100px;
            margin: 0 auto 30px;
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 50px;
            color: white;
            box-shadow: 0 8px 20px rgba(16, 185, 129, 0.3);
        }

        .status-icon.error {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            box-shadow: 0 8px 20px rgba(239, 68, 68, 0.3);
        }

        h1 {
            font-size: 32px;
            color: #111827;
            margin-bottom: 20px;
            font-weight: 700;
        }

        p {
            font-size: 16px;
            color: #6b7280;
            line-height: 1.8;
            margin-bottom: 15px;
        }

        .email-box {
            background: #f9fafb;
            padding: 15px 25px;
            border-radius: 10px;
            display: inline-block;
            margin: 25px 0;
            font-weight: 600;
            color: #374151;
            border: 2px solid #e5e7eb;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .email-icon {
            color: #6b7280;
            margin-right: 8px;
        }

        .btn {
            display: inline-block;
            padding: 16px 40px;
            background: #111827;
            color: white;
            text-decoration: none;
            border-radius: 12px;
            font-weight: 600;
            margin-top: 30px;
            transition: all 0.3s ease;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            font-size: 16px;
        }

        .btn:hover {
            background: #1f2937;
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15);
        }

        .btn i {
            margin-right: 8px;
        }

        .footer {
            background: #f9fafb;
            padding: 30px 40px;
            text-align: center;
            border-top: 1px solid #e5e7eb;
        }

        .footer-logo {
            max-width: 120px;
            max-height: 50px;
            object-fit: contain;
            margin-bottom: 15px;
            opacity: 0.7;
        }

        .footer p {
            font-size: 14px;
            color: #9ca3af;
            margin-bottom: 8px;
        }

        .footer-store-name {
            font-weight: 600;
            color: #111827;
            font-size: 15px;
        }

        .divider {
            width: 60px;
            height: 3px;
            background: #e5e7eb;
            margin: 25px auto;
            border-radius: 2px;
        }

        @media (max-width: 600px) {
            .content {
                padding: 40px 25px;
            }

            h1 {
                font-size: 26px;
            }

            .logo {
                max-width: 150px;
            }

            .store-name {
                font-size: 24px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header with Logo -->
        <div class="header">
            <div class="logo-container">
                @if($siteSettings && $siteSettings->logo)
                    <img src="{{ store_image($siteSettings->logo) }}" alt="{{ $siteSettings->site_name ?? config('app.name') }}" class="logo">
                @endif
            </div>
            <div class="store-name">{{ $siteSettings->site_name ?? config('app.name') }}</div>
        </div>

        <!-- Main Content -->
        <div class="content">
            @if(isset($notFound) && $notFound)
                <div class="status-icon error">
                    <i class="fas fa-times"></i>
                </div>
                <h1>Email Not Found</h1>
                <p>We couldn't find this email address in our subscription list.</p>
                <div class="email-box">
                    <i class="fas fa-envelope email-icon"></i>{{ $email }}
                </div>
                <p>It may have already been unsubscribed or was never subscribed.</p>
            @else
                <div class="status-icon">
                    <i class="fas fa-check"></i>
                </div>
                <h1>Successfully Unsubscribed</h1>
                <p>You have been successfully removed from our mailing list.</p>
                <div class="email-box">
                    <i class="fas fa-envelope email-icon"></i>{{ $email }}
                </div>
                <div class="divider"></div>
                <p>You will no longer receive newsletter emails from {{ $siteSettings->site_name ?? config('app.name') }}.</p>
                <p>If you change your mind, you can always subscribe again from our website.</p>
            @endif

            <a href="{{ route('xylo.home') }}" class="btn">
                <i class="fas fa-home"></i>Back to Home
            </a>
        </div>

        <!-- Footer -->
        <div class="footer">
            @if($siteSettings && $siteSettings->logo)
                <img src="{{ store_image($siteSettings->logo) }}" alt="{{ $siteSettings->site_name ?? config('app.name') }}" class="footer-logo">
            @endif
            <p class="footer-store-name">{{ $siteSettings->site_name ?? config('app.name') }}</p>
            <p>&copy; {{ date('Y') }} {{ $siteSettings->site_name ?? config('app.name') }}. All rights reserved.</p>
            @if($siteSettings && $siteSettings->contact_email)
                <p><i class="fas fa-envelope" style="color: #6b7280; margin-right: 5px;"></i>{{ $siteSettings->contact_email }}</p>
            @endif
        </div>
    </div>
</body>
</html>
