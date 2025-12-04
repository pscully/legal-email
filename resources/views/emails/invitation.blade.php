<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Invitation</title>
</head>
<body style="margin: 0; padding: 0; font-family: Arial, sans-serif; background-color: #f4f4f4;">
    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="background-color: #f4f4f4;">
        <tr>
            <td style="padding: 40px 20px;">
                <table role="presentation" width="600" cellspacing="0" cellpadding="0" border="0" style="margin: 0 auto; background-color: #ffffff; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                    <!-- Header -->
                    <tr>
                        <td style="padding: 40px 40px 20px 40px; text-align: center; background-color: #1e3a8a; border-radius: 8px 8px 0 0;">
                            <h1 style="margin: 0; color: #ffffff; font-size: 24px; font-weight: bold;">NC Lawyers for the Rule of Law</h1>
                        </td>
                    </tr>

                    <!-- Body Content -->
                    <tr>
                        <td style="padding: 40px;">
                            <p style="margin: 0 0 20px 0; font-size: 16px; line-height: 24px; color: #333333;">
                                Dear {{ $invitee->first_name }},
                            </p>

                            <p style="margin: 0 0 20px 0; font-size: 16px; line-height: 24px; color: #333333;">
                                You've been invited to join <strong>NC Lawyers for the Rule of Law</strong>, an organization dedicated to upholding the principles of justice and the rule of law in North Carolina.
                            </p>

                            <p style="margin: 0 0 30px 0; font-size: 16px; line-height: 24px; color: #333333;">
                                We believe your participation would be valuable to our mission, and we'd be honored to have you as part of our community.
                            </p>

                            <!-- CTA Button -->
                            <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0">
                                <tr>
                                    <td style="text-align: center; padding: 20px 0;">
                                        <a href="{{ $invitee->signup_url }}" style="display: inline-block; padding: 16px 40px; background-color: #1e3a8a; color: #ffffff; text-decoration: none; font-size: 16px; font-weight: bold; border-radius: 4px;">
                                            Complete Your Signup
                                        </a>
                                    </td>
                                </tr>
                            </table>

                            <p style="margin: 20px 0 0 0; font-size: 14px; line-height: 20px; color: #666666; text-align: center;">
                                Or copy and paste this link into your browser:<br>
                                <a href="{{ $invitee->signup_url }}" style="color: #1e3a8a; word-break: break-all;">{{ $invitee->signup_url }}</a>
                            </p>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="padding: 30px 40px; background-color: #f9fafb; border-radius: 0 0 8px 8px; border-top: 1px solid #e5e7eb;">
                            <p style="margin: 0 0 10px 0; font-size: 14px; line-height: 20px; color: #666666; text-align: center;">
                                <strong>NC Lawyers for the Rule of Law</strong>
                            </p>
                            <p style="margin: 0; font-size: 12px; line-height: 18px; color: #999999; text-align: center;">
                                This invitation was sent to {{ $invitee->email }}<br>
                                If you have any questions, please contact us.
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
