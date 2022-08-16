<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\Booking;
use App\Models\Category;

class AdminService{

    public function bookingChart()
    {
        $data = Booking::where('status', 1)->select('id', 'created_at')->orderBy('created_at', 'desc')->get()->groupBy(function($booking){
            return Carbon::parse($booking->created_at)->format('M/y');
        })->take(12)->reverse();
        $bookingy = [];
        $bookingx = [];
        foreach($data as $month => $total){
            $bookingy[] = $month;
            $bookingx[] = count($total);
        }

        return $bookingChart = [
            'y' => $bookingy,
            'x' => $bookingx,
        ];
    }

    public function categoryChart()
    {
        $data = Category::get();
        $categoryx = [];
        $categoryy = [];
        foreach($data as $category){ 
            $categoryx[] = $category['name'];
            $categoryy[] = count($category['bookings']->where('status', 1));
        }

        return $categoryChart = [
            'x' => $categoryx,
            'y' => $categoryy,
        ];
    }
}
