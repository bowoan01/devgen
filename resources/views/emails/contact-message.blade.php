@php($message = $messageModel)
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>New Contact Message</title>
</head>
<body style="font-family: 'Poppins', Arial, sans-serif; background-color: #f5f7fb; color: #1e293b; padding: 24px;">
    <table width="100%" cellpadding="0" cellspacing="0" style="max-width:600px; margin:0 auto; background:#ffffff; border-radius:12px; overflow:hidden; box-shadow:0 12px 40px rgba(15,23,42,0.12);">
        <tr style="background:#2563EB; color:#ffffff;">
            <td style="padding:24px 32px;">
                <h1 style="margin:0; font-size:24px; font-weight:600;">New Inquiry from {{ $message->name }}</h1>
            </td>
        </tr>
        <tr>
            <td style="padding:32px;">
                <p style="font-size:16px; line-height:1.6;">You've received a new contact submission via Devgenfour.com.</p>
                <table width="100%" cellpadding="0" cellspacing="0" style="margin-top:16px;">
                    <tr>
                        <td width="160" style="font-weight:600; padding:8px 0;">Name</td>
                        <td style="padding:8px 0;">{{ $message->name }}</td>
                    </tr>
                    <tr>
                        <td width="160" style="font-weight:600; padding:8px 0;">Email</td>
                        <td style="padding:8px 0;">{{ $message->email }}</td>
                    </tr>
                    @if($message->company)
                        <tr>
                            <td width="160" style="font-weight:600; padding:8px 0;">Company</td>
                            <td style="padding:8px 0;">{{ $message->company }}</td>
                        </tr>
                    @endif
                    @if($message->phone)
                        <tr>
                            <td width="160" style="font-weight:600; padding:8px 0;">Phone</td>
                            <td style="padding:8px 0;">{{ $message->phone }}</td>
                        </tr>
                    @endif
                    <tr>
                        <td width="160" style="font-weight:600; padding:8px 0;">Message</td>
                        <td style="padding:8px 0; white-space:pre-line;">{{ $message->message }}</td>
                    </tr>
                </table>
                <p style="margin-top:24px; font-size:14px; color:#64748b;">Submitted on {{ $message->created_at->format('d M Y H:i') }} (UTC)</p>
            </td>
        </tr>
    </table>
</body>
</html>
