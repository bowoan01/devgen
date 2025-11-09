<?php

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;

class ProjectSeeder extends Seeder
{
    public function run(): void
    {
        $projects = [
            [
                'title' => 'Nimbus Commerce Platform',
                'slug' => 'nimbus-commerce-platform',
                'category' => 'web',
                'summary' => 'A modular B2B commerce suite powering multi-market launches for a regional retailer.',
                'problem_text' => 'Nimbus needed to unify disparate ordering experiences while supporting rapid experimentation.',
                'solution_text' => 'Devgenfour delivered a headless commerce architecture with design system-driven storefronts and analytics dashboards.',
                'tech_stack' => ['Laravel', 'Vue', 'MySQL', 'Algolia'],
                'testimonial_author' => 'Raka Wijaya — Chief Digital Officer',
                'testimonial_text' => 'Devgenfour felt like an extension of our own team. The platform scaled effortlessly during launch week.',
                'is_featured' => true,
                'published_at' => now()->subMonths(2),
            ],
            [
                'title' => 'Atlas HR Management Suite',
                'slug' => 'atlas-hr-management-suite',
                'category' => 'web',
                'summary' => 'A centralized HR management solution built for hybrid workplaces.',
                'problem_text' => 'Atlas needed an integrated platform to manage employees, attendance, and payroll across multiple locations.',
                'solution_text' => 'Devgenfour created a modular HR suite with role-based dashboards and dynamic analytics.',
                'tech_stack' => ['Laravel', 'Vue', 'PostgreSQL', 'Redis'],
                'testimonial_author' => 'Sarah Lim — HR Director',
                'testimonial_text' => 'The platform transformed our HR operations — everything is now in one place.',
                'is_featured' => false,
                'published_at' => now()->subMonths(3),
            ],
            [
                'title' => 'Nova Mobile Banking App',
                'slug' => 'nova-mobile-banking-app',
                'category' => 'mobile',
                'summary' => 'A next-generation mobile banking experience with seamless onboarding.',
                'problem_text' => 'Nova Bank required a modern mobile experience to attract younger users.',
                'solution_text' => 'Devgenfour developed an intuitive app with biometric login, instant transfers, and personal financial insights.',
                'tech_stack' => ['Flutter', 'Firebase', 'Laravel API'],
                'testimonial_author' => 'Andre Saputra — Product Manager',
                'testimonial_text' => 'User engagement went up 3x since launch. The feedback has been phenomenal.',
                'is_featured' => true,
                'published_at' => now()->subMonths(1),
            ],
            [
                'title' => 'Lumen Analytics Dashboard',
                'slug' => 'lumen-analytics-dashboard',
                'category' => 'web',
                'summary' => 'Real-time data visualization platform for enterprise clients.',
                'problem_text' => 'Clients needed real-time visibility across multiple KPIs and systems.',
                'solution_text' => 'We built a customizable dashboard engine using Laravel + Chart.js with role-based views.',
                'tech_stack' => ['Laravel', 'Chart.js', 'MySQL', 'Tailwind'],
                'testimonial_author' => 'Kevin Aditya — CTO',
                'testimonial_text' => 'Our leadership now makes decisions based on live data, not guesswork.',
                'is_featured' => false,
                'published_at' => now()->subWeeks(6),
            ],
            [
                'title' => 'Orion Design System',
                'slug' => 'orion-design-system',
                'category' => 'design',
                'summary' => 'A unified design system powering faster product delivery.',
                'problem_text' => 'Multiple product teams were creating inconsistent UI components.',
                'solution_text' => 'Devgenfour built a scalable design system with reusable components and documentation.',
                'tech_stack' => ['Figma', 'Storybook', 'Vue 3'],
                'testimonial_author' => 'Clara Wijaya — Head of Design',
                'testimonial_text' => 'Our designers and developers finally speak the same language.',
                'is_featured' => true,
                'published_at' => now()->subWeeks(10),
            ],
        ];

        foreach ($projects as $project) {
            Project::updateOrCreate(
                ['slug' => $project['slug']],
                $project
            );
        }
    }
}
