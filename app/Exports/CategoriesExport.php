<?php

namespace App\Exports;

use App\Models\Category;
use Maatwebsite\Excel\Concerns\{FromQuery, WithMapping, WithHeadings, ShouldAutoSize};

class CategoriesExport implements FromQuery, WithMapping, WithHeadings, ShouldAutoSize
{
    public function query()
    {
        return Category::withCount(['vehicles', 'bookings']);
    }

    public function map($category): array
    { 
        return [
            $category->id,
            $category->name,
            $category->vehicles_count,
            $category->bookings_count
        ];
    }

    public function headings(): array
    {
        return [
            '#',
            'Name',
            'Total Vehicles',
            'Total Bookings'
        ];
    }
}
