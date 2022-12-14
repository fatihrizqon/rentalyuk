<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Admin;
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
            'bookingChart'  => $adminService->bookingChart(),
            'categoryChart' => $adminService->categoryChart(),
        ]);
    }

    public function create(Request $request)
    {
        try {
            $attributes = $request->validate(['user_id'  => ['required', 'exists:users,id']]);
            Admin::create($attributes);
            return redirect()->back()->with('status', 'a new user has been set as an administrator.');
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function delete(Request $request)
    {
        try {
            $attributes = $request->validate(['user_id'  => ['required', 'exists:users,id']]);
            Admin::findOrFail($attributes['user_id'])->delete();
            return redirect()->back()->with('status', 'an administrator has been deleted.');
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }
}
