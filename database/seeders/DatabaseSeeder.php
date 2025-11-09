<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\ProjectImage;
use App\Models\Service;
use App\Models\Setting;
use App\Models\TeamMember;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();

        $admin = User::updateOrCreate(
            ['email' => 'admin@devengour.com'],
            [
                'name' => 'Devengour Admin',
                'password' => 'password',
                'role' => 'admin',
            ]
        );

        Service::truncate();
        $services = [
            [
                'title' => 'Web App Development',
                'excerpt' => 'Composable platforms, engineered for reliability and scale.',
                'body' => "Our multidisciplinary squads design, build, and optimise digital platforms that adapt to changing business needs. From complex dashboards to self-serve portals, we craft experiences tuned for performance.",
                'icon_class' => 'bi bi-window-split',
                'display_order' => 1,
                'is_featured' => true,
            ],
            [
                'title' => 'Mobile App Development',
                'excerpt' => 'Premium iOS and Android products that feel as good as they look.',
                'body' => "Devengour builds delightful mobile experiences with pixel-perfect interfaces, offline-first sync, and instrumentation for continuous learning.",
                'icon_class' => 'bi bi-phone',
                'display_order' => 2,
                'is_featured' => true,
            ],
            [
                'title' => 'UI/UX Design',
                'excerpt' => 'Human-centred design systems that accelerate product delivery.',
                'body' => "From research to design systems, we craft journeys that balance usability, aesthetics, and brand differentiation.",
                'icon_class' => 'bi bi-bezier2',
                'display_order' => 3,
                'is_featured' => true,
            ],
            [
                'title' => 'Product Strategy & Consultation',
                'excerpt' => 'Guided roadmaps, operating models, and experimentation frameworks.',
                'body' => "We collaborate with executive teams to define north-star metrics, prioritise backlogs, and orchestrate smooth launches.",
                'icon_class' => 'bi bi-compass',
                'display_order' => 4,
                'is_featured' => false,
            ],
        ];

        foreach ($services as $service) {
            Service::create($service + ['slug' => Str::slug($service['title'])]);
        }

        ProjectImage::truncate();
        Project::truncate();
        $project = Project::create([
            'title' => 'Nimbus Commerce Platform',
            'slug' => 'nimbus-commerce-platform',
            'category' => 'web',
            'summary' => 'A modular B2B commerce suite powering multi-market launches for a regional retailer.',
            'problem_text' => "Nimbus needed to unify disparate ordering experiences while supporting rapid experimentation.",
            'solution_text' => "Devengour delivered a headless commerce architecture with design system-driven storefronts and analytics dashboards.",
            'tech_stack' => ['Laravel', 'Vue', 'MySQL', 'Algolia'],
            'testimonial_author' => 'Raka Wijaya — Chief Digital Officer',
            'testimonial_text' => 'Devengour felt like an extension of our own team. The platform scaled effortlessly during launch week.',
            'is_featured' => true,
            'published_at' => now()->subMonths(2),
        ]);

        TeamMember::truncate();
        TeamMember::create([
            'name' => 'Nadya Pratama',
            'role_title' => 'Managing Partner',
            'bio' => 'Product strategist with a decade of experience launching enterprise-grade platforms across APAC.',
            'linkedin_url' => 'https://linkedin.com/in/nadyapratama',
            'sort_order' => 1,
        ]);
        TeamMember::create([
            'name' => 'Samuel Wirawan',
            'role_title' => 'Head of Engineering',
            'bio' => 'Leads cross-functional squads delivering cloud-native applications at scale.',
            'linkedin_url' => 'https://linkedin.com/in/samuelwirawan',
            'sort_order' => 2,
        ]);
        TeamMember::create([
            'name' => 'Amelia Chan',
            'role_title' => 'Experience Design Director',
            'bio' => 'Design leader crafting future-ready experiences and design systems for global brands.',
            'linkedin_url' => 'https://linkedin.com/in/ameliachan',
            'sort_order' => 3,
        ]);

        Setting::truncate();
        $settings = [
            'hero_headline' => 'We build digital experiences that scale.',
            'hero_subheadline' => 'Devengour crafts tailor-made software, empowering teams to move faster.',
            'about_story' => 'Founded in Jakarta, Devengour is a boutique studio helping organisations orchestrate elegant, scalable technology.',
            'about_mission' => 'To empower teams with thoughtful digital products that move the business forward.',
            'about_vision' => 'Designing technology that feels effortless, inclusive, and future-ready.',
            'value_innovation' => 'We explore beyond the obvious to unlock bold solutions.',
            'value_collaboration' => 'We build partnerships rooted in empathy and shared goals.',
            'value_excellence' => 'We obsess over the details so our clients shine.',
            'contact_address' => 'Jl. Sudirman No. 45, Jakarta, Indonesia',
            'contact_email' => 'hello@devengour.com',
            'contact_phone' => '+62 812-3456-7890',
            'contact_whatsapp' => 'https://wa.me/6281234567890',
        ];

        foreach ($settings as $key => $value) {
            Setting::create(['key' => $key, 'value' => $value]);
        }
    }
}
