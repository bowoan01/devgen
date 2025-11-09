<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Devengour Admin')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="/css/app.css">
    @stack('styles')
</head>
<body class="bg-light">
<nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ route('admin.dashboard') }}">Devengour Admin</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#adminNav" aria-controls="adminNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="adminNav">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item"><a class="nav-link" href="{{ route('admin.services.index') }}">Services</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('admin.projects.index') }}">Projects</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('admin.teams.index') }}">Team</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('admin.contacts.index') }}">Contacts</a></li>
            </ul>
            <form method="POST" action="{{ route('admin.logout') }}" class="d-flex">
                @csrf
                <button type="submit" class="btn btn-outline-light btn-sm">Sign out</button>
            </form>
        </div>
    </div>
</nav>
<div class="container-fluid py-4">
    @include('partials.flash')
    @yield('content')
</div>
<script src="https://code.jquery.com/jquery-3.7.1.min.js" defer></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" defer></script>
<script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js" defer></script>
<script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js" defer></script>
<script src="/js/app.js" defer></script>
@stack('scripts')
</body>
</html>
