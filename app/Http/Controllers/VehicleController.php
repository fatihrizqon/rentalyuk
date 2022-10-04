<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Vehicle;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Exports\VehiclesExport;
use App\Imports\VehiclesImport;
use App\Services\VehicleService;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Requests\VehicleRequest;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class VehicleController extends Controller
{
    private $service;
    private $date;

    public function __construct(VehicleService $service) {
        $this->service = $service;
        $this->date = Carbon::now()->format('Y-m-d\TH:i');
    }

    public function index(Request $request)
    {
        try {
            return view('admin.vehicle.index', [
                'vehicles'   => $this->service->all(),
                'categories' => Category::select('id', 'name')->get()
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
        // $from       = $request->from;
        // $to         = $request->to;
        // $keywords   = $request->keywords; 
        // $categories = Category::get();
        // $vehicles   = Vehicle::withCount(['bookings' => function($query){
        //     $query->where('status', 1);
        // }])->get();
 
        // return view('admin.vehicle.index', [
        //     'categories' => $categories,
        //     'vehicles'   => $vehicles,
        //     'date'       => $this->date,
        //     'from'       => $from,
        //     'to'         => $to,
        //     'keywords'   => $keywords
        // ]);
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

    public function store(VehicleRequest $request)
    {
        try {
            if($request->hasFile('image')){
                $image = Image::make($request->file('image'))->stream('webp', 100);
                $path = 'images/'.pathinfo($request->file('image')->hashName('images'), PATHINFO_FILENAME).'.'.'webp';
                Storage::disk('do')->put($path, $image, 'public');
            }

            $attributes = [
                'license_number' => $request->license_number,
                'name' => $request->name,
                'image' => $request->file('image') ? $path : '',
                'price' => $request->price,
                'category_id' => $request->category_id,
            ];

            $this->service->create($attributes);
            return redirect('admin/vehicles')->with('status', 'a new vehicle has been created.');
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
        // $attributes = $request->validate([
        //     'license_number' => ['required', 'min:3', 'max:9'],
        //     'name'           => ['required'],
        //     'image'          => ['file', 'mimes:svg,png,jpg,gif,avif', 'max:4096'],
        //     'price'          => ['required'],
        //     'category_id'    => ['required'],
        // ]);
        
        // if($request->file('image')){
        //     $path = Storage::disk('do')->putFile('images', $request->file('image'), 'public');
        //     $attributes['image'] = $path;
        // }

        // try{
        //     $vehicle = Vehicle::create($attributes);
        //     if($vehicle){
        //         return redirect('admin/vehicles')->with('success', 'A New Vehicle has been created.');
        //     }else{
        //         return redirect('admin/vehicles')->with('warning', 'Failed to add New Record, please try again.');
        //     }
        // }catch(\Exception $e){
        //     return response()->json(['success' => false,'message' => $e], 403);
        // }
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

    public function update($id, VehicleRequest $request)
    {        
        try {
            if($request->hasFile('image')){
                $image = Image::make($request->file('image'))->stream('webp', 100);
                $path = 'images/'.pathinfo($request->file('image')->hashName('images'), PATHINFO_FILENAME).'.'.'webp';
                Storage::disk('do')->put($path, $image, 'public');
            }

            $attributes = [
                'license_number' => $request->license_number,
                'name' => $request->name,
                'image' => $request->file('image') ? $path : '',
                'price' => $request->price,
                'category_id' => $request->category_id,
            ];

            $this->service->update($id, $attributes);
            return redirect('admin/vehicles')->with('status', 'selected vehicle has been updated.');
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
        // $attributes = $request->validate([
        //     'license_number' => ['required', 'min:3', 'max:9'],
        //     'name'           => ['required'],
        //     'image'          => ['file', 'mimes:svg,png,jpg,gif,avif', 'max:4096'],
        //     'price'          => ['required'],
        //     'category_id'    => ['required'],
        //     'status'         => ['required'],
        // ]);

        // if($request->file('image')){
        //     $path = Storage::disk('do')->putFile('images', $request->file('image'), 'public');
        //     $attributes['image'] = $path;
        // }

        // $vehicle = Vehicle::find($id);
        // try{
        //     $vehicle = $vehicle->update($attributes); 
            
        //     if($vehicle){ 
        //         return redirect('admin/vehicles')->with('status', 'Selected vehicle has been updated.');
        //     }else{
        //         return redirect('admin/vehicles')->with('warning', 'Failed to update selected vehicle, please try again.');
        //     }
        // }catch(\Exception $e){
        //     return response()->json(['success' => false,'message' => $e], 403);
        // }
    }

    public function destroy(Request $request)
    {
        try {
            $this->service->delete($request->vehicle_id);
            return redirect('admin/vehicles')->with('status', 'selected category has been deleted.');
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
        // $vehicle = Vehicle::find($request->vehicle_id)->delete();
        // if($vehicle){ 
        //     return redirect('admin/vehicles')->with('status', 'Selected vehicle has been deleted.');
        // }else{
        //     return redirect('admin/vehicles')->with('warning', 'Failed to delete selected vehicle, please try again.');
        // } 
    }
}
