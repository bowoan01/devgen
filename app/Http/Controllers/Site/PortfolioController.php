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
            ->published()
            ->with('images')
            ->when($category, fn ($query) => $query->where('category', $category))
            ->orderByDesc('published_at')
            ->paginate(9)
            ->withQueryString();

        return view('site.portfolio', [
            'projects' => $projects,
            'category' => $category,
            'categories' => Project::CATEGORIES,
        ]);
    }

    public function show(Project $project)
    {
        abort_if(is_null($project->published_at), 404);

        return view('site.portfolio-show', [
            'project' => $project->load('images'),
        ]);
    }
}
