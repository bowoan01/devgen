@extends('layouts.app')

@section('title', 'Devgenfour Portfolio — Selected Work')

@section('content')
    <section class="bg-white py-7" data-animate="fade-up">
        <div class="container">
            <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-end gap-4 mb-5"
                data-animate="fade-up">
                <div>
                    <h1 class="display-6 fw-semibold">Signature case studies</h1>
                    <p class="text-muted fs-5">We partner with visionary brands to orchestrate world-class digital products.
                    </p>
                </div>
                <div class="btn-group" role="group">
                    <a href="{{ url('/portfolio') }}"
                        class="btn btn-outline-primary button-soft-transition {{ $category ? '' : 'active' }}">All</a>
                    @foreach ($categories as $item)
                        <a href="{{ url('/portfolio?category=' . $item) }}"
                            class="btn btn-outline-primary button-soft-transition {{ $category === $item ? 'active' : '' }}">{{ ucfirst($item) }}</a>
                    @endforeach
                </div>
            </div>
            <div class="row g-4" data-stagger id="portfolio-gallery" data-lightgallery>
                @forelse($projects as $project)
                    @php($cover = $project->images->first())
                    <div class="col-md-6 col-xl-4">
                        <div class="card border-0 shadow-sm rounded-4 h-100 hover-elevate portfolio-card d-flex flex-column"
                            data-animate="fade-up">
                            @if ($cover)
                                <a href="{{ asset('storage/' . $cover->file_path) }}"
                                    class="gallery-item d-block portfolio-image"
                                    data-sub-html="<h4>{{ $project->title }}</h4><p>{{ $project->summary }}</p>">
                                    <img src="{{ asset('storage/' . $cover->file_path) }}" class="portfolio-cover"
                                        alt="{{ $project->title }}">
                                </a>
                            @else
                                <div class="portfolio-image bg-light"></div>
                            @endif
                            <div class="card-body p-4 d-flex flex-column">
                                <span
                                    class="badge bg-primary-subtle text-primary mb-2">{{ ucfirst($project->category) }}</span>
                                <h2 class="h5 fw-semibold">{{ $project->title }}</h2>
                                <p class="text-muted flex-grow-1">{{ $project->summary }}</p>
                                <a href="{{ route('portfolio.show', $project->slug) }}"
                                    class="text-decoration-none fw-semibold mt-3">View project →</a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="alert alert-info rounded-4 border-0 shadow-sm">We’re curating new stories for this
                            category. Check back soon.</div>
                    </div>
                @endforelse
            </div>
            <div class="mt-5 d-flex justify-content-center">
                {{ $projects->links() }}
            </div>
        </div>
    </section>
@endsection
