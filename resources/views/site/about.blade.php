@extends('layouts.app')

@section('title', 'About Devengour')

@section('content')
<section class="bg-gradient-secondary text-white py-6">
    <div class="container py-5">
        <div class="row align-items-center gy-4">
            <div class="col-lg-7">
                <h1 class="display-5 fw-bold mb-3">Engineering elegance with purpose</h1>
                <p class="lead text-light-emphasis mb-0">Devengour exists to shape digital products that deliver measurable impact while feeling effortless for the people who use them.</p>
            </div>
            <div class="col-lg-5">
                <div class="bg-white text-dark rounded-4 shadow-lg p-4">
                    <h5 class="text-primary fw-semibold mb-2">Vision</h5>
                    <p class="mb-0">{{ $vision }}</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-6">
    <div class="container">
        <div class="row gy-4 align-items-start">
            <div class="col-lg-6">
                <h2 class="fw-semibold mb-3">Mission</h2>
                <p class="text-muted">{{ $mission }}</p>
                <div class="rounded-4 bg-white shadow-sm p-4 border border-light">
                    <h5 class="fw-semibold text-primary mb-3">Our Story</h5>
                    <p class="mb-0 text-muted">{{ $story }}</p>
                </div>
            </div>
            <div class="col-lg-6">
                <h2 class="fw-semibold mb-3">Core Values</h2>
                <div class="row g-4">
                    @foreach($values as $value)
                        <div class="col-sm-6">
                            <div class="p-4 rounded-4 shadow-sm bg-light h-100">
                                <h6 class="fw-semibold text-primary">{{ $value['title'] }}</h6>
                                <p class="small text-muted mb-0">{{ $value['description'] }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-6 bg-white">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-semibold mb-1">Leadership team</h2>
                <p class="text-muted mb-0">A multidisciplinary group aligning strategy, design, and technology.</p>
            </div>
        </div>
        <div class="row g-4">
            @forelse($team as $member)
                <div class="col-md-6 col-lg-4">
                    <div class="card border-0 shadow-sm h-100">
                        @if($member->photo_path)
                            <img src="{{ asset('storage/'.$member->photo_path) }}" class="card-img-top" alt="{{ $member->name }} photo">
                        @endif
                        <div class="card-body p-4">
                            <h5 class="fw-semibold mb-1">{{ $member->name }}</h5>
                            <p class="text-primary small text-uppercase fw-semibold mb-3">{{ $member->role_title }}</p>
                            <p class="text-muted">{{ $member->bio }}</p>
                            @if($member->linkedin_url)
                                <a href="{{ $member->linkedin_url }}" class="text-decoration-none" target="_blank" rel="noopener">Connect on LinkedIn →</a>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-muted">Our leadership roster will be published shortly.</p>
            @endforelse
        </div>
    </div>
</section>
@endsection
