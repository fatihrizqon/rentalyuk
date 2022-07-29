<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Administrator
{
    public function handle(Request $request, Closure $next)
    {
        $admin = Admin::where('user_id', Auth::user()->id)->get()->first();
        if($admin){
            return $next($request);
        }else{
            abort(403);
        }
    }
}
