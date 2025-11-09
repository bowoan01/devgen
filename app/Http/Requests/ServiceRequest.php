<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;

class ServiceRequest extends BaseFormRequest
{
    public function rules(): array
    {
        $serviceId = $this->route('service')?->id;

        return [
            'title' => ['required', 'string', 'max:190'],
            'slug' => ['nullable', 'string', 'max:190', Rule::unique('services', 'slug')->ignore($serviceId)],
            'excerpt' => ['required', 'string', 'max:255'],
            'body' => ['required', 'string'],
            'icon_class' => ['nullable', 'string', 'max:120'],
            'display_order' => ['nullable', 'integer', 'min:0'],
            'is_featured' => ['nullable', 'boolean'],
        ];
    }
}
