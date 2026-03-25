<!-- resources/views/emails/place-request-accepted.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: white; padding: 30px; border-radius: 10px 10px 0 0; text-align: center; }
        .content { background: #f9fafb; padding: 30px; border-radius: 0 0 10px 10px; }
        .success-box { background: #d1fae5; padding: 20px; border-radius: 8px; margin: 20px 0; border-left: 4px solid #10b981; }
        .info-section { background: white; padding: 20px; border-radius: 8px; margin: 20px 0; }
        .note-box { background: #fef3c7; padding: 15px; border-radius: 8px; border-left: 4px solid #f59e0b; }
        .button { display: inline-block; padding: 12px 30px; text-decoration: none; border-radius: 8px; font-weight: bold; margin: 5px; }
        .btn-calendar { background: #EA4335; color: white; }
        .btn-map { background: #3b82f6; color: white; }
        .btn-directions { background: #059669; color: white; }
        .button-group { text-align: center; margin: 20px 0; }
        .footer { text-align: center; margin-top: 20px; color: #6b7280; font-size: 12px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1 style="margin: 0;">✅ Request Approved!</h1>
        </div>
        <div class="content">
            <p>Great news {{ $placeRequest->user->name }}!</p>
            <p>Your request for <strong>{{ $place->title }}</strong> has been approved.</p>
            
            <div class="success-box">
                <h3 style="margin-top: 0; color: #059669;">✓ Your request is confirmed</h3>
                <p style="margin-bottom: 0;">You can now proceed with your plans.</p>
            </div>

            <div class="info-section">
                <h4 style="color: #374151; margin-top: 0;">📅 Details</h4>
                @if($placeRequest->scheduled_date)
                <p><strong>Date:</strong> {{ \Carbon\Carbon::parse($placeRequest->scheduled_date)->format('l, F j, Y - g:i A') }}</p>
                @endif
                <p><strong>Location:</strong> {{ $place->address }}</p>
                @if($place->city)
                <p><strong>City:</strong> {{ $place->city }}</p>
                @endif
                <p><strong>Contact:</strong> {{ $place->contact_info }}</p>
            </div>

            @if($placeRequest->partner_note)
            <div class="note-box">
                <p style="margin: 0;"><strong>📝 Note from owner:</strong></p>
                <p style="margin: 10px 0 0 0;">{{ $placeRequest->partner_note }}</p>
            </div>
            @endif

            <!-- Action Buttons -->
            <div class="button-group">
                @php
                    $eventDate = \Carbon\Carbon::parse($placeRequest->scheduled_date);
                    $eventTitle = urlencode('Visit: ' . $place->title);
                    $eventDetails = urlencode($place->description . "\n\nLocation: " . $place->address . "\nContact: " . $place->contact_info);
                    $eventLocation = urlencode($place->address);
                    $eventStart = $eventDate->format('Ymd\THis');
                    $eventEnd = $eventDate->addHour()->format('Ymd\THis');
                    
                    // Google Calendar Link
                    $calendarLink = "https://calendar.google.com/calendar/render?action=TEMPLATE&text={$eventTitle}&dates={$eventStart}/{$eventEnd}&details={$eventDetails}&location={$eventLocation}";
                    
                    // Google Maps Directions
                    $mapsLink = $place->google_maps_link ?: "https://www.google.com/maps/dir/?api=1&destination=" . urlencode($place->address);
                    
                    // Coordinates-based directions if available
                    if($place->latitude && $place->longitude) {
                        $directionsLink = "https://www.google.com/maps/dir/?api=1&destination={$place->latitude},{$place->longitude}";
                    } else {
                        $directionsLink = $mapsLink;
                    }
                @endphp
                
                <a href="{{ $calendarLink }}" target="_blank" class="button btn-calendar">
                    📅 Add to Google Calendar
                </a>
                
                <br>
                
                <a href="{{ $directionsLink }}" target="_blank" class="button btn-directions">
                    🗺️ Get Directions
                </a>
                
                @if($place->google_maps_link)
                <a href="{{ $place->google_maps_link }}" target="_blank" class="button btn-map">
                    📍 View Location
                </a>
                @endif
            </div>

            <!-- Manual Links (if buttons don't work) -->
            <div style="background: #f3f4f6; padding: 15px; border-radius: 8px; margin-top: 20px;">
                <p style="margin: 0; font-size: 12px; color: #6b7280;"><strong>If the buttons don't work, copy these links:</strong></p>
                <p style="margin: 5px 0 0 0; font-size: 11px; color: #9ca3af; word-break: break-all;">
                    <strong>Calendar:</strong> {{ $calendarLink }}<br>
                    <strong>Directions:</strong> {{ $directionsLink }}
                </p>
            </div>

            <div style="background: #e0f2fe; padding: 15px; border-radius: 8px; margin-top: 20px;">
                <p style="margin: 0; font-size: 14px; color: #0c4a6e;">
                    <strong>Next steps:</strong><br>
                    • Add the event to your calendar<br>
                    • Save the contact information<br>
                    • Plan your route in advance<br>
                    • Arrive on time<br>
                    • Respect the place and its rules
                </p>
            </div>
        </div>
        <div class="footer">
            <p>© {{ date('Y') }} FoodShare. All rights reserved.</p>
        </div>
    </div>
</body>
</html>