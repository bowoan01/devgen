<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Devgenfour Admin')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/lightgallery@2.7.2/css/lightgallery-bundle.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="/css/app.css">
    @stack('styles')
</head>

<body class="bg-body-tertiary" style="font-family: 'Inter', sans-serif;">
    <div class="d-flex">
        <aside class="bg-white border-end min-vh-100 shadow-sm" style="width: 260px;">
            <div class="p-4 border-bottom">
                <a href="/admin" class="fs-4 fw-semibold text-decoration-none text-primary">Devgenfour Admin</a>
            </div>
            <nav class="p-4">
                <ul class="nav flex-column gap-2">
                    <li class="nav-item"><a href="/admin" class="nav-link">Dashboard</a></li>
                    <li class="nav-item"><a href="/admin/services" class="nav-link">Services</a></li>
                    <li class="nav-item"><a href="/admin/projects" class="nav-link">Projects</a></li>
                    <li class="nav-item"><a href="/admin/teams" class="nav-link">Team</a></li>
                    <li class="nav-item"><a href="/admin/contacts" class="nav-link">Contact Messages</a></li>
                    <li class="nav-item mt-4">
                        <form method="POST" action="/logout" id="logout-form">
                            @csrf
                            <button class="btn btn-outline-danger w-100" type="submit">Sign out</button>
                        </form>
                    </li>
                </ul>
            </nav>
        </aside>
        <div class="flex-fill">
            <header class="bg-white border-bottom py-3 px-4 d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h4 mb-0">@yield('page_title', 'Overview')</h1>
                    <p class="text-muted mb-0 small">Manage the content powering Devgenfour.com</p>
                </div>
                <div class="text-end small text-muted">
                    Signed in as <strong>{{ auth()->user()->name ?? 'Guest' }}</strong>
                </div>
            </header>
            <main class="p-4">
                @yield('content')
            </main>
        </div>
    </div>

    {{-- <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script> --}}
    {{-- Muat jQuery dari CDN (jika memang kamu butuh jQuery) --}}
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/lightgallery@2.7.2/lightgallery.umd.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/lightgallery@2.7.2/plugins/thumbnail/lg-thumbnail.umd.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/lightgallery@2.7.2/plugins/zoom/lg-zoom.umd.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    @stack('scripts')
</body>

</html>
