<!-- resources/views/emails/place-request-rejected.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: linear-gradient(135deg, #6b7280 0%, #4b5563 100%); color: white; padding: 30px; border-radius: 10px 10px 0 0; text-align: center; }
        .content { background: #f9fafb; padding: 30px; border-radius: 0 0 10px 10px; }
        .info-box { background: white; padding: 20px; border-radius: 8px; margin: 20px 0; }
        .button { display: inline-block; padding: 12px 30px; background: #10b981; color: white; text-decoration: none; border-radius: 8px; font-weight: bold; }
        .footer { text-align: center; margin-top: 20px; color: #6b7280; font-size: 12px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1 style="margin: 0;">Request Update</h1>
        </div>
        <div class="content">
            <p>Hello,</p>
            <p>We're writing to inform you about your request for <strong>{{ $place->title }}</strong>.</p>
            
            <div class="info-box">
                <p>Unfortunately, this request could not be approved at this time. This may be due to availability, scheduling conflicts, or other reasons.</p>
            </div>

            <p>Don't worry! There are many other places available on our platform.</p>

            <div style="text-align: center; margin: 30px 0;">
                <a href="{{ url('/places') }}" class="button">🔍 Explore Other Places</a>
            </div>

            <p style="font-size: 14px; color: #6b7280; text-align: center;">
                Thank you for using FoodShare!
            </p>
        </div>
        <div class="footer">
            <p>© {{ date('Y') }} FoodShare. All rights reserved.</p>
        </div>
    </div>
</body>
</html>