<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\Service;
use App\Models\Setting;
use App\Models\TeamMember;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::query()->updateOrCreate(
            ['email' => 'admin@devengour.com'],
            [
                'name' => 'Devengour Admin',
                'password' => Hash::make('Password123!'),
                'email_verified_at' => now(),
            ]
        );

        $services = [
            [
                'title' => 'Web Application Engineering',
                'excerpt' => 'High-performance platforms built with modern Laravel and cloud-native tooling.',
                'body' => 'From discovery and architecture to QA automation, our squads engineer resilient products with measurable impact.',
                'icon_class' => 'bi bi-window-stack',
                'display_order' => 1,
                'is_featured' => true,
            ],
            [
                'title' => 'Mobile Experience Design',
                'excerpt' => 'Native and cross-platform experiences with premium design systems.',
                'body' => 'We blend research, motion design, and robust engineering practices to deliver mobile apps your audience will love.',
                'icon_class' => 'bi bi-phone-flip',
                'display_order' => 2,
                'is_featured' => true,
            ],
            [
                'title' => 'Product Strategy & Advisory',
                'excerpt' => 'Partner with product strategists to align outcomes, roadmaps, and market fit.',
                'body' => 'Our strategists run discovery sprints, design measurable experiments, and coach teams on product thinking.',
                'icon_class' => 'bi bi-bezier2',
                'display_order' => 3,
                'is_featured' => true,
            ],
            [
                'title' => 'Experience Design Systems',
                'excerpt' => 'Craft unified systems for product teams to scale quality with speed.',
                'body' => 'We audit current experiences, build scalable tokens and components, and train teams for sustainable adoption.',
                'icon_class' => 'bi bi-palette2',
                'display_order' => 4,
                'is_featured' => false,
            ],
        ];

        foreach ($services as $service) {
            Service::query()->updateOrCreate(
                ['slug' => Str::slug($service['title'])],
                $service
            );
        }

        Project::query()->updateOrCreate(
            ['slug' => 'aurora-commerce-suite'],
            [
                'title' => 'Aurora Commerce Suite',
                'category' => 'web',
                'summary' => 'Reimagining B2B purchasing with a modular commerce platform and design system.',
                'problem_text' => 'The client faced fragmented procurement workflows and slow releases across regional teams.',
                'solution_text' => 'Devengour delivered a unified design system, modular checkout flows, and real-time dashboards, reducing release cycles by 40%.',
                'tech_stack' => ['Laravel', 'Bootstrap 5', 'MySQL', 'Redis'],
                'testimonial_author' => 'Farah Santoso, COO',
                'testimonial_text' => 'Devengour felt like an extension of our team—disciplined, strategic, and relentlessly focused on value.',
                'is_featured' => true,
                'published_at' => now()->subDays(20),
            ]
        );

        TeamMember::query()->updateOrCreate(
            ['name' => 'Alya Pramesti'],
            [
                'role_title' => 'Chief Executive Officer',
                'bio' => 'Product strategist with a decade of experience launching fintech and SaaS ventures across Southeast Asia.',
                'linkedin_url' => 'https://www.linkedin.com/in/alyapramesti',
                'sort_order' => 1,
            ]
        );

        TeamMember::query()->updateOrCreate(
            ['name' => 'Dimas Wirawan'],
            [
                'role_title' => 'Director of Engineering',
                'bio' => 'Leads Devengour engineering practices across cloud-native architecture, QA automation, and DevOps culture.',
                'linkedin_url' => 'https://www.linkedin.com/in/dimaswirawan',
                'sort_order' => 2,
            ]
        );

        TeamMember::query()->updateOrCreate(
            ['name' => 'Nadine Halim'],
            [
                'role_title' => 'Head of Experience Design',
                'bio' => 'Design leader focused on inclusive product experiences, service design, and scalable design systems.',
                'linkedin_url' => 'https://www.linkedin.com/in/nadinehalim',
                'sort_order' => 3,
            ]
        );

        Setting::query()->updateOrCreate(
            ['key' => 'company_intro'],
            ['value' => 'We are a boutique team of engineers, designers, and strategists crafting experiences for the future.']
        );

        Setting::query()->updateOrCreate(
            ['key' => 'company_values'],
            ['value' => [
                ['title' => 'Innovation', 'description' => 'We challenge assumptions and deliver inventive solutions.'],
                ['title' => 'Collaboration', 'description' => 'We work shoulder-to-shoulder with partners and teams.'],
                ['title' => 'Excellence', 'description' => 'We craft premium experiences with measurable outcomes.'],
            ]]
        );
    }
}
