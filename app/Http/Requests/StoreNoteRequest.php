<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreNoteRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'course_code' => 'required|string|max:20',
            'description' => 'required|string|max:500',
            'category' => 'nullable|string|max:50',
            'file' => 'required|file|mimes:pdf,doc,docx,ppt,pptx,txt|max:20480', // max 20MB
        ];
    }
}
