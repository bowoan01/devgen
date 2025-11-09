<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContactMessageRequest;
use App\Mail\ContactMessageSubmitted;
use App\Models\ContactMessage;
use App\Models\Setting;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function index()
    {
        return view('site.contact', [
            'address' => Setting::value('contact_address', 'Jakarta, Indonesia'),
            'email' => Setting::value('contact_email', config('mail.from.address')),
            'phone' => Setting::value('contact_phone', '+62 812-3456-7890'),
            'whatsapp' => Setting::value('contact_whatsapp', 'https://wa.me/6281234567890'),
            'mapEmbed' => Setting::value('contact_map_embed', '<iframe class="w-100 rounded" src="https://maps.google.com/maps?q=Jakarta&t=&z=13&ie=UTF8&iwloc=&output=embed" height="320" allowfullscreen loading="lazy"></iframe>'),
        ]);
    }

    public function store(ContactMessageRequest $request)
    {
        $message = ContactMessage::create([
            'name' => $request->string('name')->toString(),
            'email' => $request->string('email')->toString(),
            'company' => $request->filled('company') ? $request->string('company')->toString() : null,
            'phone' => $request->filled('phone') ? $request->string('phone')->toString() : null,
            'message' => $request->string('message')->toString(),
            'meta' => [
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ],
        ]);

        $recipient = Setting::value('contact_notification_email', config('mail.from.address'));
        if ($recipient) {
            Mail::to($recipient)->queue(new ContactMessageSubmitted($message));
        }

        return response()->json([
            'success' => true,
            'message' => 'Thank you for reaching out. Our team will get back to you shortly.',
            'data' => [
                'id' => $message->id,
            ],
        ]);
    }
}
