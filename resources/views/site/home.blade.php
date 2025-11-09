@extends('layouts.app')

@section('title', 'Devengour — We build digital experiences that scale')

@section('content')
<section class="container py-7" style="margin-top: 6rem;">
    <div class="row align-items-center g-5">
        <div class="col-lg-6">
            <span class="badge bg-primary-subtle text-primary rounded-pill px-3 py-2 mb-3">Premium Software House</span>
            <h1 class="display-5 fw-semibold text-gradient">{{ $heroHeadline }}</h1>
            <p class="fs-5 text-muted">{{ $heroSubheadline }}</p>
            <div class="d-flex flex-wrap gap-3 mt-4">
                <a href="/contact" class="btn btn-primary btn-lg rounded-pill px-4 shadow">Let’s Build Together</a>
                <a href="/portfolio" class="btn btn-outline-primary btn-lg rounded-pill px-4">Explore our work</a>
            </div>
            <div class="d-flex gap-4 mt-5">
                <div>
                    <div class="h3 fw-bold text-primary">+40</div>
                    <p class="text-muted small mb-0">Digital products delivered</p>
                </div>
                <div>
                    <div class="h3 fw-bold text-primary">12+</div>
                    <p class="text-muted small mb-0">Industries served worldwide</p>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="hero-visual rounded-5 shadow-lg overflow-hidden position-relative">
                <img src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?auto=format&fit=crop&w=1080&q=80" class="img-fluid" alt="Team collaborating">
                <div class="position-absolute bottom-0 start-0 end-0 p-4 bg-gradient-dark text-white">
                    <p class="mb-0 fw-medium">“Devengour orchestrated the entire product launch with elegance and precision.”</p>
                    <small class="opacity-75">Ayu Tan, VP Product — Nimbus Ventures</small>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="bg-white py-6">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
            <div>
                <h2 class="h3 fw-semibold mb-1">Signature Services</h2>
                <p class="text-muted mb-0">Built to transform bold ideas into market-ready realities.</p>
            </div>
            <a href="/services" class="btn btn-outline-primary rounded-pill">All services</a>
        </div>
        <div class="row g-4">
            @foreach($services as $service)
                <div class="col-md-6 col-xl-3">
                    <div class="card h-100 border-0 shadow-sm rounded-4 service-card">
                        <div class="card-body p-4">
                            <div class="icon-placeholder mb-3"><i class="{{ $service->icon_class ?? 'bi bi-stars' }} text-primary fs-2"></i></div>
                            <h3 class="h5 fw-semibold">{{ $service->title }}</h3>
                            <p class="text-muted">{{ $service->excerpt }}</p>
                            <a href="/services/{{ $service->slug }}" class="stretched-link text-decoration-none">Discover more →</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
<section class="container py-6">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
        <div>
            <h2 class="h3 fw-semibold mb-1">Flagship Projects</h2>
            <p class="text-muted mb-0">A curated showcase of platforms engineered by Devengour.</p>
        </div>
        <a href="/portfolio" class="btn btn-outline-primary rounded-pill">View all case studies</a>
    </div>
    <div class="row g-4" id="home-portfolio" data-lightgallery>
        @foreach($projects as $project)
            @php($cover = $project->images->first())
            <div class="col-md-6 col-xl-4">
                <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden">
                    @if($cover)
                        <a href="{{ asset('storage/'.$cover->file_path) }}" class="gallery-item" data-sub-html="<h4>{{ $project->title }}</h4><p>{{ $project->summary }}</p>">
                            <img src="{{ asset('storage/'.$cover->file_path) }}" class="img-fluid" alt="{{ $project->title }} cover">
                        </a>
                    @else
                        <div class="ratio ratio-16x9 bg-light"></div>
                    @endif
                    <div class="card-body p-4">
                        <span class="badge bg-primary-subtle text-primary mb-2 text-uppercase">{{ $project->category }}</span>
                        <h3 class="h5 fw-semibold">{{ $project->title }}</h3>
                        <p class="text-muted">{{ $project->summary }}</p>
                        <a href="/portfolio/{{ $project->slug }}" class="text-decoration-none fw-semibold">Read case study →</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</section>
<section class="bg-gradient-azure text-white py-6">
    <div class="container">
        <div class="row align-items-center g-4">
            <div class="col-lg-7">
                <h2 class="display-6 fw-semibold">We’re a team of thinkers, designers, and engineers united by craft.</h2>
                <p class="lead text-white-50">From strategy to ship, Devengour partners with ambitious organisations to deliver premium digital products.</p>
                <a href="/about" class="btn btn-light btn-lg rounded-pill">Meet the team</a>
            </div>
            <div class="col-lg-5">
                <div class="row g-3">
                    @foreach($team as $member)
                        <div class="col-6">
                            <div class="bg-white text-dark rounded-4 p-3 shadow-sm h-100">
                                <div class="ratio ratio-1x1 rounded-4 overflow-hidden mb-3">
                                    <img src="{{ $member->photo_path ? asset('storage/'.$member->photo_path) : 'https://images.unsplash.com/photo-1544723795-3fb6469f5b39?auto=format&fit=crop&w=400&q=80' }}" class="w-100 h-100 object-fit-cover" alt="{{ $member->name }}">
                                </div>
                                <h4 class="h6 fw-semibold mb-0">{{ $member->name }}</h4>
                                <p class="text-muted small mb-0">{{ $member->role_title }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
<section class="container py-7">
    <div class="row align-items-center g-5">
        <div class="col-lg-7">
            <h2 class="h2 fw-semibold mb-3">Ready to co-create what’s next?</h2>
            <p class="text-muted fs-5">Tell us about your vision and we’ll assemble a dream team to launch it. We respond within one business day.</p>
            <div class="d-flex gap-3">
                <a href="/contact" class="btn btn-primary btn-lg rounded-pill">Start a project</a>
                <a href="mailto:hello@devengour.com" class="btn btn-outline-primary btn-lg rounded-pill">hello@devengour.com</a>
            </div>
        </div>
        <div class="col-lg-5">
            <div class="rounded-5 shadow-lg overflow-hidden">
                <img src="https://images.unsplash.com/photo-1483478550801-ceba5fe50e8e?auto=format&fit=crop&w=900&q=80" class="img-fluid" alt="Workspace">
            </div>
        </div>
    </div>
</section>
@endsection
