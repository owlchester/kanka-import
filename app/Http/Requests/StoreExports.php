<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\File;

class StoreExports extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'campaign' => ['required', 'integer', 'exists:campaigns,id'],
            'token' => ['required', 'integer', 'exists:campaign_imports,id'],
            'files' => 'required|array',
            'files.*' => [
                File::types(['zip']),
                'max:512000',
            ],
        ];
    }
}
