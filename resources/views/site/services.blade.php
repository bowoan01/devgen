@extends('layouts.app')

@section('title', 'Devgenfour Services — Strategy, design & engineering')

@section('content')
<section class="bg-white py-7" data-animate="fade-up">
    <div class="container">
        <div class="text-center mb-5" data-animate="fade-up">
            <span class="badge bg-primary-subtle text-primary rounded-pill px-3 py-2">What we do</span>
            <h1 class="display-6 fw-semibold mt-3">From concept to continuous delivery.</h1>
            <p class="text-muted fs-5">Devgenfour blends strategy, design, and engineering to craft resilient products for ambitious teams.</p>
        </div>
        <div class="row g-4" data-stagger>
            @foreach($services as $service)
                <div class="col-md-6">
                    <div class="card border-0 shadow-sm rounded-4 h-100 hover-elevate" data-animate="fade-up">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center mb-3">
                                <div class="icon-bubble me-3">
                                    <i class="{{ $service->icon_class ?? 'bi bi-lightning-charge' }} text-primary"></i>
                                </div>
                                <div>
                                    <h2 class="h5 fw-semibold mb-0">{{ $service->title }}</h2>
                                </div>
                            </div>
                            <p class="text-muted">{{ $service->excerpt }}</p>
                            <a href="/services/{{ $service->slug }}" class="text-decoration-none fw-semibold">Explore capability →</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endsection
