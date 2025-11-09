@extends('layouts.app')

@section('title', $project->title . ' — Devengour Case Study')

@section('content')
<section class="bg-white py-7" style="margin-top: 6rem;">
    <div class="container">
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/portfolio">Portfolio</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $project->title }}</li>
            </ol>
        </nav>
        <div class="row g-5">
            <div class="col-lg-8">
                <h1 class="display-6 fw-semibold">{{ $project->title }}</h1>
                <p class="text-muted fs-5">{{ $project->summary }}</p>
                <div class="mb-5">
                    <h2 class="h5 fw-semibold text-primary">Problem</h2>
                    <p class="text-muted">{!! nl2br(e($project->problem_text)) !!}</p>
                </div>
                <div class="mb-5">
                    <h2 class="h5 fw-semibold text-primary">Solution</h2>
                    <p class="text-muted">{!! nl2br(e($project->solution_text)) !!}</p>
                </div>
                @if($project->testimonial_text)
                    <div class="testimonial-block p-4 rounded-4 shadow-sm bg-light">
                        <p class="fw-medium mb-2">“{{ $project->testimonial_text }}”</p>
                        <p class="text-muted mb-0">{{ $project->testimonial_author }}</p>
                    </div>
                @endif
            </div>
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-body p-4">
                        <h3 class="h6 fw-semibold">Tech stack</h3>
                        <ul class="list-unstyled text-muted mb-0">
                            @foreach($project->techStackList() as $item)
                                <li class="mb-2">• {{ $item }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-body p-4">
                        <h3 class="h6 fw-semibold">Project status</h3>
                        <p class="text-muted mb-0">Launched {{ optional($project->published_at)->format('F Y') ?? '—' }}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-5" id="project-gallery">
            <div class="row g-3">
                @foreach($project->images as $image)
                    <div class="col-md-6">
                        <a href="{{ asset('storage/'.$image->file_path) }}" class="gallery-item" data-sub-html="{{ $image->caption }}">
                            <div class="ratio ratio-16x9 rounded-4 overflow-hidden shadow-sm">
                                <img src="{{ asset('storage/'.$image->file_path) }}" class="w-100 h-100 object-fit-cover" alt="{{ $project->title }} visual">
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
@endsection
