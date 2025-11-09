# Devengour Company Profile Website — Implementation Plan

*(CDN-Only • Single `web.php` • No Blade Components • No Node/Vite/Tailwind)*

## 0 Compliance Checklist

* ✅ **No Node/npm/Vite/Webpack/Mix** — CDN assets only
* ✅ **No Tailwind / Alpine / SPA frameworks**
* ✅ **No Blade components** (`resources/views/components/*` not used)
* ✅ **All routes in `routes/web.php`** (no additional route files, no URL prefixes)
* ✅ **Bootstrap 5 + Vanilla JS + jQuery AJAX** for interactivity
* ✅ **Yajra DataTables (server-side)** for admin lists
* ✅ **LightGallery.js** for portfolio galleries
* ✅ **Aligned with PRD scope** (Home, About, Services, Portfolio, Contact + lightweight CMS)

---

## 1 Scope Recap & Approach

* **Public site**: Home (hero, featured services/projects), About (story, values, team), Services (overview & detail), Portfolio (filterable gallery using **LightGallery** + project detail), Contact (AJAX form, map, socials/WhatsApp).
* **Lightweight CMS / Admin**: CRUD for Services, Projects (+ images), Team Members; manage Contact messages (read/archive/delete/export).
* **Stack**: Laravel **12** (PHP 8.3), MySQL/MariaDB, Blade (plain templates), **Bootstrap 5** (CDN), **Vanilla JS + jQuery AJAX**, **Yajra DataTables** (server-side), **LightGallery.js**, Laravel Mail (SMTP/Mailgun/Gmail).
* **No build tools**: no Node, Vite, Mix, or Tailwind. All assets from CDN + static files under `public/`.

---

## 2 High-Level Architecture

```
Browser (Public + Admin)
   │
   ▼
Laravel 12  (Controllers • FormRequests • Policies/Gates)
   │            ├─ Mail (SMTP / Mailgun / Gmail)
   │            └─ Cache/Queue (file or Redis, optional)
   ▼
MySQL / MariaDB  (Eloquent ORM)
```

* **Public** → Blade views with Bootstrap 5; portfolio uses **LightGallery**.
* **Admin** → jQuery AJAX + **Yajra DataTables (server-side)**; CRUD endpoints return JSON.
* **Email** → Laravel Mail with validation + notifications.
* **Queues** optional (Supervisor/Redis); fallback to synchronous mail if not available.

---

## 3 Environment & Tooling

| Environment | Purpose          | Notes                                                               |
| ----------- | ---------------- | ------------------------------------------------------------------- |
| Local       | Development & QA | Sail/Valet/Homestead; dedicated `.env`; Telescope optional          |
| Staging     | Review & UAT     | HTTPS; seeded demo data; Mailtrap for email                         |
| Production  | Live             | cPanel / VPS / Forge; HTTPS + DB backups; Supervisor if queues used |

**Composer dependencies**: Laravel 12, **yajra/laravel-datatables**, optional SEO package, **laravel/breeze** (auth).
**Not used**: `package.json`, `vite.config.js`, `node_modules/`.

**CDN pins (recommended)**:

* Bootstrap **5.3.x** (bundle)
* jQuery **3.7.x**
* DataTables **1.13.x** (+ Bootstrap 5 integration)
* LightGallery **2.x** (core + thumbnail + zoom plugins)
* Feather or Font Awesome (icons)
* Google Fonts: Poppins / Inter

**Example includes (place in layouts):**

```html
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/lightgallery@2.7.2/css/lightgallery-bundle.min.css" rel="stylesheet">

<script src="https://code.jquery.com/jquery-3.7.1.min.js" defer></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" defer></script>
<script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js" defer></script>
<script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js" defer></script>
<script src="https://cdn.jsdelivr.net/npm/lightgallery@2.7.2/lightgallery.umd.min.js" defer></script>
<script src="https://cdn.jsdelivr.net/npm/lightgallery@2.7.2/plugins/thumbnail/lg-thumbnail.umd.min.js" defer></script>
<script src="https://cdn.jsdelivr.net/npm/lightgallery@2.7.2/plugins/zoom/lg-zoom.umd.min.js" defer></script>

<script src="/js/app.js" defer></script>
```

---

## 4 Database Design

| Table                 | Key Columns                                                                                                                                                         | Relationships                | Purpose                             |
| --------------------- | ------------------------------------------------------------------------------------------------------------------------------------------------------------------- | ---------------------------- | ----------------------------------- |
| `users`               | name, email (unique), password, role, last_login_at                                                                                                                 | —                            | Admin accounts                      |
| `services`            | title, slug (unique), excerpt, body, icon_class, display_order, is_featured                                                                                         | —                            | Services page + homepage highlights |
| `projects`            | title, slug, category (web/mobile/design), summary, problem_text, solution_text, tech_stack (json), testimonial_author, testimonial_text, is_featured, published_at | **hasMany** `project_images` | Portfolio                           |
| `project_images`      | project_id (FK), file_path, caption, display_order                                                                                                                  | **belongsTo** `projects`     | Gallery (LightGallery)              |
| `team_members`        | name, role_title, bio, photo_path, linkedin_url, sort_order                                                                                                         | —                            | About → Team                        |
| `contact_messages`    | name, email, company, phone, message, status(new/read/archived), responded_at, meta(json)                                                                           | —                            | Contact inbox                       |
| `settings` (optional) | key (unique), value (text/json)                                                                                                                                     | —                            | Global meta (social, hero, etc.)    |

* Index: `slug`, `is_featured`, `status`, and all FKs.
* Optional **soft deletes** for `projects` / `services`.

---

## 5 Routing & Controllers (single **`routes/web.php`**)

**Public**

```php
Route::get('/', [Site\HomeController::class, 'index'])->name('site.home');
Route::get('/about', [Site\AboutController::class, 'index'])->name('site.about');

Route::get('/services', [Site\ServiceController::class, 'index'])->name('site.services.index');
Route::get('/services/{slug}', [Site\ServiceController::class, 'show'])->name('site.services.show');

Route::get('/portfolio', [Site\PortfolioController::class, 'index'])->name('site.portfolio.index');
Route::get('/portfolio/{slug}', [Site\PortfolioController::class, 'show'])->name('site.portfolio.show');

Route::get('/contact', [Site\ContactController::class, 'show'])->name('site.contact.show');
Route::post('/contact', [Site\ContactController::class, 'store'])->name('site.contact.store'); // JSON for AJAX + redirect fallback
```

**Admin** *(still inside `web.php`, no URL prefix; protect with middleware)*:

```php
Route::middleware(['auth','verified'])->group(function () {
    Route::get('/dashboard', [Admin\DashboardController::class, 'index'])->name('admin.dashboard');

    // Services
    Route::get('/admin/services', [Admin\ServiceController::class, 'index'])->name('admin.services.index');
    Route::get('/admin/services/data', [Admin\ServiceController::class, 'data'])->name('admin.services.data'); // Yajra JSON
    Route::post('/admin/services', [Admin\ServiceController::class, 'store'])->name('admin.services.store');
    Route::put('/admin/services/{id}', [Admin\ServiceController::class, 'update'])->name('admin.services.update');
    Route::delete('/admin/services/{id}', [Admin\ServiceController::class, 'destroy'])->name('admin.services.destroy');

    // Projects
    Route::get('/admin/projects', [Admin\ProjectController::class, 'index'])->name('admin.projects.index');
    Route::get('/admin/projects/data', [Admin\ProjectController::class, 'data'])->name('admin.projects.data');
    Route::post('/admin/projects', [Admin\ProjectController::class, 'store'])->name('admin.projects.store');
    Route::put('/admin/projects/{id}', [Admin\ProjectController::class, 'update'])->name('admin.projects.update');
    Route::delete('/admin/projects/{id}', [Admin\ProjectController::class, 'destroy'])->name('admin.projects.destroy');

    // Project images
    Route::post('/admin/projects/{project}/images', [Admin\ProjectImageController::class, 'store'])->name('admin.projects.images.store');
    Route::delete('/admin/project-images/{image}', [Admin\ProjectImageController::class, 'destroy'])->name('admin.projects.images.destroy');
    Route::put('/admin/projects/{project}/images/reorder', [Admin\ProjectImageController::class, 'reorder'])->name('admin.projects.images.reorder');

    // Team
    Route::get('/admin/teams', [Admin\TeamController::class, 'index'])->name('admin.teams.index');
    Route::get('/admin/teams/data', [Admin\TeamController::class, 'data'])->name('admin.teams.data');
    Route::post('/admin/teams', [Admin\TeamController::class, 'store'])->name('admin.teams.store');
    Route::put('/admin/teams/{id}', [Admin\TeamController::class, 'update'])->name('admin.teams.update');
    Route::delete('/admin/teams/{id}', [Admin\TeamController::class, 'destroy'])->name('admin.teams.destroy');

    // Contacts
    Route::get('/admin/contacts', [Admin\ContactMessageController::class, 'index'])->name('admin.contacts.index');
    Route::get('/admin/contacts/data', [Admin\ContactMessageController::class, 'data'])->name('admin.contacts.data');
    Route::get('/admin/contacts/{id}', [Admin\ContactMessageController::class, 'show'])->name('admin.contacts.show');
    Route::patch('/admin/contacts/{id}/read', [Admin\ContactMessageController::class, 'markAsRead'])->name('admin.contacts.read');
    Route::delete('/admin/contacts/{id}', [Admin\ContactMessageController::class, 'destroy'])->name('admin.contacts.destroy');
    Route::get('/admin/contacts/export', [Admin\ContactMessageController::class, 'exportCsv'])->name('admin.contacts.export');
});
```

> **Note**: No URL prefix; separation is enforced by **middleware** and **route names** (`admin.*`).

---

## 6 Frontend Implementation (Plain Blade + Partials)

**Layouts**

* `resources/views/layouts/app.blade.php` (public)
* `resources/views/layouts/admin.blade.php` (admin)
* Use `@yield('title')`, `@yield('content')`, `@stack('styles')`, `@stack('scripts')`.

**Partials**

* `resources/views/partials/navbar.blade.php`
* `resources/views/partials/footer.blade.php`
* `resources/views/partials/flash.blade.php`

**Public Views**

* `resources/views/site/home.blade.php`
* `resources/views/site/about.blade.php`
* `resources/views/site/services.blade.php`, `service-show.blade.php`
* `resources/views/site/portfolio.blade.php`, `portfolio-show.blade.php` (initialize LightGallery)
* `resources/views/site/contact.blade.php` (AJAX form)

**Admin Views**

* `resources/views/admin/dashboard/index.blade.php`
* `resources/views/admin/services/index.blade.php` (+ modal form)
* `resources/views/admin/projects/index.blade.php`, `projects/form.blade.php`
* `resources/views/admin/teams/index.blade.php`
* `resources/views/admin/contacts/index.blade.php` (+ detail modal/off-canvas)

**Assets**

* `public/js/app.js`: CSRF setup, small helpers, DataTables & LightGallery initializers.
* Optional overrides in `public/css/app.css`.
* Page-scoped JS via `@push('scripts')` per view.

**LightGallery init** (portfolio detail):

```js
document.addEventListener('DOMContentLoaded', function () {
  const el = document.getElementById('project-gallery');
  if (el && window.lightGallery) {
    lightGallery(el, { selector: '.gallery-item', plugins: [lgZoom, lgThumbnail] });
  }
});
```

---

## 7 Admin UX Details

* **Yajra DataTables (server-side)** for Services/Projects/Team/Contacts (pagination, sort, search).
* **jQuery AJAX CRUD**:

  * Request: `POST/PUT/DELETE` to JSON endpoints
  * Success: `{ "success": true, "message": "Saved", "data": { ... } }`
  * Validation error: `{ "success": false, "message": "Validation failed", "errors": { "field": ["msg"] } }`
* **Project images**: preview via FileReader; drag-and-drop reorder sends ordered IDs to `/images/reorder`.
* **Status/Visibility**: toggle publish/featured via `PATCH` endpoints.
* Access control with `auth` and simple gate/role checks (Admin/Editor).

---

## 8 Security & Compliance

* **CSRF** on every form; jQuery AJAX sets `X-CSRF-TOKEN`.
* **HTTPS**, secure cookies, HSTS (if supported), production `APP_DEBUG=false`.
* **Rate limiting** on login & contact POST.
* **Validation & sanitization** on all inputs (length, mime, size).
* **Uploads** under `storage/app/public/uploads/...`, served via `php artisan storage:link`.
* **Email** via SMTP credentials in `.env`.
* **Privacy**: archive/purge old contact messages on schedule.

---

## 9 Content Management Flow

1. **Services** → DataTable → modal create/edit → AJAX save → drag reorder → visible in Home/Services.
2. **Portfolio** → create project → upload gallery → reorder → **LightGallery** on public → publish toggle.
3. **Team** → CRUD + order + LinkedIn → shown on About page.
4. **Contacts** → public form stores + emails admin → DataTable (mark read/archive/delete, CSV export).

---

## 10 Testing Strategy

* **Unit**: model relations, scopes (featured), accessors.
* **Feature**: public route rendering; contact form (valid/invalid); auth; admin CRUD JSON responses.
* **Integration**: DataTables JSON schema, image upload & reorder, mail dispatch (Mail fake).
* **Smoke (Dusk optional)**: login, create/edit service, upload image, mark contact as read.

---

## 11 Deployment Checklist

```
composer install --optimize-autoloader
cp .env.example .env
php artisan key:generate
# set APP_URL, DB_*, MAIL_*, GA_ID (optional)
php artisan migrate --seed
php artisan storage:link
php artisan optimize
# optional: queue worker (Supervisor) or keep sync
# cron: * * * * * php artisan schedule:run
```

* cPanel/VPS/Forge: enable HTTPS, configure DB backups, verify SMTP.
* **No build step** (CDN-only).

---

## 12 Timeline Alignment (7-Week MVP)

| Week | Focus                                                           |
| ---- | --------------------------------------------------------------- |
| 1    | Wireframes, sitemap, content inventory                          |
| 2    | Figma UI (Bootstrap-friendly), assets                           |
| 3    | Laravel setup, auth, migrations, base routes                    |
| 4–5  | Public pages (Bootstrap), LightGallery, admin CRUD + DataTables |
| 6    | Contact + email, caching, automated tests                       |
| 7    | Staging UAT, fixes, deploy, basic monitoring                    |

---

## 13 Open Questions

1. Hosting choice (cPanel vs VPS/Forge) & whether Redis/Supervisor will be available.
2. Email provider (SMTP/Gmail/Mailgun) & sending domain/DNS (SPF/DKIM).
3. Image guidelines (recommended resolution & max size).
4. Ownership of SEO copy/meta and GA4 configuration.
5. Multilingual requirement now or later (i18n).

---

## 14 File & Path Contract (Enforced)

**Forbidden**

* `package.json`, `vite.config.js`, `node_modules/`
* `resources/views/components/` (and any component usage)

**Required**

* `routes/web.php` (all routes)
* Controllers: `app/Http/Controllers/Site/*`, `app/Http/Controllers/Admin/*`
* Requests: `app/Http/Requests/*`
* Models: `app/Models/*`
* Layouts: `resources/views/layouts/{app,admin}.blade.php`
* Partials: `resources/views/partials/{navbar,footer,flash}.blade.php`
* Public views: `resources/views/site/{home,about,services,service-show,portfolio,portfolio-show,contact}.blade.php`
* Admin views: `resources/views/admin/{dashboard,services,projects,teams,contacts}/*.blade.php`
* Assets: `public/js/app.js`, optional `public/css/app.css`
* Uploads: `storage/app/public/uploads` (served via `storage:link`)

If any forbidden artifacts appear, remove them and update the plan to remain compliant.
