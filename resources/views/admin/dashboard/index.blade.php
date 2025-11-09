@extends('layouts.admin')

@section('title', 'Dashboard — Devengour Admin')

@section('content')
<div class="row g-4">
    <div class="col-xl-3 col-md-6">
        <div class="card shadow-sm border-0 gradient-card gradient-blue text-white">
            <div class="card-body">
                <h6 class="text-uppercase small fw-semibold">Services</h6>
                <h2 class="display-6 fw-bold mb-0">{{ $serviceCount }}</h2>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card shadow-sm border-0 gradient-card gradient-indigo text-white">
            <div class="card-body">
                <h6 class="text-uppercase small fw-semibold">Projects</h6>
                <h2 class="display-6 fw-bold mb-0">{{ $projectCount }}</h2>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card shadow-sm border-0 gradient-card gradient-purple text-white">
            <div class="card-body">
                <h6 class="text-uppercase small fw-semibold">Team</h6>
                <h2 class="display-6 fw-bold mb-0">{{ $teamCount }}</h2>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card shadow-sm border-0 gradient-card gradient-teal text-white">
            <div class="card-body">
                <h6 class="text-uppercase small fw-semibold">New messages</h6>
                <h2 class="display-6 fw-bold mb-0">{{ $unreadContacts }}</h2>
            </div>
        </div>
    </div>
</div>
<div class="card border-0 shadow-sm mt-4">
    <div class="card-body p-4">
        <h5 class="fw-semibold mb-3">Welcome back</h5>
        <p class="text-muted mb-0">Use the navigation above to manage content. DataTables power each module with fast, server-side interactions.</p>
    </div>
</div>
@endsection
