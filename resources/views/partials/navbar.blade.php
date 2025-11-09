<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm py-3 sticky-top">
    <div class="container">
        <a class="navbar-brand fw-semibold text-primary" href="{{ route('site.home') }}">Devengour</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-3">
                <li class="nav-item"><a class="nav-link" href="{{ route('site.home') }}">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('site.about') }}">About</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('site.services') }}">Services</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('site.portfolio') }}">Portfolio</a></li>
                <li class="nav-item"><a class="btn btn-primary rounded-pill px-4" href="{{ route('site.contact') }}">Let’s Build Together</a></li>
            </ul>
        </div>
    </div>
</nav>
