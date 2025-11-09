<?php

namespace App\Http\Requests;

use App\Models\Project;
use Illuminate\Validation\Rule;

class ProjectRequest extends BaseFormRequest
{
    // App/Http/Requests/ProjectRequest.php
    protected function prepareForValidation(): void
    {
        $val = $this->input('is_featured');

        // Ambil nilai terakhir kalau terkirim sebagai array (mis: ['0','1'])
        if (is_array($val)) {
            $val = end($val);
        }

        // Normalisasi apapun -> 0/1
        // '1','true','on','yes' => 1 ; selain itu 0
        $bool = filter_var($val, FILTER_VALIDATE_BOOLEAN);
        $this->merge([
            'is_featured' => $bool ? 1 : 0,
        ]);
    }

    public function rules(): array
    {
        $projectId = $this->route('project')?->id;

        return [
            'title'              => ['required', 'string', 'max:190'],
            'slug'               => ['nullable', 'string', 'max:190', Rule::unique('projects', 'slug')->ignore($projectId)],
            'category'           => ['required', Rule::in(Project::CATEGORIES)],
            'summary'            => ['required', 'string', 'max:255'],
            'problem_text'       => ['nullable', 'string'],
            'solution_text'      => ['nullable', 'string'],
            'tech_stack'         => ['nullable', 'string'],
            'testimonial_author' => ['nullable', 'string', 'max:190'],
            'testimonial_text'   => ['nullable', 'string'],
            // nilai sudah 0/1 -> validasi cukup ini
            'is_featured'        => ['in:0,1'],
            'published_at'       => ['nullable', 'date'],
        ];
    }
}
