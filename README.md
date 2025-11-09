# Devengour Company Profile Platform

Devengour is a premium, content-managed company profile website built with Laravel 12 and PHP 8.3. The application showcases the company's services, projects, and leadership team while providing a secure CMS for administrators. The frontend uses a CDN-only stack with Bootstrap 5, Bootstrap Icons, Google Fonts, LightGallery.js, and vanilla JavaScript with jQuery for AJAX-driven interactions.

## Features

- **Elegant public site** featuring home, about, services, portfolio, and contact sections with responsive layouts and LightGallery-enhanced project galleries.
- **Admin dashboard** with authentication, rate limiting, and Yajra DataTables-powered CRUD for services, projects, project galleries, team members, and contact messages.
- **AJAX-first UX** delivering JSON responses, CSRF protection, and modal-driven create/update flows without page reloads.
- **Contact pipeline** that stores inquiries, sends notification emails, and enforces validation and throttling to mitigate abuse.
- **Configurable settings** allowing administrators to manage company metadata and hero content directly from the CMS.

## Technology Stack

- Laravel 12, PHP 8.3
- MySQL / MariaDB
- Bootstrap 5 (via CDN), Bootstrap Icons, Google Fonts
- jQuery, vanilla JavaScript, LightGallery.js (zoom + thumbnails)
- Yajra DataTables for server-side tables

## Getting Started

1. **Install dependencies**
   ```bash
   composer install
   ```
2. **Environment configuration**
   - Copy `.env.example` to `.env` and update database, mail, and application settings.
   - Ensure `APP_URL` uses `https://` in production for full HTTPS readiness.
3. **Generate application key**
   ```bash
   php artisan key:generate
   ```
4. **Run migrations and seeders**
   ```bash
   php artisan migrate --seed
   ```
5. **Link public storage**
   ```bash
   php artisan storage:link
   ```
6. **Serve the application**
   ```bash
   php artisan serve
   ```

## Admin Access

A default administrator is seeded for local onboarding:

- Email: `admin@devengour.com`
- Password: `Password123!`

Visit `/admin/login` to access the CMS.

## Frontend Assets

All assets are delivered over CDN links. No Node.js, npm, or bundlers are required. Custom scripts reside in `public/js/app.js` and styles in `public/css/app.css`.

## Security Considerations

- CSRF tokens applied to all forms and AJAX requests.
- Validation handled by dedicated FormRequest classes.
- Rate limiting guards login and contact submission endpoints.
- File uploads stored through Laravel's filesystem abstraction and exposed via `storage:link`.

## Testing

Execute the automated test suite with:

```bash
php artisan test
```

## Deployment Notes

- Configure production mail transport to ensure contact notifications are delivered.
- Ensure the `storage` and `bootstrap/cache` directories are writable by the web server.
- For drag-and-drop project gallery ordering, review and adapt logic in `public/js/app.js` if alternative UX is required.

## License

This project is provided for the Devengour company profile platform initiative. Refer to the MIT license bundled with Laravel for framework-level usage permissions.
