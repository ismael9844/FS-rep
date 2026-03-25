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
        .info-label { font-weight: 600; color: #4b5563; display: inline-block; min-width: 120px; }
        .button { display: inline-block; padding: 16px 32px; background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); color: white; text-decoration: none; border-radius: 8px; font-weight: 600; margin: 20px 0; }
        .note-box { background: #fef3c7; border-left: 4px solid #f59e0b; padding: 16px; margin: 20px 0; border-radius: 8px; }
        .footer { background: #f9fafb; padding: 30px; text-align: center; color: #6b7280; font-size: 14px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>✅ Volunteer Request Accepted!</h1>
            <p>You've been approved to help with this donation</p>
        </div>
        
        <div class="content">
            <h2>Hello {{ $volunteer->user->name }},</h2>
            
            <p>Great news! <strong>{{ $donation->user->name }}</strong> has accepted your volunteer request.</p>
            
            <div class="info-box">
                <h3 style="margin-top: 0; color: #059669;">Donation Details</h3>
                <div class="info-item">
                    <span class="info-label">Food Type:</span>
                    <span>{{ $donation->category }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Quantity:</span>
                    <span>{{ $donation->quantity }} portions</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Available:</span>
                    <span>{{ \Carbon\Carbon::parse($donation->available_from)->format('M j, Y') }} - {{ \Carbon\Carbon::parse($donation->available_until)->format('M j, Y') }}</span>
                </div>
            </div>

            <div class="info-box">
                <h3 style="margin-top: 0; color: #2563eb;">📍 Location</h3>
                <div class="info-item">
                    <span class="info-label">Address:</span>
                    <span>{{ $donation->city }}, {{ $donation->postal_code }}</span>
                </div>
                @if($donation->latitude && $donation->longitude)
                <div style="margin-top: 20px; text-align: center;">
                    <a href="https://www.google.com/maps/dir/?api=1&destination={{ $donation->latitude }},{{ $donation->longitude }}" 
                       class="button" 
                       style="display: inline-block;">
                        🗺️ Get Directions on Google Maps
                    </a>
                </div>
                @endif
            </div>

            @if($donation->volunteer_note)
            <div class="note-box">
                <h3 style="margin-top: 0; color: #f59e0b;">📝 Note from Donor</h3>
                <p style="margin: 8px 0; color: #92400e;">{{ $donation->volunteer_note }}</p>
            </div>
            @endif

            <div class="info-box">
                <h3 style="margin-top: 0; color: #059669;">Next Steps</h3>
                <ul style="margin: 8px 0; padding-left: 20px; color: #374151;">
                    <li>Review the location and plan your route</li>
                    <li>Contact the donor if you need additional details</li>
                    <li>Be ready to help distribute the food</li>
                    <li>Thank you for making a difference in your community!</li>
                </ul>
            </div>
        </div>
        
        <div class="footer">
            <p><strong>FoodShare</strong> - Share Food, Share Hope</p>
            <p style="margin-top: 16px; font-size: 12px;">
                Questions? Contact us at <a href="mailto:support@foodshare.com" style="color: #10b981;">support@foodshare.com</a>
            </p>
        </div>
    </div>
</body>
</html>