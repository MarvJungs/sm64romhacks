<?php

namespace App\Http\Requests;

use App\Models\Romhacktag;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRomhacktagRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $romhacktag = Romhacktag::find($this->route('romhacktag'))->first();
        return $this->user()->can('update', $romhacktag);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'oldName' => 'exists:romhacktags,name',
            'newName' => 'unique:romhacktags,name'
        ];
    }
}
