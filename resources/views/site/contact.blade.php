@extends('layouts.app')

@section('title', 'Contact Devengour — Let’s build together')

@section('content')
<section class="bg-white py-7" style="margin-top: 6rem;">
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-5">
                <span class="badge bg-primary-subtle text-primary rounded-pill px-3 py-2 mb-3">Let’s collaborate</span>
                <h1 class="display-6 fw-semibold">Share your vision and we’ll make it real.</h1>
                <p class="text-muted">Tell us about your challenge, timeline, or opportunity. We’ll reply within one business day with the next steps.</p>
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-body p-4">
                        <h3 class="h6 fw-semibold">Contact</h3>
                        <ul class="list-unstyled text-muted mb-0">
                            <li class="mb-2">📧 <a href="mailto:{{ $email }}" class="text-decoration-none">{{ $email }}</a></li>
                            <li class="mb-2">📱 <a href="{{ $whatsapp }}" target="_blank" class="text-decoration-none">WhatsApp us</a></li>
                            <li class="mb-0">📍 {{ $address }}</li>
                        </ul>
                    </div>
                </div>
                <div class="ratio ratio-16x9 rounded-4 overflow-hidden shadow-sm">
                    {!! $mapEmbed !!}
                </div>
            </div>
            <div class="col-lg-7">
                <div class="card border-0 shadow-lg rounded-4">
                    <div class="card-body p-4 p-lg-5">
                        <h2 class="h4 fw-semibold mb-3">Start the conversation</h2>
                        <form id="contact-form" action="/contact" method="POST">
                            @csrf
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Name</label>
                                    <input type="text" name="name" class="form-control form-control-lg rounded-3" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Email</label>
                                    <input type="email" name="email" class="form-control form-control-lg rounded-3" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Company</label>
                                    <input type="text" name="company" class="form-control form-control-lg rounded-3">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Phone</label>
                                    <input type="text" name="phone" class="form-control form-control-lg rounded-3">
                                </div>
                                <div class="col-12">
                                    <label class="form-label">How can we help?</label>
                                    <textarea name="message" class="form-control form-control-lg rounded-3" rows="5" required></textarea>
                                </div>
                            </div>
                            <div class="d-grid d-sm-flex justify-content-sm-end gap-3 mt-4">
                                <button type="reset" class="btn btn-outline-secondary rounded-pill px-4">Reset</button>
                                <button type="submit" class="btn btn-primary rounded-pill px-4">Send message</button>
                            </div>
                            <div class="alert mt-4 d-none" id="contact-feedback"></div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
