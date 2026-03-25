<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirm Pickup Request</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f3f4f6;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 40px auto;
            background-color: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .header {
            background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);
            color: white;
            padding: 40px 30px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 28px;
            font-weight: bold;
        }
        .header p {
            margin: 10px 0 0;
            opacity: 0.9;
        }
        .content {
            padding: 40px 30px;
        }
        .content h2 {
            color: #1f2937;
            font-size: 20px;
            margin-top: 0;
        }
        .info-box {
            background-color: #f9fafb;
            border-left: 4px solid #6366f1;
            padding: 20px;
            margin: 20px 0;
            border-radius: 8px;
        }
        .info-item {
            margin: 12px 0;
        }
        .info-label {
            font-weight: 600;
            color: #4b5563;
            display: inline-block;
            min-width: 140px;
        }
        .info-value {
            color: #1f2937;
        }
        .alert {
            background-color: #fef3c7;
            border-left: 4px solid #f59e0b;
            padding: 16px;
            margin: 20px 0;
            border-radius: 8px;
        }
        .button {
            display: inline-block;
            padding: 16px 32px;
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white !important;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 600;
            font-size: 16px;
            margin: 20px 0;
            box-shadow: 0 4px 6px rgba(16, 185, 129, 0.3);
        }
        .button:hover {
            background: linear-gradient(135deg, #059669 0%, #047857 100%);
        }
        .footer {
            background-color: #f9fafb;
            padding: 30px;
            text-align: center;
            color: #6b7280;
            font-size: 14px;
        }
        .warning-box {
            background-color: #fee2e2;
            border-left: 4px solid #ef4444;
            padding: 16px;
            margin: 20px 0;
            border-radius: 8px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>📦 Pickup Request Received</h1>
            <p>Someone wants to collect your donation</p>
        </div>
        
        <div class="content">
            <h2>Hello {{ $donation->user->name }},</h2>
            
            <p>Good news! <strong>{{ $receiver->name }}</strong> has scheduled a pickup for your donation.</p>
            
            <div class="info-box">
                <h3 style="margin-top: 0; color: #4f46e5;">Your Donation</h3>
                <div class="info-item">
                    <span class="info-label">Category:</span>
                    <span class="info-value">{{ $donation->category }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Portions:</span>
                    <span class="info-value">{{ $donation->quantity }} servings</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Location:</span>
                    <span class="info-value">{{ $donation->city ?? 'Not specified' }}</span>
                </div>
            </div>

            <div class="info-box">
                <h3 style="margin-top: 0; color: #059669;">Pickup Details</h3>
                <div class="info-item">
                    <span class="info-label">Requested by:</span>
                    <span class="info-value">{{ $receiver->name }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Scheduled Date:</span>
                    <span class="info-value">{{ \Carbon\Carbon::parse($pickup->scheduled_at)->format('l, F j, Y') }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Scheduled Time:</span>
                    <span class="info-value">{{ \Carbon\Carbon::parse($pickup->scheduled_at)->format('g:i A') }}</span>
                </div>
                @if($pickup->notes)
                <div class="info-item">
                    <span class="info-label">Notes:</span>
                    <span class="info-value">{{ $pickup->notes }}</span>
                </div>
                @endif
            </div>

            <div class="alert">
                <strong>⚠️ Action Required</strong>
                <p style="margin: 8px 0 0;">Please confirm this pickup to proceed. Click the button below to accept.</p>
            </div>

            <center>
                <a href="{{ url('/pickups/confirm/' . $confirmationToken) }}" class="button">
                    ✓ Confirm Pickup
                </a>
            </center>

            <div class="warning-box">
                <strong>Important:</strong>
                <ul style="margin: 8px 0; padding-left: 20px;">
                    <li>Once you confirm, this donation will be removed from the site</li>
                    <li>This ensures no one else can request the same donation</li>
                    <li>If you cannot fulfill this pickup, please ignore this email</li>
                </ul>
            </div>

            <p style="margin-top: 30px; color: #6b7280; font-size: 14px;">
                If the button doesn't work, copy and paste this link in your browser:<br>
                <a href="{{ url('/pickups/confirm/' . $confirmationToken) }}" style="color: #6366f1; word-break: break-all;">
                    {{ url('/pickups/confirm/' . $confirmationToken) }}
                </a>
            </p>
        </div>
        
        <div class="footer">
            <p><strong>FoodShare</strong> - Share Food, Share Hope</p>
            <p>Questions? Contact us at <a href="mailto:support@foodshare.com" style="color: #6366f1;">support@foodshare.com</a></p>
            <p style="margin-top: 16px; font-size: 12px;">
                This email was sent because a pickup was scheduled for your donation.<br>
                If you didn't create this donation, please contact support immediately.
            </p>
        </div>
    </div>
</body>
</html>