@extends('layouts.app')

@section('title', $project->title.' — Devengour Case Study')

@section('content')
<section class="bg-gradient-secondary text-white py-6">
    <div class="container py-5">
        <span class="badge bg-primary-subtle text-primary rounded-pill mb-3">{{ $project->category_label }}</span>
        <h1 class="display-5 fw-bold mb-3">{{ $project->title }}</h1>
        <p class="lead text-light-emphasis mb-0">{{ $project->summary }}</p>
    </div>
</section>
<section class="py-6">
    <div class="container">
        <div class="row gy-5">
            <div class="col-lg-7">
                @if($project->images->isNotEmpty())
                    <div id="project-gallery" class="rounded-4 overflow-hidden shadow-sm">
                        <div class="row g-3">
                            @foreach($project->images as $image)
                                <div class="col-6">
                                    <a href="{{ asset('storage/'.$image->file_path) }}" class="gallery-item" data-sub-html="{{ $image->caption }}">
                                        <img src="{{ asset('storage/'.$image->file_path) }}" class="img-fluid rounded-3" alt="{{ $project->title }} gallery image">
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
            <div class="col-lg-5">
                <div class="p-4 bg-white border border-light rounded-4 shadow-sm mb-4">
                    <h5 class="fw-semibold text-primary mb-3">Project overview</h5>
                    <p class="text-muted mb-3"><strong class="text-dark">The challenge</strong><br>{{ $project->problem_text }}</p>
                    <p class="text-muted mb-0"><strong class="text-dark">Our solution</strong><br>{{ $project->solution_text }}</p>
                </div>
                @if($project->tech_stack)
                    <div class="p-4 bg-light rounded-4 shadow-sm mb-4">
                        <h6 class="fw-semibold text-uppercase small mb-3">Tech stack</h6>
                        <div class="d-flex flex-wrap gap-2">
                            @foreach($project->tech_stack as $tech)
                                <span class="badge rounded-pill bg-white text-primary border border-primary-subtle">{{ $tech }}</span>
                            @endforeach
                        </div>
                    </div>
                @endif
                @if($project->testimonial_text)
                    <div class="p-4 bg-dark text-white rounded-4 shadow-sm">
                        <p class="mb-3 fst-italic">“{{ $project->testimonial_text }}”</p>
                        <p class="mb-0 text-white-50">{{ $project->testimonial_author }}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>
<section class="py-6 bg-white">
    <div class="container">
        @if($related->isNotEmpty())
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3 class="fw-semibold mb-0">Related engagements</h3>
                <a href="{{ route('site.portfolio') }}" class="btn btn-outline-primary rounded-pill btn-sm">All case studies</a>
            </div>
            <div class="row g-4">
                @foreach($related as $item)
                    <div class="col-md-6 col-xl-4">
                        <div class="card border-0 shadow-sm h-100">
                            @if($item->primary_image)
                                <img src="{{ asset('storage/'.$item->primary_image) }}" class="card-img-top" alt="{{ $item->title }} cover">
                            @endif
                            <div class="card-body p-4">
                                <span class="badge bg-primary-subtle text-primary rounded-pill mb-2">{{ $item->category_label }}</span>
                                <h5 class="fw-semibold">{{ $item->title }}</h5>
                                <p class="text-muted">{{ $item->summary }}</p>
                                <a href="{{ route('site.portfolio.show', $item) }}" class="stretched-link text-decoration-none fw-semibold">View project →</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</section>
<section class="py-6 bg-gradient-primary text-white">
    <div class="container text-center">
        <h2 class="fw-semibold mb-3">Have a brief to share?</h2>
        <p class="lead text-light-emphasis mb-4">Our team is ready to turn your vision into a resilient digital product.</p>
        <a href="{{ route('site.contact') }}" class="btn btn-light btn-lg rounded-pill px-5">Start the conversation</a>
    </div>
</section>
@endsection
