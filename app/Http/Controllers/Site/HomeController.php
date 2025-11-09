<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Service;
use App\Models\Setting;

class HomeController extends Controller
{
    public function index()
    {
        $hero = [
            'headline' => Setting::getValue('hero_headline', 'We build digital experiences that scale.'),
            'subheadline' => Setting::getValue('hero_subheadline', 'Devengour is the software partner for ambitious teams.'),
            'cta_label' => Setting::getValue('hero_cta_label', "Let’s Build Together"),
            'cta_url' => route('site.contact'),
        ];

        $featuredServices = Service::query()->featured()->take(4)->get();
        $featuredProjects = Project::query()->with('images')->featured()->take(3)->get();
        $values = Setting::getValue('company_values', [
            ['title' => 'Innovation', 'description' => 'We challenge norms to craft smarter digital solutions.'],
            ['title' => 'Collaboration', 'description' => 'We co-create with clients to deliver transformational impact.'],
            ['title' => 'Excellence', 'description' => 'We obsess over details to ensure premium quality in every delivery.'],
        ]);
        $intro = Setting::getValue('company_intro', 'We are a boutique team of engineers, designers, and strategists crafting experiences for the future.');

        return view('site.home', [
            'hero' => $hero,
            'featuredServices' => $featuredServices,
            'featuredProjects' => $featuredProjects,
            'values' => $values,
            'intro' => $intro,
        ]);
    }
}
