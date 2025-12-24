<?php

namespace App\Http\Requests;

use App\Models\Romhack;
use Illuminate\Foundation\Http\FormRequest;

class StoreRomhackVersionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $hack = Romhack::find($this->route('hack'))->first();
        return $this->user()->can('createVersion', $hack);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'version.name' => 'required|string',
            'version.starcount' => 'required|integer|numeric|gte:0',
            'version.releasedate' => 'required|date',
            'version.filename' => 'required|file|filled|extensions:zip',
            'version.demo' => 'required|bool',
            'version.recommened' => 'required|bool',
            'version.author.name' => 'required|array|min:1',
            'version.author.name.*' => 'required|string'
        ];
    }
}
