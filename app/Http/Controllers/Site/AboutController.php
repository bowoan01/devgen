<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\Setting;
use App\Models\TeamMember;

class AboutController extends Controller
{
    public function __invoke()
    {
        return view('site.about', [
            'story' => Setting::value('about_story', 'Devengour is a boutique software house delivering beautiful, scalable solutions.'),
            'mission' => Setting::value('about_mission', 'To empower organizations with thoughtful digital products that accelerate growth.'),
            'vision' => Setting::value('about_vision', 'A world where technology feels effortless for every team.'),
            'values' => [
                'Innovation' => Setting::value('value_innovation', 'We explore beyond the obvious to unlock bold solutions.'),
                'Collaboration' => Setting::value('value_collaboration', 'We build partnerships rooted in empathy and shared goals.'),
                'Excellence' => Setting::value('value_excellence', 'We obsess over the details so our clients shine.'),
            ],
            'team' => TeamMember::query()->ordered()->get(),
            'services' => Service::query()->ordered()->get(),
        ]);
    }
}
