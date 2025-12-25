<?php

namespace App\Http\Requests;

use App\Models\Cheatcode;
use Illuminate\Foundation\Http\FormRequest;

class StoreCheatcodeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('create', Cheatcode::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'description' => 'nullable|string',
            'code' => 'required|string'
        ];
    }
}
