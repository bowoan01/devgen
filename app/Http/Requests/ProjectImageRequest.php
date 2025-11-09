<?php

namespace App\Http\Requests;

class ProjectImageRequest extends BaseFormRequest
{
    public function rules(): array
    {
        return [
            'image' => ['required', 'image', 'max:5120'],
            'caption' => ['nullable', 'string', 'max:190'],
        ];
    }
}
