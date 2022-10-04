<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class VehicleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'license_number' => ['required', 'min:3', 'max:9', Rule::unique('vehicles', 'name')->ignore($this->vehicle)],
            'name'           => ['required'],
            'image'          => ['file', 'mimes:svg,png,jpg,gif,avif', 'max:4096'],
            'price'          => ['required'],
            'category_id'    => ['required', 'exists:categories,id'],
        ];
    }
}
