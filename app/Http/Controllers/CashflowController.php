<?php

namespace App\Http\Controllers;

use App\Exports\CashflowsExport;
use Carbon\Carbon;
use App\Models\Cashflow;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CashflowController extends Controller
{
    public function index(Request $request)
    {
        $date     = Carbon::now()->format('Y-m-d\TH:i');
        $from     = $request->from;
        $to       = $request->to;
        $keywords = $request->keywords; 
 
        if($from && $to){
            $request->validate([
                'from' => 'required',
                'to'   => 'required|after:from',
            ]);
            $cashflows = Cashflow::whereBetween('created_at', [$from, $to])->sortable()->paginate(10);              
        }elseif($keywords){
            $request->validate([
                'keywords' => 'required'
            ]); 
            $cashflows = Cashflow::where('code', 'like', '%' . $keywords . '%')->sortable()->paginate(10);           
        }else{
            $cashflows = Cashflow::sortable()->paginate(10);
        }
        
        return view('admin.cashflow.index', [
            'cashflows'=> $cashflows,
            'date'     => $date,
            'from'     => $from,
            'to'       => $to,
            'keywords' => $keywords
        ]);
    }

    public function store(Request $request)
    {
        $attributes = $request->validate([
            'name'  => ['required', 'min:3'],
            'type'  => ['required'],
            'value' => ['required', 'min:3']
        ]);
         
        try{
            $attributes['code']    = Str::upper(Str::random(6)) . Carbon::now()->format('YmdHis');
            $attributes['user_id'] = Auth::user()->id;
            $cashflow              = Cashflow::create($attributes);
            if($cashflow){
                return redirect()->back()->with('status', 'Congratulations, a new transaction has been created.');
            }else{
                return redirect()->back()->with('warning', 'An error has been occured. Please try again.');
            }
        }catch(\Exception $e){
            return response()->json(['success' => false,'message' => $e], 403);
        }
    }

    public function show(Request $request)
    {
        $date     = Carbon::now()->format('Y-m-d\TH:i');
        $from     = $request->from;
        $to       = $request->to;
        $keywords = $request->keywords; 
 
        if($from && $to){
            die('filter by date');
            $request->validate([
                'from' => 'required',
                'to'   => 'required|after:from',
            ]);
            $cashflows = Cashflow::whereBetween('created_at', [$from, $to])->sortable()->paginate(10);              
        }elseif($keywords){
            die('filter by kw');
            $request->validate([
                'keywords' => 'required'
            ]); 
            $cashflows = Cashflow::where('code', 'like', '%' . $keywords . '%')->sortable()->paginate(10);           
        }else{
            $cashflows = Cashflow::sortable()->paginate(10);
        }
        
        return view('admin.cashflow.index', [
            'cashflows' => $cashflows,
            'date'     => $date,
            'from'     => $from,
            'to'       => $to
        ]);
    }

    public function export(Request $request)
    {
        $filename = 'Cashflow Data Export '.Carbon::now()->format('Y-m-d H:i:s').'.xlsx';
        $filters  = [
            'from'     => $request->from,
            'to'       => $request->to,
            'keywords' => $request->keywords,
        ];
        return (new CashflowsExport($filters))->download($filename);
    }
}
