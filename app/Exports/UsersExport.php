<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\{FromQuery, WithMapping, WithHeadings, ShouldAutoSize};

class UsersExport implements FromQuery, WithMapping, WithHeadings, ShouldAutoSize
{
    public function query()
    {
        return User::withCount('bookings');
    }

    public function map($user): array
    { 
        return [
            $user->id,
            $user->username,
            $user->name,
            $user->email,
            $user->address,
            $user->phone,
            $user->bookings_count,
            $user->created_at,
            $user->updated_at,
        ];
    }

    public function headings(): array
    {
        return [
            '#',
            'Username',
            'Name',
            'Email',
            'Address',
            'Phone',
            'Total Bookings',
            'Created At',
            'Updated At',
        ];
    }
}
