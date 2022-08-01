<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Exports\BookingsExport; 
use Illuminate\Support\Facades\{Auth, Session};
use App\Models\{Booking, Cashflow, Category, Vehicle};

class BookingController extends Controller
{
    private $date;
    private $from;
    private $to;
    private $duration;

    public function __construct(Request $request)
    {
        $this->date     = Carbon::now()->minute(0)->second(0)->format('Y-m-d\TH:i');
        $this->from     = Carbon::parse($request->from)->minute(0)->second(0)->format('Y-m-d\TH:i');
        $this->to       = Carbon::parse($request->to)->minute(0)->second(0)->format('Y-m-d\TH:i');
        $this->duration = Carbon::parse($this->from)->diffInDays(Carbon::parse($this->to), false);
    }

    public function index(Request $request)
    {
        $from     = $request->from;
        $to       = $request->to;
        $keywords = $request->keywords; 
 
        if($from && $to){  
            $request->validate([
                'from' => 'required',
                'to'   => 'required|after:from',
            ]);
            $bookings = Booking::whereBetween('created_at', [$from, $to])->with(['user','vehicle'])->orderBy('created_at', 'desc')->sortable()->paginate(10);              
        }elseif($keywords){
            $bookings = Booking::where('code', 'like', '%' . $keywords . '%')->with(['user','vehicle'])->orderBy('created_at', 'desc')->sortable()->paginate(10);           
        }else{
            $bookings = Booking::orderBy('created_at', 'desc')->sortable()->with(['user','vehicle'])->paginate(10);
        }
        
        return view('admin.booking.index', [
            'bookings' => $bookings,
            'date'     => $this->date,
            'from'     => $from,
            'to'       => $to,
            'keywords' => $keywords
        ]);
    }

    public function search(Request $request)
    {  
        Session::forget('data');
        $request->validate([
            'from' => 'required',
            'to'   => 'required|after:from',
        ]);

        $category   = $request->category;
        $vehicles   = Vehicle::filter(['from' => $this->from, 'to' => $this->to, 'category' => $category])
                             ->orderBy('id', 'asc')
                             ->where('status', 1)
                             ->paginate(10)->withQueryString();
                             
        Session::put('data', [
            'from'     => Carbon::parse($this->from)->minute(0)->second(0)->format('Y-m-d\TH:i'),
            'to'       => Carbon::parse($this->to)->minute(0)->second(0)->format('Y-m-d\TH:i'),
            'duration' => $this->duration
        ]);
        
        if($vehicles === [] || $this->duration <= 0){
            return redirect('booking')->with('info', 'There is unavailable vehicle at the moment, please try another date.');
        }
        
        return view('booking.vehicle', [
            'date'       => $this->date,
            'categories' => Category::get(),
            'vehicles'   => $vehicles,
            'from'       => $this->from,
            'to'         => $this->to,
            'duration'   => $this->duration
        ]);

        throw ValidationException::withMessages([
            'from' => 'Please select a valid date of booking.',
            'to'   => 'Please select a valid date of return.'
        ]);
    }
    
    public function create(Request $request)
    { 
        $user    = Auth::user();
        $vehicle = Vehicle::where('license_number', $request->license_number)->get()->first();
        $data    = Session::get('data');
 
        if($data){
            $data = [
                'user'     => $user,
                'vehicle'  => $vehicle,
                'user_id'  => Auth::user()->id,
                'from'     => $data['from'],
                'to'       => $data['to'],
                'duration' => $data['duration'],
                'price'    => $vehicle->price * $data['duration'],
            ]; 
        }else{
            $data = [
                'user'    => $user,
                'vehicle' => $vehicle,
                'user_id' => Auth::user()->id,
                'from'    => $this->from,
                'to'      => $this->to,
                'duration'=> $this->duration,
                'price'   => $vehicle->price * $this->duration
            ];
        }
        
        Session::put('data', $data);
        return view('booking.create', compact('data'));
    }
    
    public function store()
    {
        $data = Session::get('data');
          
        if(!$data){
            return redirect('booking')->with('info', 'Your booking already exists in our records.');;
        }

        $code               = Str::upper(Str::random(6)) . Carbon::now()->format('YmdHis');
        $data['vehicle_id'] = $data['vehicle']->id;
        $data['code']       = $code;

        try{ 
            $booking = Booking::create($data);
            if($booking){
                Session::forget('data');
                return redirect('account')->with('status', 'Congratulations, your booking has been saved.');
            }else{
                return redirect('booking')->with('warning', 'Booking Aborted, an error has been occured. Please try again.');
            }
        }catch(\Exception $e){
            return response()->json(['success' => false,'message' => $e], 403);
        }
    }
    
    public function show(Request $request)
    {
        Session::forget('data');
        $user = Auth::user();
        if($user->address == null || $user->phone == null){
            return redirect('account')->with('info', 'Please fill your address & phone number before continue to the Booking Process.');
        }
        $date = $this->date;
        return view('booking.index', compact('date'));  
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
        $request->validate([
            'code'  => 'required',
            'status'=> 'required',
        ]);

        try{ 
            $booking = Booking::where('code', $request->code)->get()->first();
            if($booking){
                if($request->status == 1){
                    Cashflow::create([
                        'code'    => $booking->code,
                        'name'    => 'Booking '.$booking->code,
                        'user_id' => Auth::user()->id,
                        'type'    => 'Debit',
                        'value'   => $booking->price
                    ]);
                }
                $booking->update(['status' => $request->status]);
                return redirect()->back()->with('status', 'Congratulations, selected booking has been updated.');
            }else{
                return redirect()->back()->with('warning', 'An error has been occured. Please try again.');
            }
        }catch(\Exception $e){
            return response()->json(['success' => false,'message' => $e], 403);
        }
    }
}
