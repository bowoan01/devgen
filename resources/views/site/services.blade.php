@extends('layouts.app')
@php use Illuminate\Support\Str; @endphp

@section('title', 'Our Services — Devengour')

@section('content')
<section class="bg-gradient-primary text-white py-6">
    <div class="container py-5 text-center">
        <h1 class="display-5 fw-bold mb-3">Services engineered for scale</h1>
        <p class="lead text-light-emphasis mb-0">Devengour blends strategy, design, and engineering to deliver products that move the needle for modern organisations.</p>
    </div>
</section>
<section class="py-6">
    <div class="container">
        <div class="row g-4">
            @foreach($services as $service)
                <div class="col-md-6 col-xl-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center mb-3">
                                <div class="icon-circle me-3">
                                    <i class="{{ $service->icon_class ?: 'bi bi-stars' }}"></i>
                                </div>
                                <div>
                                    <h5 class="fw-semibold mb-0">{{ $service->title }}</h5>
                                    <small class="text-muted">{{ $service->excerpt }}</small>
                                </div>
                            </div>
                            <p class="text-muted">{!! nl2br(e(Str::limit($service->body, 360))) !!}</p>
                            <a href="{{ route('site.services.show', $service) }}" class="text-decoration-none fw-semibold">Dive deeper →</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endsection
