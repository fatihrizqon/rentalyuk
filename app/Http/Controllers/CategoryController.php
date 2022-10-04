<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Exports\CategoriesExport;
use App\Services\CategoryService;
use Maatwebsite\Excel\Facades\Excel;
use Intervention\Image\Facades\Image;
use App\Http\Requests\CategoryRequest;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    private $service;
    public function __construct(CategoryService $service) {
        $this->service = $service;
    }

    public function index()
    {
        try {
            return view('admin.category.index', [
                'categories'=> $this->service->all()
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function store(CategoryRequest $request)
    {
        try {
            if($request->hasFile('image')){
                $image = Image::make($request->file('image'))->stream('webp', 100);
                $path = 'images/'.pathinfo($request->file('image')->hashName('images'), PATHINFO_FILENAME).'.'.'webp';
                Storage::disk('do')->put($path, $image, 'public');
            }

            $attributes = [
                'name' => $request->name,
                'image' => $request->file('image') ? $path : ''
            ];
            $this->service->create($attributes);
            return redirect('admin/categories')->with('status', 'a new category has been created.');
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function edit($id)
    { 
        return view('admin.category.edit', [
            'category' => Category::find($id)
        ]);
    }

    public function update($id, CategoryRequest $request)
    {
        try {
            if($request->hasFile('image')){
                $image = Image::make($request->file('image'))->stream('webp', 100);
                $path = 'images/'.pathinfo($request->file('image')->hashName('images'), PATHINFO_FILENAME).'.'.'webp';
                Storage::disk('do')->put($path, $image, 'public');
            }

            $attributes = [
                'name' => $request->name,
                'image' => $request->file('image') ? $path : ''
            ];
            $this->service->update($id, $attributes);
            return redirect('admin/categories')->with('status', 'selected category has been updated.');
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function export(Excel $excel)
    { 
        $filename = 'Category Data Export '.Carbon::now()->format('Y-m-d H:i:s').'.xlsx';
        return $excel::download(new CategoriesExport(), $filename);
    }

    public function destroy(Request $request)
    {
        try {
            $this->service->delete($request->category_id);
            return redirect('admin/categories')->with('status', 'selected category has been deleted.');
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }
}
