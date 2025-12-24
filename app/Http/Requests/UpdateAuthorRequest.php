<?php

namespace App\Http\Requests;

use App\Models\Author;
use Illuminate\Foundation\Http\FormRequest;

class UpdateAuthorRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $author = Author::find($this->route('author'))->first();
        return $this->user()->can('update', $author);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'oldName' => 'required|exists:authors,name',
            'newName' => 'required|unique:authors,name',
        ];
    }

    // public function messages(): array
    // {
    //     return [
    //         'oldName.required' => ''
    //     ];
    // }
}
