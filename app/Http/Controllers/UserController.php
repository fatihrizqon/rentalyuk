<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Exports\UsersExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $users = User::withCount(['bookings' => function($query){
            $query->where('status', 1);
        }])->sortable()->paginate(10);

        return view('admin.user.index', [
            'users' => $users,
        ]);
    }

    public function update(Request $request)
    {
        # code...
    }

    public function export(Request $request, Excel $excel)
    { 
        $filename = 'User Data Export '.Carbon::now()->format('Y-m-d H:i:s').'.xlsx';
        return $excel::download(new UsersExport(), $filename);
    }

    public function destroy(Request $request)
    {
        # code...
    }
}
