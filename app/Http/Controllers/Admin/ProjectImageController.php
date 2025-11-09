<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\ProjectImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProjectImageController extends Controller
{
    public function reorder(Request $request, Project $project)
    {
        $data = $request->validate([
            'order' => ['required', 'array'],
            'order.*' => ['integer', 'exists:project_images,id'],
        ]);

        foreach ($data['order'] as $index => $id) {
            ProjectImage::query()
                ->where('project_id', $project->id)
                ->where('id', $id)
                ->update(['display_order' => $index + 1]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Gallery reordered successfully.',
        ]);
    }

    public function destroy(ProjectImage $image)
    {
        Storage::disk('public')->delete($image->file_path);
        $image->delete();

        return response()->json([
            'success' => true,
            'message' => 'Image removed successfully.',
        ]);
    }
}
