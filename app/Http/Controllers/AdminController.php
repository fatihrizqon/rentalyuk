<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Booking;
use App\Models\Vehicle;
use App\Models\Cashflow;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Services\AdminService;

class AdminController extends Controller
{
    private $date;
    private $from;
    private $to;

    public function __construct(Request $request)
    {
        $this->date = Carbon::now()->format('Y-m-d\TH:i');
        $this->from = $request->from;
        $this->to   = $request->to;
    }

    public function index(AdminService $adminService)
    {
        return view('admin.index', [
            'vehicles'   => Vehicle::select('id')->withCount('bookings')->get(),
            'bookings'   => Booking::sortable()->with(['user' => function($query){ return $query->select('id', 'name');},'vehicle' => function($query){ return $query->select('id', 'name');}])->orderBy('created_at', 'desc')->paginate(5),
            'cashflows'  => Cashflow::sortable()->paginate(5),
            'users'      => User::select('id')->get(),
            'bookingChart' => $adminService->bookingChart(),
            'categoryChart' => $adminService->categoryChart(),
        ]);
    }
    
    // public function booking(Request $request)
    // {
    //     $keywords = $request->keywords; 
    //     if($this->from && $this->to){ 
    //         $request->validate([
    //             'from' => 'required',
    //             'to'   => 'required|after:from',
    //         ]);
    //         $bookings = Booking::filter(['from' => $this->from, 'to' => $this->to])->sortable()->paginate(10); 
    //     }elseif($keywords){
    //         $request->validate([
    //             'keywords' => 'required'
    //         ]); 
    //         $bookings = Booking::filter(['keywords' => $keywords])->sortable()->paginate(10);
    //     }else{
    //         $bookings = Booking::sortable()->paginate(10);
    //     }
        
    //     return view('admin.booking.index', [
    //         'bookings' => $bookings,
    //         'date'     => $this->date,
    //         'from'     => $this->from,
    //         'to'       => $this->to
    //     ]);
    // }
    
    // public function cashflow()
    // {
    //     /**
    //      * Bikin MFC baru, Transaction
    //      * Tiap ada paid booking, masuk ke cash-in
    //      * Tiap ada pengeluaran, masuk ke cash-out
    //      */
    //     return view('admin.cashflow.index', [
    //         'bookings' => [],
    //         'date'     => Carbon::now()->format('Y-m-d\TH:i'),
    //         'from'     => '',
    //         'to'       => ''
    //     ]);
    // }
    
    // public function user()
    // {
    //     return view('admin.user.index');
    // }
}
