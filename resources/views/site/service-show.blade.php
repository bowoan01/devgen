@extends('layouts.app')
@php use Illuminate\Support\Str; @endphp

@section('title', $service->title.' — Devengour Services')

@section('content')
<section class="bg-gradient-secondary text-white py-6">
    <div class="container py-5">
        <h1 class="fw-bold display-5 mb-3">{{ $service->title }}</h1>
        <p class="lead text-light-emphasis mb-0">{{ $service->excerpt }}</p>
    </div>
</section>
<section class="py-6">
    <div class="container">
        <div class="row gy-5">
            <div class="col-lg-8">
                <article class="prose text-muted">
                    {!! nl2br(e($service->body)) !!}
                </article>
            </div>
            <div class="col-lg-4">
                <div class="p-4 rounded-4 shadow-sm bg-light mb-4">
                    <h5 class="fw-semibold mb-3">Service highlights</h5>
                    <ul class="list-unstyled text-muted small mb-0">
                        <li class="mb-2">Tailored delivery squads</li>
                        <li class="mb-2">Design systems with accessibility baked in</li>
                        <li class="mb-2">Cloud-native architecture &amp; observability</li>
                        <li class="mb-0">QA automation &amp; release governance</li>
                    </ul>
                </div>
                @if($related->isNotEmpty())
                    <div class="p-4 rounded-4 shadow-sm bg-white border border-light">
                        <h6 class="fw-semibold text-uppercase small mb-3">Complementary services</h6>
                        <ul class="list-unstyled mb-0">
                            @foreach($related as $other)
                                <li class="mb-2"><a href="{{ route('site.services.show', $other) }}" class="text-decoration-none">{{ $other->title }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>
<section class="py-6 bg-white">
    <div class="container text-center">
        <h2 class="fw-semibold mb-3">Ready to start a new initiative?</h2>
        <p class="text-muted mb-4">Let’s assemble a pod of strategists, designers, and engineers to build what’s next.</p>
        <a href="{{ route('site.contact') }}" class="btn btn-primary btn-lg rounded-pill px-5">Talk to our team</a>
    </div>
</section>
@endsection
