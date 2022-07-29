<?php

namespace App\Exports;

use App\Models\Booking;
use Maatwebsite\Excel\Concerns\{Exportable, FromQuery, WithMapping, WithHeadings, ShouldAutoSize};

class BookingsExport implements FromQuery, WithMapping, WithHeadings, ShouldAutoSize
{
    use Exportable;
    private $filters; 

    public function __construct($filters = null)
    {
        $this->filters = $filters; 
    }

    public function query()
    { 
        if($this->filters['from'] && $this->filters['to']){
            return Booking::query()->with('user', 'vehicle')->whereBetween('created_at', [$this->filters['from'], $this->filters['to']]);   
        }elseif($this->filters['keywords']){
            return Booking::query()->with('user', 'vehicle')->where('code', 'like', '%' . $this->filters['keywords'] . '%');
        }else{
            return Booking::query()->with('user', 'vehicle');   
        }
    }

    public function map($booking): array
    { 
        return [
            $booking->id,
            $booking->code,
            $booking->user->username,
            $booking->vehicle->license_number,
            $booking->vehicle->name,
            $booking->from,
            $booking->to,
            $booking->price,
            $booking->created_at,
            $booking->updated_at,
        ];
    }

    public function headings(): array
    {
        return [
            '#',
            'Booking Code',
            'Username',
            'Vehicle Number',
            'Vehicle Name',
            'Date of Booking',
            'Date of Return',
            'Price',
            'Created At',
            'Updated At',
        ];
    }
 
}
