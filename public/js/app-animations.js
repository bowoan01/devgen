(function () {
    const prefersReducedMotion = window.matchMedia(
        "(prefers-reduced-motion: reduce)"
    ).matches;

    const addVisibleClass = (el) => {
        el.classList.add("is-visible");
    };

    const initIntersectionObserver = () => {
        const targets = document.querySelectorAll("[data-animate], [data-stagger]");
        if (!targets.length) return;
        if (prefersReducedMotion || typeof IntersectionObserver === "undefined") {
            targets.forEach(addVisibleClass);
            return;
        }

        const observer = new IntersectionObserver(
            (entries, observerInstance) => {
                entries.forEach((entry) => {
                    if (!entry.isIntersecting) return;
                    addVisibleClass(entry.target);
                    observerInstance.unobserve(entry.target);
                });
            },
            {
                threshold: 0.2,
                rootMargin: "0px 0px -10% 0px",
            }
        );

        targets.forEach((target) => observer.observe(target));
    };

    const initSmoothAnchors = () => {
        const links = document.querySelectorAll('a[href^="#"]');
        links.forEach((link) => {
            link.addEventListener("click", (event) => {
                const hash = link.getAttribute("href");
                if (!hash || hash.length === 1) return;
                const target = document.querySelector(hash);
                if (!target) return;
                event.preventDefault();
                target.scrollIntoView({ behavior: prefersReducedMotion ? "auto" : "smooth" });
                target.setAttribute("tabindex", "-1");
                target.focus({ preventScroll: true });
            });
        });
    };

    const initPageTransitions = () => {
        if (prefersReducedMotion) return;
        const body = document.body;
        body.classList.add("page-transition-enter");
        window.requestAnimationFrame(() => {
            body.classList.add("page-transition-ready");
        });

        const supportsHistory = "pushState" in window.history;
        if (!supportsHistory) return;

        const handleLinkClick = (event) => {
            const link = event.currentTarget;
            const target = link.getAttribute("target");
            const href = link.getAttribute("href");
            if (
                event.metaKey ||
                event.ctrlKey ||
                event.shiftKey ||
                event.altKey ||
                target === "_blank" ||
                !href ||
                href.startsWith("#") ||
                href.startsWith("mailto:") ||
                href.startsWith("tel:")
            ) {
                return;
            }
            if (link.hasAttribute("data-bs-toggle")) return;
            if (link.origin !== window.location.origin) return;
            event.preventDefault();
            body.classList.add("page-transition-exit");
            window.requestAnimationFrame(() => {
                body.classList.add("page-transition-leave");
            });
            setTimeout(() => {
                window.location.href = href;
            }, 220);
        };

        const links = document.querySelectorAll("a[href]");
        links.forEach((link) => link.addEventListener("click", handleLinkClick));

        window.addEventListener("pageshow", () => {
            body.classList.remove("page-transition-exit", "page-transition-leave");
            body.classList.add("page-transition-enter", "page-transition-ready");
        });
    };

    document.addEventListener("DOMContentLoaded", () => {
        initIntersectionObserver();
        initSmoothAnchors();
        initPageTransitions();
    });
})();
