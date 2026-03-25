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
            <h1>Contribution Offer Update</h1>
            <p>About your food contribution offer</p>
        </div>
        
        <div class="content">
            <h2>Hello {{ $foodOffer->user->name }},</h2>
            
            <p>Thank you for your generous offer to contribute food to <strong>{{ $foodRequest->title }}</strong>.</p>
            
            <p>Unfortunately, the partner has decided not to proceed with this particular contribution at this time.</p>

            <div class="info-box">
                <h3 style="margin-top: 0; color: #4b5563;">Your Offer</h3>
                <p style="margin: 8px 0; color: #6b7280;">
                    <strong>Quantity:</strong> {{ $foodOffer->quantity }} portions<br>
                    <strong>Request:</strong> {{ $foodRequest->title }}
                </p>
            </div>

            <p><strong>Don't be discouraged!</strong> There are many other ways to help:</p>
            
            <ul style="color: #374151; line-height: 1.8;">
                <li>Browse other food requests that need contributions</li>
                <li>Your generosity is appreciated in the community</li>
                <li>Keep making a difference!</li>
            </ul>

            <center>
                <a href="{{ url('/requests') }}" class="button">
                    Find Other Requests
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