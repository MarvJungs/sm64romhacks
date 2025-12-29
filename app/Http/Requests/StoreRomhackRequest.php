<?php

namespace App\Http\Requests;

use App\Models\Romhack;
use Illuminate\Foundation\Http\FormRequest;

class StoreRomhackRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('create', Romhack::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'romhack.name' => 'required|string|unique:romhacks,name',
            'romhack.description' => 'required|array',
            'romhack.description.blocks' => 'required|array|min:1',
            'romhack.description.time' => 'required|numeric',
            'romhack.description.version' => 'required|string',
            'romhack.videolink' => 'url|nullable',
            'romhack.tag' => 'nullable|array',
            'romhack.tag.name.*' => 'string',
            'romhack.version.name' => 'required|string',
            'romhack.version.releasedate' => 'required|date',
            'romhack.version.starcount' => 'required|integer|numeric|gte:0',
            'romhack.version.patchfile' => 'required|file|filled|extensions:zip',
            'romhack.version.author.name' => 'required|array|min:1',
            'romhack.version.author.name.*' => 'required|string|distinct:strict|distinct:ignore_case',
            'romhack.megapack' => 'boolean',
            'romhack.verified' => 'required|boolean'
            // 'romhack.image' => 'required|array|distinct|min:4',
            // 'romhack.image.*' => 'required|image'
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'romhack.name.required' => 'The Romhack name is required.',
            'romhack.name.unique' => 'The Romhack name has already been taken.',
            'romhack.name.string' => 'The Romhack name must be a string.',
            'romhack.description.blocks.min' => 'The Description cannot be empty.',
            'romhack.description.blocks.required' => 'The Description cannot be empty.',
            'romhack.videolink.url' => 'The Videolink is not valid.',
            'romhack.version.name.required' => 'The Version must have a name.',
            'romhack.version.releasedate.required' => 'No Releasedate was given.',
            'romhack.version.releasedate.date' => 'The Releasedate is not in a valid date format.',
            'romhack.version.starcount.required' => 'The starcount is required.',
            'romhack.version.starcount.numeric' => 'The starcount must be a number.',
            'romhack.version.starcount.gte' => 'The starcount must be greater or equal to 0.',
            'romhack.version.patchfile.required' => 'There was no patchfile attached.',
            'romhack.version.patchfile.file' => 'The submitted file was not a recognizeable fileformat.',
            'romhack.version.patchfile.extensions' => 'The attached file was not in a .zip-format.',
            'romhack.version.author.name.required' => 'An Authorname must be provided.',
            'romhack.version.author.name.min' => 'An Authorname must be provided.',
            'romhack.version.author.name.*.distinct' => 'The Authornames must be unique.'
        ];
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation(): void
    {
        $this->merge(
            [
                'romhack.description' => json_decode($this->romhack['description'], true),
                'romhack.verified' => $this->user()->hasRole('owner'),
            ]
        );
    }
}
