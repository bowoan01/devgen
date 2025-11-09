@extends('layouts.app')

@section('title', 'Contact Devengour')

@section('content')
<section class="bg-gradient-primary text-white py-6">
    <div class="container py-5 text-center">
        <h1 class="display-5 fw-bold mb-3">Let’s build something remarkable</h1>
        <p class="lead text-light-emphasis mb-0">Tell us about your product vision and we’ll assemble the right team to realise it.</p>
    </div>
</section>
<section class="py-6">
    <div class="container">
        <div class="row gy-5">
            <div class="col-lg-7">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4 p-lg-5">
                        <h3 class="fw-semibold mb-4">Start the conversation</h3>
                        <form id="contact-form" action="{{ route('site.contact.submit') }}" method="POST" class="needs-validation" novalidate>
                            @csrf
                            <div class="mb-3">
                                <label for="name" class="form-label">Full name</label>
                                <input type="text" class="form-control form-control-lg" id="name" name="name" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Work email</label>
                                <input type="email" class="form-control form-control-lg" id="email" name="email" required>
                            </div>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="company" class="form-label">Company</label>
                                    <input type="text" class="form-control" id="company" name="company">
                                </div>
                                <div class="col-md-6">
                                    <label for="phone" class="form-label">Phone</label>
                                    <input type="text" class="form-control" id="phone" name="phone">
                                </div>
                            </div>
                            <div class="mb-4 mt-3">
                                <label for="message" class="form-label">How can we help?</label>
                                <textarea class="form-control" id="message" name="message" rows="5" required></textarea>
                            </div>
                            <div class="d-flex align-items-center gap-3">
                                <button type="submit" class="btn btn-primary btn-lg rounded-pill px-5">Send message</button>
                                <div class="spinner-border text-primary d-none" role="status" id="contact-spinner">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                            </div>
                            <div class="alert mt-4 d-none" id="contact-alert" role="alert"></div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="bg-white rounded-4 shadow-sm p-4 mb-4 border border-light">
                    <h5 class="fw-semibold text-primary mb-3">Visit our studio</h5>
                    <p class="text-muted mb-2">{{ $office }}</p>
                    <p class="text-muted mb-2">WhatsApp: <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $whatsapp) }}" class="text-decoration-none">{{ $whatsapp }}</a></p>
                    <p class="text-muted mb-0">Email: <a href="mailto:{{ $email }}" class="text-decoration-none">{{ $email }}</a></p>
                </div>
                <div class="ratio ratio-4x3 rounded-4 overflow-hidden shadow-sm mb-4">
                    <iframe src="{{ $mapEmbed }}" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
                <div class="p-4 rounded-4 shadow-sm bg-light">
                    <h6 class="fw-semibold text-uppercase small mb-3">Connect</h6>
                    <div class="d-flex flex-wrap gap-2">
                        @foreach($socials as $social)
                            <a href="{{ $social['url'] }}" class="btn btn-outline-primary btn-sm rounded-pill" target="_blank" rel="noopener">{{ $social['label'] }}</a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
