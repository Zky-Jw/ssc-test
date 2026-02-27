<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePersonRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'person' => 'required',
            'per_num' => 'required',
            'per_id' => 'required',
            'per_email' => 'required',
            'per_phone' => 'required',
            'per_group' => 'required',
            'updatedby' => 'required',
            'per_unit.id' => 'nullable|exists:units,id',
            'unit_position.name' => 'nullable|string',
        ];
    }

    public function withValidator($validator): void
    {
        $validator->sometimes('per_unit.id', 'required|exists:units,id', function ($input) {
            return $input->per_group === 'PEGAWAI';
        });

        $validator->sometimes('unit_position.name', 'required|string', function ($input) {
            return $input->per_group === 'PEGAWAI';
        });
    }
}
