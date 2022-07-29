<?php

namespace App\Exports;

use App\Models\Vehicle; 
use Maatwebsite\Excel\Concerns\{FromQuery, WithMapping, WithHeadings, ShouldAutoSize};

class VehiclesExport implements FromQuery, WithMapping, WithHeadings, ShouldAutoSize
{
    protected $filters; 

    public function __construct($filters = null)
    {
        $this->filters = $filters; 
    }

    public function query()
    {
        if($this->filters['from'] && $this->filters['to']){
            return Vehicle::with('category')->withCount('bookings')->whereBetween('created_at', [$this->filters['from'], $this->filters['to']]);
        }elseif($this->filters['keywords']){
            return Vehicle::with('category')->withCount('bookings')->where('code', 'like', '%' . $this->filters['keywords'] . '%');
        }else{
            return Vehicle::with('category')->withCount('bookings');
        }
    }

    public function map($vehicle): array
    { 
        return [
            $vehicle->id,
            $vehicle->license_number,
            $vehicle->category->name,
            $vehicle->name,
            $vehicle->price, 
            $vehicle->bookings_count,
        ];
    }

    public function headings(): array
    {
        return [
            '#',
            'License Number',
            'Category',
            'Name',
            'Price', 
            'Total Bookings',
        ];
    }
}
