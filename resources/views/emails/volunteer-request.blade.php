<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: Arial, sans-serif; background-color: #f3f4f6; margin: 0; padding: 0; }
        .container { max-width: 600px; margin: 40px auto; background: white; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
        .header { background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); color: white; padding: 40px 30px; text-align: center; }
        .header h1 { margin: 0; font-size: 28px; }
        .content { padding: 40px 30px; }
        .info-box { background: #f9fafb; border-left: 4px solid #3b82f6; padding: 20px; margin: 20px 0; border-radius: 8px; }
        .info-item { margin: 12px 0; }
        .info-label { font-weight: 600; color: #4b5563; display: inline-block; min-width: 120px; }
        .buttons { display: flex; gap: 12px; margin: 30px 0; }
        .button { flex: 1; display: inline-block; padding: 16px 24px; text-align: center; text-decoration: none; border-radius: 8px; font-weight: 600; }
        .accept { background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: white; }
        .decline { background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); color: white; }
        .footer { background: #f9fafb; padding: 30px; text-align: center; color: #6b7280; font-size: 14px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🙋 New Volunteer Request</h1>
            <p>Someone wants to help with your donation</p>
        </div>
        
        <div class="content">
            <h2>Hello {{ $donation->user->name }},</h2>
            
            <p><strong>{{ $volunteerUser->name }}</strong> has volunteered to help distribute your donation!</p>
            
            <div class="info-box">
                <h3 style="margin-top: 0; color: #2563eb;">Volunteer Details</h3>
                <div class="info-item">
                    <span class="info-label">Name:</span>
                    <span>{{ $volunteerUser->name }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Phone:</span>
                    <span>{{ $volunteer->phone }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Skills:</span>
                    <span>{{ $volunteer->skills }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Availability:</span>
                    <span>{{ $volunteer->availability }}</span>
                </div>
            </div>

            <div class="info-box">
                <h3 style="margin-top: 0; color: #059669;">Your Donation</h3>
                <div class="info-item">
                    <span class="info-label">Food Type:</span>
                    <span>{{ $donation->category }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Quantity:</span>
                    <span>{{ $donation->quantity }} portions</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Location:</span>
                    <span>{{ $donation->city }}, {{ $donation->postal_code }}</span>
                </div>
            </div>

            <p><strong>Would you like to accept this volunteer?</strong></p>
            
            <div class="buttons">
                <a href="{{ url('/volunteers/accept/' . $confirmationToken) }}" class="button accept">
                    ✓ Accept Volunteer
                </a>
                <a href="{{ url('/volunteers/decline/' . $confirmationToken) }}" class="button decline">
                    ✗ Decline
                </a>
            </div>

            <p style="color: #6b7280; font-size: 14px; margin-top: 30px;">
                If the buttons don't work, copy and paste these links:<br>
                <strong>Accept:</strong> {{ url('/volunteers/accept/' . $confirmationToken) }}<br>
                <strong>Decline:</strong> {{ url('/volunteers/decline/' . $confirmationToken) }}
            </p>
        </div>
        
        <div class="footer">
            <p><strong>FoodShare</strong> - Share Food, Share Hope</p>
        </div>
    </div>
</body>
</html>