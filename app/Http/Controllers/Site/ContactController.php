<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContactFormRequest;
use App\Mail\ContactMessageNotification;
use App\Models\ContactMessage;
use App\Models\Setting;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class ContactController extends Controller
{
    public function index()
    {
        $office = Setting::getValue('office_address', 'Level 18, Global Innovation Hub, Jakarta, Indonesia');
        $whatsapp = Setting::getValue('contact_whatsapp', '+62 812-3456-7890');
        $email = Setting::getValue('contact_email', 'hello@devengour.com');
        $mapEmbed = Setting::getValue('contact_map_embed', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d');
        $socials = Setting::getValue('contact_socials', [
            ['label' => 'LinkedIn', 'url' => 'https://www.linkedin.com/company/devengour'],
            ['label' => 'Instagram', 'url' => 'https://www.instagram.com/devengour'],
            ['label' => 'Behance', 'url' => 'https://www.behance.net/devengour'],
        ]);

        return view('site.contact', compact('office', 'whatsapp', 'email', 'mapEmbed', 'socials'));
    }

    public function store(ContactFormRequest $request)
    {
        $payload = $request->validated();
        $payload['meta'] = [
            'ip' => $request->ip(),
            'user_agent' => Str::limit($request->userAgent() ?? '', 255),
        ];

        $message = ContactMessage::create($payload);

        if (config('mail.default') && config('mail.from.address')) {
            Mail::to(config('mail.from.address'))->send(new ContactMessageNotification($message));
        }

        return response()->json([
            'success' => true,
            'message' => 'Thank you for reaching out. Our team will respond shortly.',
            'data' => [
                'id' => $message->id,
            ],
        ]);
    }
}
