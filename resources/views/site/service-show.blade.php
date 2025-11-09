@extends('layouts.app')

@section('title', $service->title . ' — Devgenfour Service')

@section('content')
<section class="bg-white py-7">
    <div class="container">
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/services">Services</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $service->title }}</li>
            </ol>
        </nav>
        <div class="row g-5">
            <div class="col-lg-8">
                <h1 class="display-6 fw-semibold mb-3">{{ $service->title }}</h1>
                <p class="lead text-muted">{{ $service->excerpt }}</p>
                <article class="service-body">
                    {!! nl2br(e($service->body)) !!}
                </article>
            </div>
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-body p-4">
                        <h2 class="h5 fw-semibold">Engagement highlights</h2>
                        <ul class="list-unstyled text-muted small mb-0">
                            <li class="d-flex align-items-start gap-2 mb-2"><span class="text-primary">◆</span> Discovery workshops & stakeholder interviews</li>
                            <li class="d-flex align-items-start gap-2 mb-2"><span class="text-primary">◆</span> Rapid prototyping with continuous testing</li>
                            <li class="d-flex align-items-start gap-2 mb-2"><span class="text-primary">◆</span> Dedicated delivery squad with weekly rituals</li>
                            <li class="d-flex align-items-start gap-2"><span class="text-primary">◆</span> Launch playbook, analytics, and optimisation roadmap</li>
                        </ul>
                        <a href="/contact" class="btn btn-primary w-100 rounded-pill mt-3">Book a discovery call</a>
                    </div>
                </div>
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-body p-4">
                        <h3 class="h6 fw-semibold">Featured work</h3>
                        <p class="text-muted small">See how this service accelerates product outcomes.</p>
                        <a href="/portfolio" class="btn btn-outline-primary btn-sm rounded-pill">View portfolio</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
