@extends('layouts.app')

@section('title', 'About Devgenfour — Our story, mission & team')

@section('content')
<section class="bg-white py-7" data-animate="fade-up">
    <div class="container">
        <div class="row g-5 align-items-center">
            <div class="col-lg-6">
                <span class="badge bg-primary-subtle text-primary rounded-pill px-3 py-2 mb-3">About Devgenfour</span>
                <h1 class="display-6 fw-semibold">Engineering experiences with purpose, heart, and precision.</h1>
                <p class="text-muted fs-5">{{ $story }}</p>
            </div>
            <div class="col-lg-6" data-animate="zoom-in">
                <div class="rounded-5 overflow-hidden shadow-lg image-zoom">
                    <img src="https://images.unsplash.com/photo-1521737604893-d14cc237f11d?auto=format&fit=crop&w=1100&q=80" class="img-fluid" alt="Devgenfour team collaborating">
                </div>
            </div>
        </div>
    </div>
</section>
<section class="container py-6" data-animate="fade-up">
    <div class="row g-4" data-stagger>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 h-100 hover-elevate">
                <div class="card-body p-4">
                    <h3 class="h5 fw-semibold text-primary">Vision</h3>
                    <p class="text-muted">{{ $vision }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body p-4">
                    <h3 class="h5 fw-semibold text-primary">Mission</h3>
                    <p class="text-muted">{{ $mission }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body p-4">
                    <h3 class="h5 fw-semibold text-primary">Values</h3>
                    <ul class="list-unstyled text-muted mb-0">
                        @foreach($values as $key => $description)
                            <li class="mb-3">
                                <strong class="d-block text-dark">{{ $key }}</strong>
                                <span>{{ $description }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="bg-light py-6" data-animate="fade-up">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
            <div>
                <h2 class="h3 fw-semibold mb-1">Leadership team</h2>
                <p class="text-muted mb-0">Meet the strategists guiding every Devgenfour engagement.</p>
            </div>
            <a href="/contact" class="btn btn-outline-primary rounded-pill button-soft-transition">Collaborate with us</a>
        </div>
        <div class="position-relative content-slider" data-slider="leadership" data-slider-step="0.85">
            <button class="btn btn-outline-primary rounded-circle content-nav" data-slider-nav="prev" type="button" aria-label="Scroll previous">
                <i class="bi bi-chevron-left"></i>
            </button>
            <div class="content-track leadership-gallery" data-slider-track data-stagger>
                @foreach($team as $member)
                    @php
                        $photoPath = $member->photo_path ? asset('storage/'.$member->photo_path) : null;
                        $photoUrl = $photoPath ?: 'https://ui-avatars.com/api/?name=' . urlencode($member->name) . '&background=0D8ABC&color=fff&size=512';
                    @endphp
                    <article class="card border-0 shadow-sm rounded-4 overflow-hidden hover-elevate content-card" data-animate="fade-up">
                        <a href="{{ $photoUrl }}" class="gallery-item content-photo" data-sub-html="<h4>{{ $member->name }}</h4><p>{{ $member->role_title }}</p>">
                            <div class="ratio ratio-3x4 mb-3">
                                <img src="{{ $photoUrl }}" class="w-100 h-100 object-fit-cover" alt="{{ $member->name }}">
                            </div>
                        </a>
                        <div class="card-body p-4">
                            <h3 class="h5 fw-semibold mb-1">{{ $member->name }}</h3>
                            <p class="text-muted mb-2">{{ $member->role_title }}</p>
                            <p class="text-muted small mb-3">{{ \Illuminate\Support\Str::limit($member->bio, 120) }}</p>
                            @if($member->linkedin_url)
                                <a href="{{ $member->linkedin_url }}" target="_blank" class="btn btn-outline-primary btn-sm rounded-pill button-soft-transition">LinkedIn</a>
                            @endif
                        </div>
                    </article>
                @endforeach
            </div>
            <button class="btn btn-outline-primary rounded-circle content-nav" data-slider-nav="next" type="button" aria-label="Scroll next">
                <i class="bi bi-chevron-right"></i>
            </button>
        </div>
    </div>
</section>
<section class="container py-6" data-animate="fade-up">
    <div class="row g-4" data-stagger>
        @foreach($services as $service)
            <div class="col-md-6">
                <div class="card border-0 shadow-sm rounded-4 h-100 hover-elevate" data-animate="fade-up">
                    <div class="card-body p-4">
                        <h3 class="h5 fw-semibold">{{ $service->title }}</h3>
                        <p class="text-muted">{{ $service->excerpt }}</p>
                        <a href="/services/{{ $service->slug }}" class="text-decoration-none">See details →</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</section>
@endsection
