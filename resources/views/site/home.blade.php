@extends('layouts.app')

@section('title', 'Devengour — We build digital experiences that scale')

@section('content')
<section class="py-6 bg-gradient-primary text-white">
    <div class="container py-5">
        <div class="row align-items-center gy-4">
            <div class="col-lg-7">
                <h1 class="display-4 fw-bold mb-3">{{ $hero['headline'] }}</h1>
                <p class="lead text-light-emphasis mb-4">{{ $hero['subheadline'] }}</p>
                <div class="d-flex gap-3 flex-wrap">
                    <a href="{{ $hero['cta_url'] }}" class="btn btn-light btn-lg rounded-pill px-4">{{ $hero['cta_label'] }}</a>
                    <a href="{{ route('site.portfolio') }}" class="btn btn-outline-light btn-lg rounded-pill px-4">Explore Portfolio</a>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="rounded-4 bg-white shadow-lg text-dark p-4">
                    <h5 class="fw-semibold text-primary mb-3">Why Devengour</h5>
                    <p class="mb-0">{{ $intro }}</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-6">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-semibold mb-1">Signature services</h2>
                <p class="text-muted mb-0">Strategy, engineering, and experience design built for scale.</p>
            </div>
            <a href="{{ route('site.services') }}" class="btn btn-outline-primary rounded-pill">View all</a>
        </div>
        <div class="row g-4">
            @forelse($featuredServices as $service)
                <div class="col-md-6 col-xl-3">
                    <div class="card service-card h-100 border-0 shadow-sm">
                        <div class="card-body p-4">
                            @if($service->icon_class)
                                <div class="service-icon mb-3"><i class="{{ $service->icon_class }}"></i></div>
                            @endif
                            <h5 class="fw-semibold mb-2">{{ $service->title }}</h5>
                            <p class="text-muted">{{ $service->excerpt }}</p>
                            <a href="{{ route('site.services.show', $service) }}" class="stretched-link text-decoration-none fw-semibold">Learn more →</a>
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-muted">Service details will be available soon.</p>
            @endforelse
        </div>
    </div>
</section>

<section class="py-6 bg-white">
    <div class="container">
        <div class="row align-items-center gy-4">
            <div class="col-lg-5">
                <h2 class="fw-semibold mb-3">Our values</h2>
                <p class="text-muted">The cultural pillars that keep Devengour inventive, collaborative, and relentlessly focused on quality.</p>
            </div>
            <div class="col-lg-7">
                <div class="row g-4">
                    @foreach($values as $value)
                        <div class="col-md-6">
                            <div class="p-4 rounded-4 shadow-sm bg-light h-100">
                                <h5 class="fw-semibold text-primary">{{ $value['title'] }}</h5>
                                <p class="mb-0 text-muted">{{ $value['description'] }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-6">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-semibold mb-1">Featured projects</h2>
                <p class="text-muted mb-0">A snapshot of the experiences we have crafted with ambitious teams.</p>
            </div>
            <a href="{{ route('site.portfolio') }}" class="btn btn-outline-primary rounded-pill">All projects</a>
        </div>
        <div class="row g-4">
            @forelse($featuredProjects as $project)
                <div class="col-md-6 col-xl-4">
                    <div class="card border-0 shadow-sm h-100 overflow-hidden">
                        @if($project->primary_image)
                            <img src="{{ asset('storage/'.$project->primary_image) }}" class="card-img-top" alt="{{ $project->title }} cover">
                        @endif
                        <div class="card-body p-4">
                            <span class="badge rounded-pill bg-primary-subtle text-primary mb-2">{{ $project->category_label }}</span>
                            <h5 class="fw-semibold">{{ $project->title }}</h5>
                            <p class="text-muted">{{ $project->summary }}</p>
                            <a href="{{ route('site.portfolio.show', $project) }}" class="stretched-link text-decoration-none fw-semibold">Discover case study →</a>
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-muted">Our portfolio is being prepared with love. Check back soon.</p>
            @endforelse
        </div>
    </div>
</section>

<section class="py-6 bg-gradient-secondary text-white">
    <div class="container py-5">
        <div class="row align-items-center gy-4">
            <div class="col-lg-8">
                <h2 class="fw-semibold mb-3">Let’s co-create your next digital product</h2>
                <p class="lead text-light-emphasis mb-0">Partner with Devengour to design, build, and ship solutions that resonate with your customers.</p>
            </div>
            <div class="col-lg-4 text-lg-end">
                <a href="{{ route('site.contact') }}" class="btn btn-light btn-lg rounded-pill px-4">Start a project</a>
            </div>
        </div>
    </div>
</section>
@endsection
