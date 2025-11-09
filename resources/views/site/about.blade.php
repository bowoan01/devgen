@extends('layouts.app')

@section('title', 'About Devgenfour — Our story, mission & team')

@section('content')
<section class="bg-white py-7" >
    <div class="container">
        <div class="row g-5 align-items-center">
            <div class="col-lg-6">
                <span class="badge bg-primary-subtle text-primary rounded-pill px-3 py-2 mb-3">About Devgenfour</span>
                <h1 class="display-6 fw-semibold">Engineering experiences with purpose, heart, and precision.</h1>
                <p class="text-muted fs-5">{{ $story }}</p>
            </div>
            <div class="col-lg-6">
                <div class="rounded-5 overflow-hidden shadow-lg">
                    <img src="https://images.unsplash.com/photo-1521737604893-d14cc237f11d?auto=format&fit=crop&w=1100&q=80" class="img-fluid" alt="Devgenfour team collaborating">
                </div>
            </div>
        </div>
    </div>
</section>
<section class="container py-6">
    <div class="row g-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 h-100">
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
<section class="bg-light py-6">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
            <div>
                <h2 class="h3 fw-semibold mb-1">Leadership team</h2>
                <p class="text-muted mb-0">Meet the strategists guiding every Devgenfour engagement.</p>
            </div>
            <a href="/contact" class="btn btn-outline-primary rounded-pill">Collaborate with us</a>
        </div>
        <div class="row g-4">
            @foreach($team as $member)
                <div class="col-md-6 col-xl-3">
                    <div class="card border-0 shadow-sm rounded-4 h-100 overflow-hidden">
                        <div class="ratio ratio-3x4">
                            <img src="{{ $member->photo_path ? asset('storage/'.$member->photo_path) : 'https://images.unsplash.com/photo-1524504388940-b1c1722653e1?auto=format&fit=crop&w=800&q=80' }}" class="w-100 h-100 object-fit-cover" alt="{{ $member->name }}">
                        </div>
                        <div class="card-body p-4">
                            <h3 class="h5 fw-semibold">{{ $member->name }}</h3>
                            <p class="text-muted mb-2">{{ $member->role_title }}</p>
                            <p class="text-muted small">{{ \Illuminate\Support\Str::limit($member->bio, 120) }}</p>
                            @if($member->linkedin_url)
                                <a href="{{ $member->linkedin_url }}" target="_blank" class="btn btn-outline-primary btn-sm rounded-pill">LinkedIn</a>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
<section class="container py-6">
    <div class="row g-4">
        @foreach($services as $service)
            <div class="col-md-6">
                <div class="card border-0 shadow-sm rounded-4 h-100">
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
