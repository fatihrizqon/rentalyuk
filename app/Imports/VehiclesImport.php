<?php

namespace App\Imports;

use App\Models\Vehicle;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\{ToModel, WithHeadingRow, WithValidation};

class VehiclesImport implements ToModel, WithHeadingRow, WithValidation 
{
 
    public function model(array $row)
    {
        return new Vehicle([
            'license_number' => $row['license_number'],
            'name'           => $row['name'],
            'price'          => $row['price'],
            'category_id'    => $row['category_id']
        ]);
    }

    public function rules(): array
    {
        return [
            'license_number' => Rule::unique('vehicles', 'license_number'),
        ];
    }

    public function customValidationMessages()
    {
        return [
            'license_number.unique' => 'Some data already exists in our records, please check again before re-importing your files.',
        ];
    }
}
