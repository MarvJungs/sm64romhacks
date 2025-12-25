<?php

namespace App\Http\Requests;

use App\Models\Cheatcode;
use Illuminate\Foundation\Http\FormRequest;

class UpdateCheatcodeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $cheatcode = Cheatcode::find($this->route('cheatcode'))->first();
        return $this->user()->can('update', $cheatcode);
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
