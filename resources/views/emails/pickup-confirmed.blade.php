<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: Arial, sans-serif; background-color: #f3f4f6; margin: 0; padding: 0; }
        .container { max-width: 600px; margin: 40px auto; background: white; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
        .header { background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: white; padding: 40px 30px; text-align: center; }
        .header h1 { margin: 0; font-size: 28px; }
        .content { padding: 40px 30px; }
        .info-box { background: #f9fafb; border-left: 4px solid #10b981; padding: 20px; margin: 20px 0; border-radius: 8px; }
        .info-item { margin: 12px 0; }
        .info-label { font-weight: 600; color: #4b5563; display: inline-block; min-width: 140px; }
        .button { display: inline-block; padding: 14px 28px; background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: white; text-decoration: none; border-radius: 8px; font-weight: 600; margin: 20px 0; }
        .footer { background: #f9fafb; padding: 30px; text-align: center; color: #6b7280; font-size: 14px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>✅ Pickup Confirmed!</h1>
            <p>The donor has accepted your pickup request</p>
        </div>
        
        <div class="content">
            <h2>Hello {{ $pickup->user->name }},</h2>
            
            <p>Great news! The donor <strong>{{ $donation->user->name }}</strong> has confirmed your pickup request.</p>
            
            <div class="info-box">
                <h3 style="margin-top: 0; color: #059669;">Pickup Details</h3>
                <div class="info-item">
                    <span class="info-label">Donation:</span>
                    <span>{{ $donation->category }} ({{ $donation->quantity }} portions)</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Scheduled:</span>
                    <span>{{ \Carbon\Carbon::parse($pickup->scheduled_at)->format('l, F j, Y \a\t g:i A') }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Location:</span>
                    <span>{{ $donation->city ?? 'Not specified' }}</span>
                </div>
                @if($pickup->notes)
                <div class="info-item">
                    <span class="info-label">Your Notes:</span>
                    <span>{{ $pickup->notes }}</span>
                </div>
                @endif
            </div>

            <p><strong>Next Steps:</strong></p>
            <ul>
                <li>Be ready at the scheduled time</li>
                <li>Contact the donor if you need to confirm details</li>
                <li>Thank you for helping reduce food waste!</li>
            </ul>
            
            <center>
                <a href="{{ url('/pickups') }}" class="button">View My Pickups</a>
            </center>
        </div>
        
        <div class="footer">
            <p><strong>FoodShare</strong> - Share Food, Share Hope</p>
        </div>
    </div>
</body>
</html>