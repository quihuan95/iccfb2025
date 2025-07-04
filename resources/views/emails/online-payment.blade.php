<div style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
  <p>
    Dear <strong>{{ $registration['display_title'] }} {{ $registration['fullname'] }}</strong>,
  </p>

  <p>
    Your registration has been received. Please save this email for future reference.
  </p>

  <p>
    <strong>Event:</strong> The 7<sup>th</sup> International Conference on Chemical Engineering, Food and Bio Technology (ICCFB 2025)<br>
    <strong>Date:</strong> July 24 – 26, 2025<br>
    <strong>Venue:</strong> SAIGON PRINCE HOTEL, 59–73 Nguyen Hue Boulevard, District 1, Ho Chi Minh City, Vietnam
  </p>

  <h3 style="margin-top: 15px; margin-bottom: 5px;">Registration Details:</h3>
  <p style="margin-top: 5px; margin-bottom: 5px;">
    <strong>Registration No.:</strong> {{ $registration['registration_code'] }}<br>
    <strong>Full name:</strong> {{ $registration['display_title'] }} {{ $registration['fullname'] }}<br>
    <strong>Organization:</strong> {{ $registration['organization'] }}<br>
    <strong>Country:</strong> {{ $registration['display_country'] }}<br>
    <strong>Email:</strong> {{ $registration['email'] }}<br>
    <strong>Dietary Requirements:</strong> {{ $registration['display_dietary_requirement'] }}
  </p>

  <h3 style="margin-top: 15px; margin-bottom: 5px;">Conference Fee:</h3>
  <p style="margin-top: 5px; margin-bottom: 5px;">
    <strong>Conference type:</strong> {{ $registration['display_conference']['label'] ?? 'N/A' }}<br>
    <strong>Total fee:</strong>
    {{ ($registration['display_conference']['currency'] ?? 'USD') === 'VND'
        ? 'VND ' . number_format($registration['display_conference']['fee'], 0, ',', '.')
        : ($registration['display_conference']['currency'] ?? 'USD') . ' ' . number_format($registration['display_conference']['fee'], 2) }}<br>
    <strong>Payment type:</strong> Online Payment<br>
    <strong>Payment status:</strong> {{ ucfirst($registration['payment_status'] ?? 'Pending') }}
  </p>

  <p>
    If you need any further assistance, please feel free to contact us at
    <a href="mailto:iccfb@hcmut.edu.vn">iccfb@hcmut.edu.vn</a> &
    <a href="mailto:dh.qt2@hoabinh-group.com">dh.qt2@hoabinh-group.com</a>.
  </p>

  <p>We look forward to seeing you in Ho Chi Minh City!</p>

  <p>
    Kind regards,<br>
    <strong>ICCFB 2025 Registration Team!</strong>
  </p>
</div>
