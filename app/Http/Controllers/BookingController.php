<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Exports\BookingsExport; 
use App\Services\BookingService;
use App\Http\Requests\BookingRequest;
use Illuminate\Support\Facades\{Auth, Session};
use App\Models\{Booking, Cashflow, Category, Vehicle};

class BookingController extends Controller
{
    private $service;
    private $date;
    private $from;
    private $to;
    private $duration;

    public function __construct(BookingService $service, Request $request)
    {
        $this->service  = $service;
        $this->date     = Carbon::now()->minute(0)->second(0)->format('Y-m-d\TH:i');
        $this->from     = Carbon::parse($request->from)->minute(0)->second(0)->format('Y-m-d\TH:i');
        $this->to       = Carbon::parse($request->to)->minute(0)->second(0)->format('Y-m-d\TH:i');
        $this->duration = Carbon::parse($this->from)->diffInDays(Carbon::parse($this->to), false);
    }

    public function index(Request $request)
    {
        try {
            if($request->from && $request->to){
                $attributes = [
                    'from' => $this->from,
                    'to' => $this->to
                ];
                $bookings = $this->service->findByDate($attributes);
            }elseif($request->keywords){
                $bookings = $this->service->findByCode($request->keywords);
            }else{
                $bookings = $this->service->all();
            }
            
            return view('admin.booking.index', [
                'bookings' => $bookings,
                'date'     => $this->date,
                'from'     => $this->from,
                'to'       => $this->to,
                'keywords' => $request->keywords
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function search()
    {
        Session::forget('data');
        $user = Auth::user();
        if($user->address == null || $user->phone == null) return redirect('account')->with('info', 'please fill your address & phone number before continue to the Booking Process.');
        $date = $this->date;
        return view('booking.index', compact('date'));  
    }

    public function filter(BookingRequest $request)
    {
        try {
            $request['duration'] = $this->duration;
            $vehicles = $this->service->filter($request->all());
            return view('booking.vehicle', [
                'date'       => $this->date,
                'categories' => Category::select('id', 'name')->get(),
                'vehicles'   => $vehicles,
                'from'       => $this->from,
                'to'         => $this->to,
                'duration'   => $this->duration
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }
    
    public function create(Request $request)
    { 
        $data    = Session::get('data');
        $user    = Auth::user();
        $vehicle = Vehicle::where('license_number', $request->license_number)->get()->first();
        if($data){
            $data = [
                'vehicle'  => $vehicle,
                'user'     => $user,
                'user_id'  => $user->id,
                'from'     => $data['from'],
                'to'       => $data['to'],
                'duration' => $data['duration'],
                'price'    => $vehicle->price * $data['duration'],
            ];
        }else{
            $data = [
                'vehicle' => $vehicle,
                'user'    => $user,
                'user_id' => $user->id,
                'from'    => $this->from,
                'to'      => $this->to,
                'duration'=> $this->duration,
                'price'   => $vehicle->price * $this->duration
            ];
        }        
        Session::put('data', $data);
        return view('booking.create', ['data' => $data]);
    }
    
    public function store()
    {
        $data = Session::get('data');
        if(!$data) return redirect('booking')->with('info', 'your booking already exists in our records.');
        $data['vehicle_id'] = $data['vehicle']->id;

        try {
            $this->service->create($data);
            Session::forget('data');
            return redirect('account')->with('status', 'congratulations, your booking has been saved.');
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }
   
    public function export(Request $request)
    {
        $filename = 'Booking Data Export '.Carbon::now()->format('Y-m-d H:i:s').'.xlsx';
        $filters  = [
            'from'     => $request->from,
            'to'       => $request->to,
            'keywords' => $request->keywords,
        ];
        return (new BookingsExport($filters))->download($filename);
    }

    public function update(Request $request)
    { 
        $attributes = $request->validate([
            'code'  => ['required', 'string', 'exists:bookings,code'],
            'status'  => ['required'],
        ]);

        try {
            $this->service->update($attributes['code'], $attributes);
            return redirect()->back()->with('status', 'congratulations, selected booking has been updated.');
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }
}
