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
            'address' => Setting::value('contact_address', 'Indramayu, Indonesia'),
            'email' => Setting::value('contact_email', config('mail.from.address')),
            'phone' => Setting::value('contact_phone', '+62 812-3456-7890'),
            'whatsapp' => Setting::value('contact_whatsapp', 'https://wa.me/6281234567890'),
            'mapEmbed' => Setting::value('contact_map_embed', '<iframe class="w-100 rounded" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d247.79144225768752!2d108.30291775386814!3d-6.437300513775523!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e6ec7febf73c6fd%3A0xedf5590a904f67ba!2sAIRENA%20Indramayu%20%7C%20Jasa%20Service%20AC%20Indramayu!5e0!3m2!1sid!2sid!4v1762709663680!5m2!1sid!2sid" width="400" height="300" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>'),
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
