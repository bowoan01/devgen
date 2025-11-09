<?php

namespace App\Http\Requests;

use App\Models\Project;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProjectRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $categories = ['web', 'mobile', 'design'];
        $project = $this->route('project');
        $projectId = $project instanceof Project ? $project->getKey() : $project;

        return [
            'title' => ['required', 'string', 'max:180'],
            'slug' => ['nullable', 'string', 'max:190', Rule::unique('projects', 'slug')->ignore($projectId)],
            'category' => ['required', 'string', Rule::in($categories)],
            'summary' => ['nullable', 'string', 'max:500'],
            'problem_text' => ['nullable', 'string'],
            'solution_text' => ['nullable', 'string'],
            'tech_stack' => ['nullable', 'array'],
            'tech_stack.*' => ['nullable', 'string', 'max:120'],
            'cover_image' => ['nullable', 'image', 'max:4096'],
            'is_featured' => ['sometimes', 'boolean'],
            'published_at' => ['nullable', 'date'],
            'testimonial_author' => ['nullable', 'string', 'max:120'],
            'testimonial_text' => ['nullable', 'string'],
            'gallery' => ['nullable', 'array'],
            'gallery.*' => ['file', 'image', 'max:6144'],
            'remove_gallery' => ['nullable', 'array'],
            'remove_gallery.*' => ['integer', 'exists:project_images,id'],
        ];
    }
}
