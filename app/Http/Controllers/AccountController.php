<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Booking;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;

class AccountController extends Controller
{
    public function index()
    {
        Session::forget('data');
        $user     = Auth::user(); 
        $bookings = Booking::where('user_id', $user->id)->with(['user','vehicle'])->orderBy('created_at', 'desc')->paginate(10);
        $from     = Carbon::now()->minute(0)->second(0)->format('Y-m-d\TH:i'); 
        $to       = Carbon::now()->addDay(3)->minute(0)->second(0)->format('Y-m-d\TH:i');
        $vehicles = Vehicle::filter(['from' => $from, 'to' => $to])->where('status', 1)->take(5)->get();
         
        return view('account.index', [
            'user'     => $user,
            'bookings' => $bookings,
            'vehicles' => $vehicles,
            'from'     => $from,
            'to'       => $to,
        ]);
    }

    public function update(Request $request)
    {
        $user = Auth::user(); 
        if($request->file('image')){
            $attributes = $request->validate([
                'image' => 'required|image|mimes:jpg,png,jpeg|max:2048',
            ]);
            $attributes['image'] = $request->file('image')->store('users');
            if($user->update($attributes)){
             return back()->with('status', 'Your profile image has been updated');
            }
            throw ValidationException::withMessages([
                'image' => 'Please select a correct image.'
            ]);
        }

        $attributes = $request->validate([
            'name'    => 'required|min:3|max:30',
            'phone'   => 'required|min:3|max:20',
            'address' => 'required|min:3'
        ]);

        $user->update($attributes);
        return back()->with('status', 'Your profile has been updated');
    }

    public function edit_password()
    {
        $user = Auth::user(); 
        return view('account.password', [
            'user' => $user
        ]);
    }

    public function update_password(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'current_password' => ['required'],
            'password'         => ['required', 'confirmed', 'min:6']
        ]);

        if(Hash::check($request->current_password, $user->password)){
            $user->update(['password' => Hash::make($request->password)]);
            return back()->with('status', 'Your password has been updated');
        }
        
        throw ValidationException::withMessages([
            'current_password' => 'Your current password does not match with our records'
        ]);
    } 
}
