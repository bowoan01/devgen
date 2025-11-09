<?php

namespace App\Http\Requests;

use App\Models\Service;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateServiceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $service = $this->route('service');
        $serviceId = $service instanceof Service ? $service->getKey() : $service;

        return [
            'title' => ['required', 'string', 'max:150'],
            'slug' => ['nullable', 'string', 'max:160', Rule::unique('services', 'slug')->ignore($serviceId)],
            'excerpt' => ['nullable', 'string', 'max:280'],
            'body' => ['nullable', 'string'],
            'icon_class' => ['nullable', 'string', 'max:120'],
            'display_order' => ['nullable', 'integer', 'min:0'],
            'is_featured' => ['sometimes', 'boolean'],
        ];
    }
}
