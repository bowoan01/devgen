@extends('layouts.app')

@section('title', 'Devengour Portfolio — Selected Work')

@section('content')
<section class="bg-white py-7" style="margin-top: 6rem;">
    <div class="container">
        <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-end gap-4 mb-5">
            <div>
                <h1 class="display-6 fw-semibold">Signature case studies</h1>
                <p class="text-muted fs-5">We partner with visionary brands to orchestrate world-class digital products.</p>
            </div>
            <div class="btn-group" role="group">
                <a href="{{ url('/portfolio') }}" class="btn btn-outline-primary {{ $category ? '' : 'active' }}">All</a>
                @foreach($categories as $item)
                    <a href="{{ url('/portfolio?category='.$item) }}" class="btn btn-outline-primary {{ $category === $item ? 'active' : '' }}">{{ ucfirst($item) }}</a>
                @endforeach
            </div>
        </div>
        <div class="row g-4">
            @forelse($projects as $project)
                @php($cover = $project->images->first())
                <div class="col-md-6 col-xl-4">
                    <div class="card border-0 shadow-sm rounded-4 h-100 overflow-hidden">
                        @if($cover)
                            <a href="{{ asset('storage/'.$cover->file_path) }}" class="gallery-item" data-sub-html="<h4>{{ $project->title }}</h4>">
                                <img src="{{ asset('storage/'.$cover->file_path) }}" class="img-fluid" alt="{{ $project->title }}">
                            </a>
                        @else
                            <div class="ratio ratio-16x9 bg-light"></div>
                        @endif
                        <div class="card-body p-4">
                            <span class="badge bg-primary-subtle text-primary mb-2">{{ ucfirst($project->category) }}</span>
                            <h2 class="h5 fw-semibold">{{ $project->title }}</h2>
                            <p class="text-muted">{{ $project->summary }}</p>
                            <a href="/portfolio/{{ $project->slug }}" class="text-decoration-none fw-semibold">View project →</a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-info rounded-4 border-0 shadow-sm">We’re curating new stories for this category. Check back soon.</div>
                </div>
            @endforelse
        </div>
        <div class="mt-5 d-flex justify-content-center">
            {{ $projects->links() }}
        </div>
    </div>
</section>
@endsection
