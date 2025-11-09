<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProjectRequest;
use App\Models\Project;
use Illuminate\Support\Carbon;
use Yajra\DataTables\Facades\DataTables;

class ProjectController extends Controller
{
    public function index()
    {
        return view('admin.projects.index', [
            'categories' => Project::CATEGORIES,
        ]);
    }

    public function data()
    {
        return DataTables::of(Project::query()->withCount('images')->select(['id', 'title', 'slug', 'category', 'is_featured', 'published_at']))
            ->editColumn('published_at', fn (Project $project) => optional($project->published_at)->format('d M Y') ?: 'Draft')
            ->editColumn('is_featured', fn (Project $project) => $project->is_featured ? 'Yes' : 'No')
            ->addColumn('actions', function (Project $project) {
                return view('admin.projects.partials.actions', compact('project'))->render();
            })
            ->rawColumns(['actions'])
            ->toJson();
    }

    public function store(ProjectRequest $request)
    {
        $project = Project::create($this->payload($request));

        return response()->json([
            'success' => true,
            'message' => 'Project created.',
            'data' => $project,
        ]);
    }

    public function show(Project $project)
    {
        return response()->json([
            'success' => true,
            'data' => $project->load('images'),
        ]);
    }

    public function update(ProjectRequest $request, Project $project)
    {
        $project->update($this->payload($request));

        return response()->json([
            'success' => true,
            'message' => 'Project updated.',
            'data' => $project->fresh()->load('images'),
        ]);
    }

    public function destroy(Project $project)
    {
        $project->delete();

        return response()->json([
            'success' => true,
            'message' => 'Project deleted.',
        ]);
    }

    public function toggleFeatured(Project $project)
    {
        $project->update(['is_featured' => !$project->is_featured]);

        return response()->json([
            'success' => true,
            'message' => 'Feature status updated.',
            'data' => $project->fresh(),
        ]);
    }

    public function publish(Project $project)
    {
        $project->update(['published_at' => now()]);

        return response()->json([
            'success' => true,
            'message' => 'Project published.',
            'data' => $project->fresh(),
        ]);
    }

    public function unpublish(Project $project)
    {
        $project->update(['published_at' => null]);

        return response()->json([
            'success' => true,
            'message' => 'Project unpublished.',
            'data' => $project->fresh(),
        ]);
    }

    protected function payload(ProjectRequest $request): array
    {
        return [
            'title' => $request->input('title'),
            'slug' => $request->input('slug'),
            'category' => $request->input('category'),
            'summary' => $request->input('summary'),
            'problem_text' => $request->input('problem_text'),
            'solution_text' => $request->input('solution_text'),
            'tech_stack' => $request->input('tech_stack'),
            'testimonial_author' => $request->input('testimonial_author'),
            'testimonial_text' => $request->input('testimonial_text'),
            'is_featured' => $request->boolean('is_featured'),
            'published_at' => $request->filled('published_at') ? Carbon::parse($request->input('published_at')) : null,
        ];
    }
}
