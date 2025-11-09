@extends('layouts.admin')

@section('page_title', 'Dashboard')

@section('content')
<div class="row g-4">
    <div class="col-xl-3 col-md-6">
        <div class="card border-0 shadow-sm rounded-4 h-100">
            <div class="card-body">
                <p class="text-muted mb-2">Services</p>
                <h2 class="fw-semibold">{{ $serviceCount }}</h2>
                <span class="badge bg-primary-subtle text-primary">Active offerings</span>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card border-0 shadow-sm rounded-4 h-100">
            <div class="card-body">
                <p class="text-muted mb-2">Projects</p>
                <h2 class="fw-semibold">{{ $projectCount }}</h2>
                <span class="badge bg-info-subtle text-info">Showcased work</span>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card border-0 shadow-sm rounded-4 h-100">
            <div class="card-body">
                <p class="text-muted mb-2">Team</p>
                <h2 class="fw-semibold">{{ $teamCount }}</h2>
                <span class="badge bg-success-subtle text-success">Core members</span>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card border-0 shadow-sm rounded-4 h-100">
            <div class="card-body">
                <p class="text-muted mb-2">New Messages</p>
                <h2 class="fw-semibold">{{ $newMessages }}</h2>
                <span class="badge bg-warning-subtle text-warning">Awaiting reply</span>
            </div>
        </div>
    </div>
</div>
<div class="card border-0 shadow-sm rounded-4 mt-4">
    <div class="card-body p-4">
        <h5 class="fw-semibold mb-3">Welcome to the Command Suite</h5>
        <p class="text-muted mb-0">From this panel you can orchestrate the services, projects, and team stories that define Devgenfour’s brand presence. Use the navigation to the left to manage each collection. All changes are instantly reflected on the public site.</p>
    </div>
</div>
@endsection
