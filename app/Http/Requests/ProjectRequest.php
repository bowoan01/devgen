<?php

namespace App\Http\Requests;

use App\Models\Project;
use Illuminate\Validation\Rule;

class ProjectRequest extends BaseFormRequest
{
    public function rules(): array
    {
        $projectId = $this->route('project')?->id;

        return [
            'title' => ['required', 'string', 'max:190'],
            'slug' => ['nullable', 'string', 'max:190', Rule::unique('projects', 'slug')->ignore($projectId)],
            'category' => ['required', Rule::in(Project::CATEGORIES)],
            'summary' => ['required', 'string', 'max:255'],
            'problem_text' => ['nullable', 'string'],
            'solution_text' => ['nullable', 'string'],
            'tech_stack' => ['nullable', 'string'],
            'testimonial_author' => ['nullable', 'string', 'max:190'],
            'testimonial_text' => ['nullable', 'string'],
            'is_featured' => ['nullable', 'boolean'],
            'published_at' => ['nullable', 'date'],
        ];
    }
}
