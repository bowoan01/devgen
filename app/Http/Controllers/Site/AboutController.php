<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Models\TeamMember;

class AboutController extends Controller
{
    public function index()
    {
        $vision = Setting::getValue('company_vision', 'To craft digital products that feel effortless and deliver measurable value.');
        $mission = Setting::getValue('company_mission', 'We pair strategy with craft to launch resilient technology for modern organisations.');
        $story = Setting::getValue('company_story', 'Devengour started as a small collective of makers and has evolved into a full-scale studio delivering world-class solutions.');
        $values = Setting::getValue('company_values', [
            ['title' => 'Innovation', 'description' => 'We continuously experiment and learn to unlock better ways of working.'],
            ['title' => 'Collaboration', 'description' => 'We embrace radical transparency and co-creation with our partners.'],
            ['title' => 'Excellence', 'description' => 'We sweat the details and own the outcome from start to finish.'],
        ]);

        $team = TeamMember::query()->ordered()->get();

        return view('site.about', compact('vision', 'mission', 'story', 'values', 'team'));
    }
}
