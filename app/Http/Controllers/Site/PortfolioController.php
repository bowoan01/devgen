<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;

class PortfolioController extends Controller
{
    public function index(Request $request)
    {
        $category = $request->query('category');

        $projects = Project::query()
            ->with('images')
            ->published()
            ->when($category, fn ($query) => $query->where('category', $category))
            ->orderByDesc('published_at')
            ->paginate(9)
            ->withQueryString();

        $filters = [
            'all' => 'All',
            'web' => 'Web',
            'mobile' => 'Mobile',
            'design' => 'Design',
        ];

        return view('site.portfolio', compact('projects', 'filters', 'category'));
    }

    public function show(Project $project)
    {
        abort_unless($project->published_at, 404);

        $project->load('images');

        $related = Project::query()
            ->published()
            ->where('category', $project->category)
            ->whereKeyNot($project->getKey())
            ->take(3)
            ->get();

        return view('site.portfolio-show', [
            'project' => $project,
            'related' => $related,
        ]);
    }
}
