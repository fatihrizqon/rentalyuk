<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Vehicle;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Exports\VehiclesExport;
use App\Imports\VehiclesImport;
use Maatwebsite\Excel\Facades\Excel;

class VehicleController extends Controller
{
    public function index(Request $request)
    {
        $date       = Carbon::now()->format('Y-m-d\TH:i');
        $from       = $request->from;
        $to         = $request->to;
        $keywords   = $request->keywords; 
        $categories = Category::get();
        $vehicles   = Vehicle::withCount(['bookings' => function($query){
            $query->where('status', 1);
        }])->get();
 
        return view('admin.vehicle.index', [
            'categories' => $categories,
            'vehicles'   => $vehicles,
            'date'       => $date,
            'from'       => $from,
            'to'         => $to,
            'keywords'   => $keywords
        ]);
    }

    public function create()
    {
        return view('admin.vehicle.create');
    }

    public function import(Request $request)
    {
        $request->validate([
            'import' => ['required', 'mimes:xlsx, csv, xls'],
        ]);
  
        try{
            $vehicles = Excel::import(new VehiclesImport, $request->file('import'));
            if($vehicles){ 
                return redirect('admin/vehicles')->with('status', 'Vehicles succesfully imported.');
            }else{
                return redirect('admin/vehicles')->with('warning', 'Failed to import vehicles, please try again.');
            }
        }catch(\Exception $e){
            return response()->json(['success' => false,'message' => $e], 403);
        }
    }

    public function export(Request $request, Excel $excel)
    { 
        $filename = 'Vehicle Data Export '.Carbon::now()->format('Y-m-d H:i:s').'.xlsx';
        $filters  = [
            'from'     => $request->from,
            'to'       => $request->to,
            'keywords' => $request->keywords,
        ];
         
        return $excel::download(new VehiclesExport($filters), $filename);
    }

    public function store(Request $request)
    {
        $attributes = $request->validate([
            'license_number' => ['required', 'min:3', 'max:9'],
            'name'           => ['required'],
            'image'          => ['file', 'mimes:svg,png,jpg,gif,avif', 'max:4096'],
            'price'          => ['required'],
            'category_id'    => ['required'],
        ]);

        $attributes['license_number'] = Str::upper($request->license_number);
        $attributes['name']           = Str::ucfirst($request->name);
        
        if($request->file('image')){
            $attributes['image'] = $request->file('image')->store('images');
        }

        try{
            $vehicle = Vehicle::create($attributes);
            if($vehicle){
                return redirect('admin/vehicles')->with('success', 'A New Vehicle has been created.');
            }else{
                return redirect('admin/vehicles')->with('warning', 'Failed to add New Record, please try again.');
            }
        }catch(\Exception $e){
            return response()->json(['success' => false,'message' => $e], 403);
        }
    }

    public function edit($id)
    { 
        $categories = Category::get();
        $vehicle = Vehicle::find($id);
        return view('admin.vehicle.edit', [
            'categories' => $categories,
            'vehicle' => $vehicle,
        ]);
    }

    public function update(Request $request, $id)
    { 
        $attributes = $request->validate([
            'license_number' => ['required', 'min:3', 'max:9'],
            'name'           => ['required'],
            'image'          => ['file', 'mimes:svg,png,jpg,gif,avif', 'max:4096'],
            'price'          => ['required'],
            'category_id'    => ['required'],
            'status'         => ['required'],
        ]);

        $attributes['license_number'] = Str::upper($attributes['license_number']);
        $attributes['name']           = Str::ucfirst($attributes['name']);

        if($request->file('image')){
            $attributes['image'] = $request->file('image')->store('images');
        }

        $vehicle = Vehicle::find($id);
        try{
            $vehicle = $vehicle->update($attributes); 
            
            if($vehicle){ 
                return redirect('admin/vehicles')->with('status', 'Selected vehicle has been updated.');
            }else{
                return redirect('admin/vehicles')->with('warning', 'Failed to update selected vehicle, please try again.');
            }
        }catch(\Exception $e){
            return response()->json(['success' => false,'message' => $e], 403);
        }
    }

    public function destroy(Request $request)
    {
        $vehicle = Vehicle::find($request->vehicle_id)->delete();
        if($vehicle){ 
            return redirect('admin/vehicles')->with('status', 'Selected vehicle has been deleted.');
        }else{
            return redirect('admin/vehicles')->with('warning', 'Failed to delete selected vehicle, please try again.');
        } 
    }
}
