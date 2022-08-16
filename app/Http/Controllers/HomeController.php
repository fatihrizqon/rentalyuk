<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\{Booking, Vehicle, Category, User};

class HomeController extends Controller
{
    public function index()
    {
        $date = Carbon::now()->minute(0)->second(0)->format('Y-m-d\TH:i');
        $categories = Category::select('name', 'image')->get()->take(6);
        // $vehicles = Vehicle::withCount('bookings')->orderBy('category_id', 'asc')->get()->take(12);
        $vehicles = Vehicle::select('image')->withCount('bookings')->orderBy('category_id', 'asc')->get()->take(12);
        $users = User::select('id')->get();
        $bookings = Booking::select('id')->where('status', 1)->get();

        return view('home', [
            'date'       => $date,
            'categories' => $categories,
            'vehicles'   => $vehicles,
            'users'      => $users,
            'bookings'   => $bookings
        ]);
    } 
}
