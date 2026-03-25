<!-- resources/views/emails/place-request-notification.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: white; padding: 30px; border-radius: 10px 10px 0 0; text-align: center; }
        .content { background: #f9fafb; padding: 30px; border-radius: 0 0 10px 10px; }
        .info-box { background: white; padding: 20px; border-radius: 8px; margin: 20px 0; border-left: 4px solid #10b981; }
        .button { display: inline-block; padding: 12px 30px; margin: 10px 5px; border-radius: 8px; text-decoration: none; font-weight: bold; }
        .btn-accept { background: #10b981; color: white; }
        .btn-decline { background: #ef4444; color: white; }
        .footer { text-align: center; margin-top: 20px; color: #6b7280; font-size: 12px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1 style="margin: 0;">📍 New Place Request</h1>
        </div>
        <div class="content">
            <p>Hello,</p>
            <p>You have received a new request for your place:</p>
            
            <div class="info-box">
                <h3 style="margin-top: 0; color: #10b981;">{{ $place->title }}</h3>
                <p><strong>Requested by:</strong> {{ $requester->name }}</p>
                <p><strong>Message:</strong> {{ $placeRequest->message }}</p>
                <p><strong>Requested on:</strong> {{ $placeRequest->created_at->format('M d, Y H:i') }}</p>
            </div>

            <div style="text-align: center; margin: 30px 0;">
                <a href="{{ url('/place-requests/accept/' . $token) }}" class="button btn-accept">✓ Accept Request</a>
                <a href="{{ url('/place-requests/decline/' . $token) }}" class="button btn-decline">✗ Decline Request</a>
            </div>

            <p style="font-size: 14px; color: #6b7280;">
                If the buttons don't work, copy and paste these links:<br>
                Accept: {{ url('/place-requests/accept/' . $token) }}<br>
                Decline: {{ url('/place-requests/decline/' . $token) }}
            </p>
        </div>
        <div class="footer">
            <p>© {{ date('Y') }} FoodShare. All rights reserved.</p>
        </div>
    </div>
</body>
</html>