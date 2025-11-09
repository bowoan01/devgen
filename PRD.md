# 🧭 Product Requirements Document (PRD)

### Devengour Company Profile Website

**Revised — Built with Laravel + PHP + Bootstrap + LightGallery + jQuery AJAX + Yajra**

---

## 1. Overview

**Product Name:** Devengour Company Profile Website
**Purpose:** To serve as the official digital presence of Devengour — a professional software house focused on building elegant, scalable, and high-quality digital products.
**Design Style:** Smooth, simple, minimalist, and professional with blue accents.
**Platform:** Web (desktop & mobile responsive)
**URL:** [www.devengour.com](http://www.devengour.com) *(placeholder)*

---

## 2. Background & Goals

Devengour has successfully handled multiple software development projects for various clients, but currently lacks an official website to showcase its brand and capabilities.
This website will act as a **digital front door** — strengthening credibility, communicating expertise, and generating inbound leads.

### 🎯 Goals:

* Build **brand credibility** and professional identity.
* Present Devengour’s **services, team, and portfolio** clearly.
* Serve as an **inbound lead generator** through contact forms.
* Improve visibility in search results through strong SEO.
* Provide a **professional touchpoint** for clients and partners.

---

## 3. Target Audience

1. **Potential clients (B2B):** Startups, SMEs, and government organizations looking for software development partners.
2. **Job seekers:** Designers, developers, and product managers interested in joining Devengour.
3. **Business partners:** Agencies or vendors seeking collaboration.

---

## 4. Website Structure & Main Pages

### 🏠 Home

* Hero section with tagline:
  **“We build digital experiences that scale.”**
  CTA: **“Let’s Build Together” → Contact page**
* Highlights of main services.
* Showcase of 3 featured projects.
* Brief introduction about Devengour.
* Footer with navigation, contact info, and social links.

### 👥 About Us

* Company vision & mission.
* Devengour’s story and values.
* Core team (photo, name, position, LinkedIn).
* Core values: Innovation, Collaboration, Excellence.

### 🧩 Services

Main services displayed in Bootstrap cards:

* Web App Development
* Mobile App Development
* UI/UX Design
* Product Strategy & Consultation

Each with brief descriptions and icons.

### 💼 Portfolio

* Project gallery with filters (Web / Mobile / Design).
* Each project page includes:

  * Problem & solution summary
  * Tech stack
  * Mockup screenshots
  * Optional client testimonial
* **LightGallery.js** integration for smooth, responsive image lightbox & carousel experience.

### ✉️ Contact

* Simple form (name, email, company, message).
* AJAX form submission using **jQuery AJAX**.
* Email integration via Laravel Mail.
* Google Maps location embed.
* Social links and WhatsApp contact.

---

## 5. Design Requirements

### 🎨 Visual Identity

* **Style:** Minimalist, clean, and modern.
* **Primary Color:** Blue `#2563EB`
* **Secondary Colors:** White `#FFFFFF`, Light gray `#F9FAFB`, Dark gray `#1E293B`
* **Typography:** Poppins / Inter (Google Fonts)
* **Layout:** 12-column Bootstrap grid with generous whitespace.
* **Icons:** Feather or Font Awesome outline icons.

### 💡 UX Principles

* Clear navigation (max 5 menu items).
* Consistent CTAs throughout the site.
* Smooth animations (CSS transitions or AOS).
* Fully responsive and mobile-first.
* Fast load speed and accessibility focused.

---

## 6. Technical Requirements

### 🛠️ Tech Stack

| Layer            | Technology                                       |
| ---------------- | ------------------------------------------------ |
| Backend          | **Laravel (PHP 8.3)**                            |
| Frontend         | **Bootstrap 5**, **Vanilla JS**, **jQuery AJAX** |
| Database         | **MySQL / MariaDB**                              |
| Table Management | **Yajra Laravel DataTables (server-side)**       |
| Gallery Display  | **LightGallery.js**                              |
| Deployment       | **cPanel / VPS / Laravel Forge**                 |
| Hosting          | Shared or Cloud (DigitalOcean / AWS Lightsail)   |
| Version Control  | Git + GitHub / GitLab                            |
| Mail Integration | Laravel Mail (SMTP / Mailgun / Gmail)            |

---

### 🔧 Features & Implementation

* **Custom Lightweight CMS** for:

  * Page content (About, Services)
  * Portfolio CRUD
  * Contact form submissions

* **Data Handling:**

  * CRUD operations handled via **jQuery AJAX** (JSON response, no page reload)
  * **Yajra DataTables** for admin-side pagination, filtering, and sorting

* **Gallery:**

  * Portfolio uses **LightGallery.js** for responsive lightbox galleries

* **SEO Optimization:**

  * Clean URLs and meta tags
  * Sitemap.xml and robots.txt generation
  * Schema.org microdata (optional)

* **Performance:**

  * Lazy loading for images
  * Asset minification and caching
  * CDN-based assets (Bootstrap, jQuery, LightGallery)

* **Analytics:** Google Analytics 4

* **Security:** CSRF protection, HTTPS, and backend validation

---

## 7. Performance Goals

| Metric               | Target                    |
| -------------------- | ------------------------- |
| Page load time       | < 2.5 seconds             |
| Lighthouse SEO score | > 90                      |
| Responsiveness       | 100% across major devices |
| Form delivery rate   | 99% success rate          |

---

## 8. KPIs (Success Metrics)

| KPI                              | Target      |
| -------------------------------- | ----------- |
| Monthly contact form submissions | ≥ 15        |
| Average session duration         | > 2 minutes |
| Bounce rate                      | < 45%       |
| Lead conversion rate             | > 5%        |

---

## 9. Development Timeline (MVP)

|     Phase | Task                             | Duration |
| --------: | -------------------------------- | -------- |
|         1 | Requirements & wireframe         | 1 week   |
|         2 | UI/UX design (Figma)             | 1 week   |
|         3 | Laravel setup & routing          | 1 week   |
|         4 | Frontend integration (Bootstrap) | 2 weeks  |
|         5 | CMS, DataTables, and AJAX setup  | 1 week   |
|         6 | Testing & launch                 | 1 week   |
| **Total** | **7 weeks (MVP)**                |          |

---

## 10. Risks & Mitigation

| Risk                             | Mitigation                                   |
| -------------------------------- | -------------------------------------------- |
| Shared hosting deployment issues | Use Laravel Forge or VPS setup               |
| Incomplete content before launch | Use placeholder / dummy content              |
| Poor SEO performance             | Run SEO audit using Google Search Console    |
| Inconsistent responsiveness      | Cross-test on 5 major devices before release |

---