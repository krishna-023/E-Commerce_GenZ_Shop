<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Verification - GENZKART</title>
</head>
<body style="margin:0; padding:0; background-color:#f9f9f9; font-family: Arial, sans-serif;">

    <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width:600px; background:#ffffff; border-radius:12px; box-shadow:0 4px 12px rgba(0,0,0,0.1);">
        <tr>
            <td align="center" style="padding:40px 20px 20px 20px;">
                <img src="{{ asset('web/images/Logo.jpg') }}" alt="GENZKART Logo" style="max-height:100px;">
            </td>
        </tr>
        <tr>
            <td align="center" style="padding: 0 30px 20px 30px;">
                <h2 style="color:#e63946; margin-bottom:10px;">Verify Your Email Address</h2>
                <p style="color:#555; font-size:15px; line-height:1.6;">
                    Welcome to <strong>GENZKART</strong> – Your Shop, Your Style.<br>
                    Please confirm your email address to activate your account.
                </p>
            </td>
        </tr>
        <tr>
            <td align="center" style="padding: 20px 30px;">
                <a href="{{ $verificationUrl }}" style="background:#e63946; color:#ffffff; padding:14px 40px; border-radius:50px; font-size:16px; font-weight:bold; text-decoration:none; display:inline-block;">
                    Verify Now
                </a>
            </td>
        </tr>
        <tr>
            <td align="center" style="padding: 20px 30px;">
                <p style="color:#888; font-size:13px; margin:0;">
                    If you didn’t receive the email or the button doesn’t work, copy and paste this link into your browser:
                </p>
                <p style="color:#555; font-size:13px; word-break:break-all; margin-top:8px;">
                    {{ $verificationUrl }}
                </p>
            </td>
        </tr>
        <tr>
            <td align="center" style="padding: 30px 20px; border-top:1px solid #eee;">
                <p style="font-size:13px; color:#aaa; margin:0;">
                    &copy; {{ date('Y') }} GENZKART. All rights reserved.
                </p>
            </td>
        </tr>
    </table>

</body>
</html>
