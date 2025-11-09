<footer class="bg-dark text-white py-5 mt-5">
    <div class="container">
        <div class="row gy-4">
            <div class="col-md-5">
                <h4 class="fw-semibold">Devengour</h4>
                <p class="text-white-50">We are the software house that brings strategy, design, and engineering together to build scalable digital products.</p>
                <div class="d-flex gap-3">
                    <a class="text-white-50" href="https://www.linkedin.com/company/devengour" target="_blank" rel="noopener">LinkedIn</a>
                    <a class="text-white-50" href="https://www.instagram.com/devengour" target="_blank" rel="noopener">Instagram</a>
                    <a class="text-white-50" href="https://www.behance.net/devengour" target="_blank" rel="noopener">Behance</a>
                </div>
            </div>
            <div class="col-md-3">
                <h6 class="fw-semibold text-uppercase small">Navigation</h6>
                <ul class="list-unstyled text-white-50">
                    <li><a class="text-white-50 text-decoration-none" href="{{ route('site.home') }}">Home</a></li>
                    <li><a class="text-white-50 text-decoration-none" href="{{ route('site.services') }}">Services</a></li>
                    <li><a class="text-white-50 text-decoration-none" href="{{ route('site.portfolio') }}">Portfolio</a></li>
                    <li><a class="text-white-50 text-decoration-none" href="{{ route('site.contact') }}">Contact</a></li>
                </ul>
            </div>
            <div class="col-md-4">
                <h6 class="fw-semibold text-uppercase small">Contact</h6>
                <p class="text-white-50 mb-1">Level 18, Global Innovation Hub, Jakarta</p>
                <p class="text-white-50 mb-1"><a class="text-white-50 text-decoration-none" href="mailto:hello@devengour.com">hello@devengour.com</a></p>
                <p class="text-white-50 mb-0"><a class="text-white-50 text-decoration-none" href="https://wa.me/6281234567890" target="_blank" rel="noopener">WhatsApp us</a></p>
            </div>
        </div>
        <div class="d-flex justify-content-between align-items-center pt-4 mt-4 border-top border-secondary">
            <small class="text-white-50">© {{ date('Y') }} Devengour. All rights reserved.</small>
            <small class="text-white-50">Crafted with precision.</small>
        </div>
    </div>
</footer>
