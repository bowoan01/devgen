<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Service;
use App\Models\Setting;
use App\Models\TeamMember;
use Illuminate\Support\Facades\Schema;

class HomeController extends Controller
{
    public function __invoke()
    {
        $heroHeadline = Setting::value('hero_headline', 'We build digital experiences that scale.');
        $heroSubheadline = Setting::value('hero_subheadline', 'Devgenfour crafts tailor-made software, empowering teams to move faster.');

        return view('site.home', [
            'heroHeadline' => $heroHeadline,
            'heroSubheadline' => $heroSubheadline,
            'services' => Schema::hasTable('services') ? Service::query()->featured()->ordered()->take(4)->get() : collect(),
            'projects' => Schema::hasTable('projects') ? Project::query()->featured()->with('images')->orderByDesc('published_at')->take(3)->get() : collect(),
            'team' => Schema::hasTable('team_members') ? TeamMember::query()->ordered()->take(4)->get() : collect(),
        ]);
    }
}
