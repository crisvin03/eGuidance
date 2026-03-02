<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointment Confirmed</title>
</head>
<body style="margin:0;padding:0;background-color:#f0f4f8;font-family:'Segoe UI',Arial,sans-serif;">

    <!-- Outer wrapper -->
    <table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:#f0f4f8;padding:40px 0;">
        <tr>
            <td align="center">
                <table width="600" cellpadding="0" cellspacing="0" border="0" style="max-width:600px;width:100%;">

                    <!-- Header -->
                    <tr>
                        <td style="background:linear-gradient(135deg,#20B2AA 0%,#008B8B 100%);border-radius:12px 12px 0 0;padding:36px 40px;text-align:center;">
                            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                <tr>
                                    <td align="center">
                                        <div style="display:inline-block;background:rgba(255,255,255,0.2);border-radius:50%;width:54px;height:54px;line-height:54px;text-align:center;margin-bottom:12px;">
                                            <span style="font-size:24px;">&#128197;</span>
                                        </div>
                                        <h1 style="margin:0;color:#ffffff;font-size:22px;font-weight:700;letter-spacing:0.5px;">SIGMA</h1>
                                        <p style="margin:4px 0 0;color:rgba(255,255,255,0.85);font-size:12px;letter-spacing:1px;text-transform:uppercase;">Guidance Portal</p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Status badge row -->
                    <tr>
                        <td style="background:#ffffff;padding:28px 40px 0;text-align:center;">
                            <span style="display:inline-block;background:#ecfdf5;color:#059669;border:1px solid #a7f3d0;border-radius:20px;padding:6px 20px;font-size:13px;font-weight:600;letter-spacing:0.3px;">
                                &#10003;&nbsp; Appointment Confirmed
                            </span>
                        </td>
                    </tr>

                    <!-- Body -->
                    <tr>
                        <td style="background:#ffffff;padding:24px 40px 32px;">
                            <h2 style="margin:0 0 6px;color:#1a3a3a;font-size:20px;font-weight:700;">Your Appointment is Confirmed</h2>
                            <p style="margin:0 0 20px;color:#6b7280;font-size:14px;">Your counseling session has been officially confirmed.</p>

                            <p style="margin:0 0 20px;color:#374151;font-size:15px;line-height:1.6;">
                                Dear <strong style="color:#1a3a3a;">{{ $appointment->student->name }}</strong>,
                                <br>great news! Your counseling appointment has been confirmed by your counselor. Please review the details below.
                            </p>

                            <!-- Info card -->
                            <table width="100%" cellpadding="0" cellspacing="0" border="0" style="background:#f8fffe;border:1px solid #b2dfdb;border-radius:10px;margin-bottom:24px;">
                                <tr>
                                    <td style="padding:20px 24px;">
                                        <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                            <tr>
                                                <td style="padding:8px 0;border-bottom:1px solid #e0f2f1;">
                                                    <span style="color:#6b7280;font-size:12px;text-transform:uppercase;letter-spacing:0.5px;font-weight:600;">Counselor</span>
                                                    <p style="margin:4px 0 0;color:#1a3a3a;font-size:15px;font-weight:600;">{{ $appointment->counselor->name }}</p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="padding:8px 0;border-bottom:1px solid #e0f2f1;">
                                                    <span style="color:#6b7280;font-size:12px;text-transform:uppercase;letter-spacing:0.5px;font-weight:600;">Appointment Date &amp; Time</span>
                                                    <p style="margin:4px 0 0;color:#20B2AA;font-size:16px;font-weight:700;">{{ $appointment->appointment_date->format('l, F d, Y') }}</p>
                                                    <p style="margin:2px 0 0;color:#374151;font-size:14px;">{{ $appointment->appointment_date->format('h:i A') }}</p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="padding:8px 0;{{ $appointment->notes ? 'border-bottom:1px solid #e0f2f1;' : '' }}">
                                                    <span style="color:#6b7280;font-size:12px;text-transform:uppercase;letter-spacing:0.5px;font-weight:600;">Status</span>
                                                    <p style="margin:4px 0 0;">
                                                        <span style="display:inline-block;background:#ecfdf5;color:#059669;border-radius:12px;padding:3px 12px;font-size:13px;font-weight:600;">Confirmed</span>
                                                    </p>
                                                </td>
                                            </tr>
                                            @if($appointment->notes)
                                            <tr>
                                                <td style="padding:8px 0 0;">
                                                    <span style="color:#6b7280;font-size:12px;text-transform:uppercase;letter-spacing:0.5px;font-weight:600;">Notes</span>
                                                    <p style="margin:4px 0 0;color:#374151;font-size:14px;line-height:1.5;">{{ $appointment->notes }}</p>
                                                </td>
                                            </tr>
                                            @endif
                                        </table>
                                    </td>
                                </tr>
                            </table>

                            @if($appointment->concern)
                            <!-- Related concern -->
                            <table width="100%" cellpadding="0" cellspacing="0" border="0" style="background:#f8fafc;border:1px solid #e2e8f0;border-radius:8px;margin-bottom:24px;">
                                <tr>
                                    <td style="padding:14px 20px;">
                                        <p style="margin:0 0 4px;color:#64748b;font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:0.5px;">Related Concern</p>
                                        <p style="margin:0;color:#1a3a3a;font-size:14px;font-weight:600;">{{ $appointment->concern->title }}</p>
                                    </td>
                                </tr>
                            </table>
                            @endif

                            <!-- Reminder box -->
                            <table width="100%" cellpadding="0" cellspacing="0" border="0" style="background:#fffbeb;border:1px solid #fde68a;border-radius:8px;margin-bottom:28px;">
                                <tr>
                                    <td style="padding:14px 20px;">
                                        <p style="margin:0;color:#92400e;font-size:13px;line-height:1.6;">
                                            <strong>&#9888; Reminder:</strong> Please be present at the scheduled date and time. If you need to reschedule or cancel, log in to the portal as soon as possible.
                                        </p>
                                    </td>
                                </tr>
                            </table>

                            <!-- CTA Button -->
                            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                <tr>
                                    <td align="center">
                                        <a href="{{ url('/student/appointments') }}"
                                           style="display:inline-block;background:linear-gradient(135deg,#20B2AA 0%,#008B8B 100%);color:#ffffff;text-decoration:none;padding:14px 36px;border-radius:8px;font-size:15px;font-weight:700;letter-spacing:0.3px;">
                                            View My Appointments &rarr;
                                        </a>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Divider -->
                    <tr>
                        <td style="background:#ffffff;padding:0 40px;">
                            <hr style="border:none;border-top:1px solid #e5e7eb;margin:0;">
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="background:#ffffff;border-radius:0 0 12px 12px;padding:20px 40px;text-align:center;">
                            <p style="margin:0 0 4px;color:#1a3a3a;font-size:13px;font-weight:700;">SIGMA Guidance Portal</p>
                            <p style="margin:0;color:#9ca3af;font-size:12px;line-height:1.6;">
                                This is an automated notification. Please do not reply to this email.<br>
                                &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
                            </p>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>

</body>
</html>
