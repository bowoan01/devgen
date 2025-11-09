@extends('layouts.app')

@section('title', 'Portfolio — Devengour')

@section('content')
<section class="bg-gradient-primary text-white py-6">
    <div class="container py-5 text-center">
        <h1 class="display-5 fw-bold mb-3">Portfolio</h1>
        <p class="lead text-light-emphasis mb-0">A curated selection of Devengour engagements spanning web, mobile, and product design.</p>
    </div>
</section>
<section class="py-6">
    <div class="container">
        <div class="d-flex justify-content-center flex-wrap gap-2 mb-4">
            @foreach($filters as $key => $label)
                <a href="{{ $key === 'all' ? route('site.portfolio') : route('site.portfolio', ['category' => $key]) }}" class="btn btn-sm rounded-pill {{ ($category === $key) || ($key === 'all' && !$category) ? 'btn-primary' : 'btn-outline-primary' }}">{{ $label }}</a>
            @endforeach
        </div>
        <div class="row g-4">
            @foreach($projects as $project)
                <div class="col-md-6 col-xl-4">
                    <div class="card border-0 shadow-sm h-100">
                        @if($project->primary_image)
                            <img src="{{ asset('storage/'.$project->primary_image) }}" class="card-img-top" alt="{{ $project->title }} cover">
                        @endif
                        <div class="card-body p-4">
                            <span class="badge bg-primary-subtle text-primary rounded-pill mb-2">{{ $project->category_label }}</span>
                            <h5 class="fw-semibold">{{ $project->title }}</h5>
                            <p class="text-muted">{{ $project->summary }}</p>
                            <a href="{{ route('site.portfolio.show', $project) }}" class="stretched-link text-decoration-none fw-semibold">View case study →</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="mt-5 d-flex justify-content-center">
            {{ $projects->links() }}
        </div>
    </div>
</section>
@endsection
