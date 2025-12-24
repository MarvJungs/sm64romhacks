<?php

namespace App\Http\Requests;

use App\Models\Role;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRoleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $role = Role::find($this->route('role'))->first();
        return $this->user()->can('update', $role);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'oldName' => 'required|exists:roles,name',
            'newName' => 'required|unique:roles,name',
            'oldPriority' => 'required|integer|numeric|gte:0',
            'newPriority' => 'required|integer|numeric|gte:0'
        ];
    }
}
