<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pickup Scheduled</title>
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
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
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
            border-left: 4px solid #10b981;
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
            background-color: #dbeafe;
            border-left: 4px solid #3b82f6;
            padding: 16px;
            margin: 20px 0;
            border-radius: 8px;
        }
        .footer {
            background-color: #f9fafb;
            padding: 30px;
            text-align: center;
            color: #6b7280;
            font-size: 14px;
        }
        .button {
            display: inline-block;
            padding: 14px 28px;
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 600;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>✅ Pickup Scheduled Successfully!</h1>
            <p>Your food pickup has been confirmed</p>
        </div>
        
        <div class="content">
            <h2>Hello {{ $receiver->name }},</h2>
            
            <p>Your pickup request has been scheduled successfully. The donor will receive a confirmation email and must accept the pickup.</p>
            
            <div class="info-box">
                <h3 style="margin-top: 0; color: #059669;">Donation Details</h3>
                <div class="info-item">
                    <span class="info-label">Category:</span>
                    <span class="info-value">{{ $donation->category }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Portions:</span>
                    <span class="info-value">{{ $donation->quantity }} servings</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Donor:</span>
                    <span class="info-value">{{ $donation->user->name }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Location:</span>
                    <span class="info-value">{{ $donation->city ?? 'Not specified' }}</span>
                </div>
            </div>

            <div class="info-box">
                <h3 style="margin-top: 0; color: #3b82f6;">Pickup Information</h3>
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
                <strong>⏳ Awaiting Confirmation</strong>
                <p style="margin: 8px 0 0;">The donor will receive an email with a confirmation link. Once they confirm, you'll receive a final confirmation email.</p>
            </div>

            <p style="margin-top: 30px;">You can view your pickups anytime from your dashboard.</p>
            
            <center>
                <a href="{{ url('/pickups') }}" class="button">View My Pickups</a>
            </center>
        </div>
        
        <div class="footer">
            <p><strong>FoodShare</strong> - Share Food, Share Hope</p>
            <p>Questions? Contact us at <a href="mailto:support@foodshare.com" style="color: #10b981;">support@foodshare.com</a></p>
        </div>
    </div>
</body>
</html>