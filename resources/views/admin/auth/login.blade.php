<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Sign in — Devgenfour Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="/css/app.css">
</head>

<body class="bg-gradient-primary d-flex align-items-center min-vh-100" style="font-family: 'Inter', sans-serif;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-5">
                <div class="card border-0 shadow-xl rounded-4 overflow-hidden">
                    <div class="card-body p-5">
                        <div class="text-center mb-4">
                            <h1 class="h3 fw-semibold mb-1 text-primary">Devgenfour Admin</h1>
                            <p class="text-muted">Sign in to orchestrate experiences that scale.</p>
                        </div>
                        <form id="login-form" action="/login" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-control form-control-lg rounded-3"
                                    placeholder="" required autofocus>
                            </div>
                            <div class="mb-3">
                                <label class="form-label d-flex justify-content-between align-items-center">
                                    <span>Password</span>
                                    <a href="#" class="small text-decoration-none">Forgot?</a>
                                </label>
                                <input type="password" name="password" class="form-control form-control-lg rounded-3"
                                    required>
                            </div>
                            <div class="form-check mb-4">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember-me">
                                <label class="form-check-label" for="remember-me">Keep me signed in</label>
                            </div>
                            <div class="d-grid mb-3">
                                <button type="submit" class="btn btn-primary btn-lg rounded-3">Sign in</button>
                            </div>
                        </form>
                        <div class="alert d-none mt-3" id="login-feedback"></div>
                    </div>
                </div>
                <p class="text-center text-white-50 mt-4">© {{ date('Y') }} Devgenfour. Crafted for excellence.</p>
            </div>
        </div>
    </div>
    {{-- <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script> --}}
    {{-- Muat jQuery dari CDN (jika memang kamu butuh jQuery) --}}
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    {{-- Muat JS kamu dari public/js --}}
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
