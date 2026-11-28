<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thank you for contacting {{ config('site.name') }}</title>
</head>
<body style="margin:0; padding:0; background-color:#f4f4f5; font-family:Arial, Helvetica, sans-serif;">
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color:#f4f4f4; padding:24px 0;">
        <tr>
            <td align="center">
                <table role="presentation" width="600" cellpadding="0" cellspacing="0" style="max-width:600px; width:100%; background-color:#ffffff; border-radius:8px; overflow:hidden;">

                    <!-- Header -->
                    <tr>
                        <td style="background-color:#0f172a; padding:28px 32px; text-align:center;">
                            <h1 style="margin:0; color:#ffffff; font-size:22px; font-weight:700;">{{ config('site.name') }}</h1>
                            <p style="margin:6px 0 0; color:#94a3b8; font-size:13px;">{{ config('site.tagline') }}</p>
                        </td>
                    </tr>

                    <!-- Greeting -->
                    <tr>
                        <td style="padding:32px 32px 8px;">
                            <h2 style="margin:0 0 12px; color:#0f172a; font-size:19px;">Dear {{ $name }},</h2>
                            <p style="margin:0 0 16px; color:#334155; font-size:15px; line-height:1.6;">
                                Thank you for contacting us. We have received your enquiry{{ isset($service) && $service ? ' regarding ' . $service : '' }} and our team will get back to you shortly.
                            </p>
                            <p style="margin:0 0 8px; color:#334155; font-size:15px; line-height:1.6;">
                                For an immediate response, feel free to call or WhatsApp us any time — we are available 24/7.
                            </p>
                        </td>
                    </tr>

                    <!-- Call to action -->
                    <tr>
                        <td style="padding:8px 32px 24px;" align="center">
                            <table role="presentation" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td align="center" bgcolor="#f59e0b" style="border-radius:6px;">
                                        <a href="https://wa.me/{{ config('site.whatsapp') }}" style="display:inline-block; padding:12px 28px; color:#0f172a; font-weight:700; font-size:15px; text-decoration:none;">
                                            WhatsApp: {{ config('site.phone') }}
                                        </a>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Services we offer -->
                    <tr>
                        <td style="padding:0 32px 8px;">
                            <h3 style="margin:0 0 10px; color:#0f172a; font-size:16px;">Our Services in UAE</h3>
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="font-size:14px; color:#334155;">
                                @foreach ([
                                    'Concrete Scanning',
                                    'Core Cutting',
                                    'Slab Cutting',
                                    'Wall Cutting',
                                    'Door Cutting',
                                    'Stairs Cutting',
                                    'AC Duct Cutting',
                                    'Concrete Cutting',
                                    'Lift Cutting',
                                    'Beam Cutting',
                                    'Controlled Demolition',
                                ] as $serviceItem)
                                    <tr>
                                        <td style="padding:3px 0; line-height:1.5;">✅ {{ $serviceItem }}</td>
                                    </tr>
                                @endforeach
                            </table>
                        </td>
                    </tr>

                    <!-- Contact details -->
                    <tr>
                        <td style="padding:20px 32px 28px;">
                            <div style="background-color:#f8fafc; border-left:4px solid #f59e0b; padding:16px 20px; border-radius:4px;">
                                <p style="margin:0 0 6px; font-size:15px; color:#0f172a;"><strong>Mr. Shahid</strong> — {{ config('site.phone') }}</p>
                                <p style="margin:0 0 6px; font-size:14px; color:#334155;">Email: <a href="mailto:{{ config('site.email') }}" style="color:#b45309;">{{ config('site.email') }}</a></p>
                                <p style="margin:0; font-size:14px; color:#334155;">Web: <a href="https://www.qualitycorecuttinguae.com" style="color:#b45309;">www.qualitycorecuttinguae.com</a></p>
                            </div>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="background-color:#0f172a; padding:18px 32px; text-align:center;">
                            <p style="margin:0; color:#94a3b8; font-size:12px;">
                                {{ config('site.name') }} — {{ config('site.hours') }}<br>
                                Serving: {{ implode(' • ', config('site.area_served')) }}
                            </p>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
</body>
</html>
