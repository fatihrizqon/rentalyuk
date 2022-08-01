<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Exports\CategoriesExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $keywords = $request->keywords;
        
        if($keywords){
            $request->validate([
                'keywords' => 'required'
            ]); 
            $categories = Category::where('name', 'like', '%' . $keywords . '%')->withCount('vehicles')->sortable()->paginate(10);           
        }else{
            $categories = Category::withCount(['vehicles', 'bookings'])->sortable()->paginate(10);
        }

        return view('admin.category.index', [
            'categories'=> $categories,
            'keywords'  => $keywords
        ]);
    }

    public function store(Request $request)
    {
        $attributes = $request->validate([
            'name'  => ['required', 'min:3'],
            'image' => ['file', 'mimes:svg,png,jpg,gif', 'max:4096'],
        ]);

        $attributes['name'] = Str::ucfirst($attributes['name']);
        $attributes['slug'] = Str::slug($attributes['name']);

        if($request->file('image')){
            $attributes['image'] = $request->file('image')->store('images');
        }

        try{
            $category = Category::create($attributes);
            if($category){ 
                return redirect('admin/categories')->with('status', 'A New category has been created.');
            }else{
                return redirect('admin/categories')->with('warning', 'Failed to add new category, please try again.');
            }
        }catch(\Exception $e){
            return response()->json(['success' => false,'message' => $e], 403);
        }
    }

    public function edit($id)
    { 
        return view('admin.category.edit', [
            'category' => Category::find($id)
        ]);
    }

    public function update(Request $request, $id)
    {
        $attributes = $request->validate([
            'name'  => ['required', 'min:3'],
            'image' => ['file', 'mimes:svg,png,jpg,gif', 'max:4096'],
        ]);

        $attributes['name'] = Str::ucfirst($attributes['name']);

        if($request->file('image')){
            $attributes['image'] = $request->file('image')->store('images');
            // $attributes['image'] = Storage::put("images", $request->file('image')); # dropbox file storage
        }

        $category = Category::find($id);
        try{
            $category = $category->update($attributes); 
            
            if($category){ 
                return redirect('admin/categories')->with('status', 'Selected category has been updated.');
            }else{
                return redirect('admin/categories')->with('warning', 'Failed to update selected category, please try again.');
            }
        }catch(\Exception $e){
            return response()->json(['success' => false,'message' => $e], 403);
        }
    }

    public function export(Request $request, Excel $excel)
    { 
        $filename = 'Category Data Export '.Carbon::now()->format('Y-m-d H:i:s').'.xlsx';
        return $excel::download(new CategoriesExport(), $filename);
    }

    public function destroy(Request $request)
    {
        $category = Category::find($request->category_id)->delete();
        if($category){ 
            return redirect('admin/categories')->with('status', 'Selected category has been deleted.');
        }else{
            return redirect('admin/categories')->with('warning', 'Failed to delete selected category, please try again.');
        } 
    }
}
