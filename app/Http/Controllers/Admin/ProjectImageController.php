<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProjectImageRequest;
use App\Models\Project;
use App\Models\ProjectImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProjectImageController extends Controller
{
    public function store(ProjectImageRequest $request, Project $project)
    {
        $path = $request->file('image')->store('uploads/projects', 'public');

        $nextOrder = ($project->images()->max('display_order') ?? 0) + 1;

        $image = $project->images()->create([
            'file_path' => $path,
            'caption' => $request->input('caption'),
            'display_order' => $nextOrder,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Image uploaded.',
            'data' => $image,
        ]);
    }

    public function destroy(Project $project, ProjectImage $image)
    {
        abort_if($image->project_id !== $project->id, 404);

        Storage::disk('public')->delete($image->file_path);
        $image->delete();

        return response()->json([
            'success' => true,
            'message' => 'Image removed.',
        ]);
    }

    public function reorder(Request $request, Project $project)
    {
        $order = $request->input('order', []);

        foreach ($order as $index => $imageId) {
            $project->images()->whereKey($imageId)->update(['display_order' => $index + 1]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Gallery order updated.',
        ]);
    }
}
