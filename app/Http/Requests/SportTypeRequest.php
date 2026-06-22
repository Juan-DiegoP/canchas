<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SportTypeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isAdmin() ?? false;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:100'],
            'icon' => ['nullable', 'string', 'max:255'],
        ];
    }
}