<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\{Booking, Vehicle, Category, User};
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $date = Carbon::now()->minute(0)->second(0)->format('Y-m-d\TH:i'); 

        return view('home', [
            'date'       => $date,
            'categories' => Category::withCount('bookings')->orderBy('bookings_count', 'desc')->get()->take(6),
            'vehicles'   => Vehicle::withCount('bookings')->orderBy('category_id', 'asc')->get()->take(12),
            'users'      => User::get(),
            'bookings'   => Booking::where('status', 1)->get()
        ]);
    }
}
