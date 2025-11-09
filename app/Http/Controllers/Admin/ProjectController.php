<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Models\Project;
use App\Models\ProjectImage;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class ProjectController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $projects = Project::query()->select(['id', 'title', 'slug', 'category', 'is_featured', 'published_at', 'created_at']);

            return DataTables::of($projects)
                ->editColumn('published_at', fn (Project $project) => optional($project->published_at)->format('d M Y'))
                ->addColumn('featured_label', fn (Project $project) => $project->is_featured ? 'Yes' : 'No')
                ->toJson();
        }

        return view('admin.projects.index');
    }

    public function store(StoreProjectRequest $request)
    {
        $data = $this->extractProjectPayload($request->validated());

        if ($request->hasFile('cover_image')) {
            $data['cover_image_path'] = $request->file('cover_image')->store('uploads/projects/covers', 'public');
        }

        $project = Project::create($data);

        $this->syncGallery($project, $request->file('gallery', []));

        return response()->json([
            'success' => true,
            'message' => 'Project created successfully.',
            'data' => $project->load('images'),
        ]);
    }

    public function show(Project $project)
    {
        $project->load('images');

        return response()->json([
            'success' => true,
            'data' => $project,
        ]);
    }

    public function update(UpdateProjectRequest $request, Project $project)
    {
        $data = $this->extractProjectPayload($request->validated());

        if ($request->hasFile('cover_image')) {
            if ($project->cover_image_path) {
                Storage::disk('public')->delete($project->cover_image_path);
            }

            $data['cover_image_path'] = $request->file('cover_image')->store('uploads/projects/covers', 'public');
        }

        $project->update($data);

        if ($request->filled('remove_gallery')) {
            ProjectImage::query()
                ->where('project_id', $project->id)
                ->whereIn('id', $request->input('remove_gallery', []))
                ->get()
                ->each(function (ProjectImage $image) {
                    Storage::disk('public')->delete($image->file_path);
                    $image->delete();
                });
        }

        if ($request->hasFile('gallery')) {
            $this->syncGallery($project, $request->file('gallery', []));
        }

        return response()->json([
            'success' => true,
            'message' => 'Project updated successfully.',
            'data' => $project->load('images'),
        ]);
    }

    public function destroy(Project $project)
    {
        if ($project->cover_image_path) {
            Storage::disk('public')->delete($project->cover_image_path);
        }

        $project->images->each(function (ProjectImage $image) {
            Storage::disk('public')->delete($image->file_path);
            $image->delete();
        });

        $project->delete();

        return response()->json([
            'success' => true,
            'message' => 'Project deleted successfully.',
        ]);
    }

    protected function extractProjectPayload(array $input): array
    {
        $payload = Arr::only($input, [
            'title',
            'slug',
            'category',
            'summary',
            'problem_text',
            'solution_text',
            'tech_stack',
            'testimonial_author',
            'testimonial_text',
            'is_featured',
            'published_at',
        ]);

        $payload['is_featured'] = (bool) ($payload['is_featured'] ?? false);

        if (isset($payload['tech_stack']) && is_array($payload['tech_stack'])) {
            $payload['tech_stack'] = array_values(array_filter(array_map('trim', $payload['tech_stack'])));
        }

        return $payload;
    }

    protected function syncGallery(Project $project, array $files): void
    {
        if (!count($files)) {
            return;
        }

        $nextOrder = (int) $project->images()->max('display_order');

        foreach ($files as $file) {
            if (!$file) {
                continue;
            }

            $path = $file->store('uploads/projects/gallery', 'public');

            $project->images()->create([
                'file_path' => $path,
                'display_order' => ++$nextOrder,
            ]);
        }
    }
}
