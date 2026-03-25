<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: Arial, sans-serif; background-color: #f3f4f6; margin: 0; padding: 0; }
        .container { max-width: 600px; margin: 40px auto; background: white; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
        .header { background: linear-gradient(135deg, #6b7280 0%, #4b5563 100%); color: white; padding: 40px 30px; text-align: center; }
        .header h1 { margin: 0; font-size: 28px; }
        .content { padding: 40px 30px; }
        .info-box { background: #f9fafb; border-left: 4px solid #6b7280; padding: 20px; margin: 20px 0; border-radius: 8px; }
        .button { display: inline-block; padding: 14px 28px; background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: white; text-decoration: none; border-radius: 8px; font-weight: 600; margin: 20px 0; }
        .footer { background: #f9fafb; padding: 30px; text-align: center; color: #6b7280; font-size: 14px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Volunteer Request Update</h1>
            <p>About your volunteer application</p>
        </div>
        
        <div class="content">
            <h2>Hello {{ $volunteer->user->name }},</h2>
            
            <p>Thank you for your interest in volunteering for the food donation by <strong>{{ $donation->user->name }}</strong>.</p>
            
            <p>Unfortunately, the donor has decided to proceed with other volunteers for this particular donation.</p>

            <div class="info-box">
                <h3 style="margin-top: 0; color: #4b5563;">Donation Details</h3>
                <p style="margin: 8px 0; color: #6b7280;">
                    <strong>Food Type:</strong> {{ $donation->category }}<br>
                    <strong>Quantity:</strong> {{ $donation->quantity }} portions<br>
                    <strong>Location:</strong> {{ $donation->city }}, {{ $donation->postal_code }}
                </p>
            </div>

            <p><strong>Don't be discouraged!</strong> There are many other opportunities to help:</p>
            
            <ul style="color: #374151; line-height: 1.8;">
                <li>Browse other donations that need volunteers</li>
                <li>Your profile is still active and ready for new requests</li>
                <li>Keep making a difference in your community</li>
            </ul>

            <center>
                <a href="{{ url('/volunteer/needs') }}" class="button">
                    Find Other Opportunities
                </a>
            </center>
        </div>
        
        <div class="footer">
            <p><strong>FoodShare</strong> - Share Food, Share Hope</p>
            <p style="margin-top: 16px;">Thank you for your commitment to helping others!</p>
        </div>
    </div>
</body>
</html>