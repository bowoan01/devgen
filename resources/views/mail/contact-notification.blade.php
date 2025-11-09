<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>New Contact Message</title>
</head>
<body style="font-family: Arial, sans-serif; background-color:#f9fafb; padding:24px; color:#1e293b;">
    <table width="100%" cellpadding="0" cellspacing="0" style="max-width:640px; margin:0 auto; background:#ffffff; border-radius:12px; box-shadow:0 12px 30px rgba(37,99,235,0.12); overflow:hidden;">
        <tr>
            <td style="padding:32px;">
                <h2 style="margin-top:0; color:#2563eb;">New contact enquiry</h2>
                <p style="margin-bottom:24px; line-height:1.6;">A new message has been submitted from the Devengour website. Review the details below and follow up promptly.</p>

                <table cellpadding="0" cellspacing="0" width="100%" style="border-collapse:collapse;">
                    <tr>
                        <td style="padding:8px 0; font-weight:600; width:140px;">Name</td>
                        <td style="padding:8px 0;">{{ $messageModel->name }}</td>
                    </tr>
                    <tr>
                        <td style="padding:8px 0; font-weight:600;">Email</td>
                        <td style="padding:8px 0;"><a href="mailto:{{ $messageModel->email }}" style="color:#2563eb;">{{ $messageModel->email }}</a></td>
                    </tr>
                    @if($messageModel->company)
                    <tr>
                        <td style="padding:8px 0; font-weight:600;">Company</td>
                        <td style="padding:8px 0;">{{ $messageModel->company }}</td>
                    </tr>
                    @endif
                    @if($messageModel->phone)
                    <tr>
                        <td style="padding:8px 0; font-weight:600;">Phone</td>
                        <td style="padding:8px 0;">{{ $messageModel->phone }}</td>
                    </tr>
                    @endif
                    <tr>
                        <td style="padding:8px 0; font-weight:600; vertical-align:top;">Message</td>
                        <td style="padding:8px 0; line-height:1.6; white-space:pre-line;">{{ $messageModel->message }}</td>
                    </tr>
                    <tr>
                        <td style="padding:8px 0; font-weight:600;">Submitted</td>
                        <td style="padding:8px 0;">{{ optional($messageModel->created_at)->format('d M Y H:i') }}</td>
                    </tr>
                </table>

                <p style="margin-top:32px; font-size:13px; color:#64748b;">You are receiving this notification because this email is configured as the default sender in Laravel Mail.</p>
            </td>
        </tr>
    </table>
</body>
</html>
